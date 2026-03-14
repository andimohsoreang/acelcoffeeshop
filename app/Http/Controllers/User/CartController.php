<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Ambil cart dari session
    private function getCart(): array
    {
        return session()->get('cart', []);
    }

    // Simpan cart ke session
    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    // Hitung total item di cart
    private function cartCount(): int
    {
        return array_sum(array_column($this->getCart(), 'quantity'));
    }

    public function index()
    {
        $cart = $this->getCart();
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return view('user.cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
            'notes' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek ketersediaan produk
        if (!$product->is_available || $product->stock <= 0) {
            return back()->with('error', 'Produk tidak tersedia saat ini.');
        }

        $cart = $this->getCart();
        $key = $product->id;

        if (isset($cart[$key])) {
            // Cek stok tidak melebihi
            $newQty = $cart[$key]['quantity'] + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', "Stok {$product->name} hanya tersisa {$product->stock}.");
            }
            $cart[$key]['quantity'] = $newQty;

            // ✅ Fix: update notes juga jika user mengirim catatan baru
            if ($request->filled('notes')) {
                $cart[$key]['notes'] = $request->notes;
            }
        }
        else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price, // snapshot harga saat ditambah
                'image' => $product->image_url,
                'quantity' => $request->quantity,
                'notes' => $request->notes,
            ];
        }

        $this->saveCart($cart);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => "{$product->name} ditambahkan ke keranjang.",
                'count' => $this->cartCount(),
            ]);
        }

        return back()->with('success', "{$product->name} ditambahkan ke keranjang.");
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart = $this->getCart();

        if (!isset($cart[$id])) {
            return back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        // Cek stok
        $product = Product::find($id);
        if ($product && $request->quantity > $product->stock) {
            return back()->with('error', "Stok {$product->name} hanya tersisa {$product->stock}.");
        }

        $cart[$id]['quantity'] = $request->quantity;
        $this->saveCart($cart);

        if ($request->expectsJson()) {
            $subtotal = $cart[$id]['price'] * $cart[$id]['quantity'];
            $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
            return response()->json([
                'subtotal' => $subtotal,
                'total' => $total,
                'count' => $this->cartCount(),
            ]);
        }

        return back();
    }

    public function remove(Request $request, int $id)
    {
        $cart = $this->getCart();
        unset($cart[$id]);
        $this->saveCart($cart);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Item dihapus dari keranjang.',
                'count' => $this->cartCount(),
            ]);
        }

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}