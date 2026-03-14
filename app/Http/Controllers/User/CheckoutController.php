<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\QrisSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')
                ->with('error', 'Keranjang kamu kosong. Silakan pilih menu terlebih dahulu.');
        }

        // ✅ Re-fetch harga terbaru dari DB saat tampil checkout
        // Sehingga jika admin ubah harga, subtotal di halaman checkout sudah akurat
        $productIds = array_column($cart, 'product_id');
        $latestPrices = Product::whereIn('id', $productIds)->pluck('price', 'id');

        foreach ($cart as $key => $item) {
            if (isset($latestPrices[$item['product_id']])) {
                $cart[$key]['price'] = $latestPrices[$item['product_id']];
            }
        }

        // Simpan cart dengan harga terbaru ke session
        session()->put('cart', $cart);

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $bankAccounts = BankAccount::active()->get();
        $activeQris = QrisSetting::getActive();
        $hasQris = $activeQris !== null;

        return view('user.checkout.index', compact('cart', 'subtotal', 'bankAccounts', 'activeQris', 'hasQris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:dine_in,takeaway',
            'table_number' => 'required_if:order_type,dine_in|nullable|string|max:10',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cash,transfer,qris',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang kamu kosong.');
        }

        // Validasi ketersediaan semua item sebelum mulai transaksi
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || !$product->is_available) {
                return back()->with('error', "{$item['name']} tidak lagi tersedia.");
            }
            if ($product->stock < $item['quantity']) {
                return back()->with('error', "Stok {$item['name']} hanya tersisa {$product->stock}.");
            }
        }

        // Hitung subtotal dengan harga terbaru dari DB (bukan dari session)
        $productIds = array_column($cart, 'product_id');
        $latestPrices = Product::whereIn('id', $productIds)->pluck('price', 'id');
        $subtotal = 0;

        foreach ($cart as $item) {
            $price = $latestPrices[$item['product_id']] ?? $item['price'];
            $subtotal += $price * $item['quantity'];
        }

        try {
            DB::beginTransaction();

            // Buat Order
            $order = Order::create([
                'order_code' => Order::generateOrderCode(),
                'queue_number' => Order::generateQueueNumber(),
                'order_type' => $request->order_type,
                'table_number' => $request->order_type === 'dine_in' ? $request->table_number : null,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'subtotal' => $subtotal,
                'total_amount' => $subtotal,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            // Buat Order Items + kurangi stok secara atomic
            foreach ($cart as $item) {
                $price = $latestPrices[$item['product_id']] ?? $item['price'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_price' => $price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $price * $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                ]);

                // ✅ Fix race condition: decrement hanya jika stok masih mencukupi
                $affected = Product::where('id', $item['product_id'])
                    ->where('stock', '>=', $item['quantity'])
                    ->decrement('stock', $item['quantity']);

                if (!$affected) {
                    throw new \Exception("Stok {$item['name']} habis saat proses berlangsung. Silakan periksa keranjang kamu.");
                }
            }

            // ✅ Fix: hapus variable $paymentStatus yang redundant (keduanya 'pending')
            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'amount' => $subtotal,
                'status' => 'pending',
            ]);

            DB::commit();

            // Kosongkan cart
            session()->forget('cart');

            // ✅ Graceful broadcast — tidak crash jika event belum dibuat
            if (class_exists(\App\Events\OrderPlaced::class)) {
                broadcast(new \App\Events\OrderPlaced($order->load('items')));
            }

            return redirect()->route('order.success', $order->order_code);

        }
        catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('order.failed')
                ->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.')
                ->with('failed_cart', $cart);
        }
    }

    public function uploadProof(Request $request, Order $order)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:3048',
        ]);

        if (!$order->payment) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        // ✅ Guard: cash tidak perlu upload bukti
        if ($order->payment->method === 'cash') {
            return back()->with('error', 'Pembayaran tunai tidak memerlukan upload bukti pembayaran.');
        }

        // ✅ Guard: jangan upload jika sudah verified
        if ($order->payment->status === 'verified') {
            return back()->with('error', 'Pembayaran sudah diverifikasi, tidak perlu upload ulang.');
        }

        // Hapus bukti lama jika ada
        if ($order->payment->proof_image) {
            Storage::disk('public')->delete($order->payment->proof_image);
        }

        $path = $request->file('proof_image')->store('payment-proofs', 'public');

        $order->payment->update([
            'proof_image' => $path,
            'status' => 'uploaded',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}