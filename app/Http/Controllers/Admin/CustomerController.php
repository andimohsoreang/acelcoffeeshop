<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = Order::select(
            'customer_phone',
            DB::raw('MAX(customer_name) as customer_name'),
            DB::raw('COUNT(id) as total_orders'),
            DB::raw('SUM(total_amount) as total_spent'),
            DB::raw('MAX(created_at) as last_order_date')
        )
        ->whereNotNull('customer_phone')
        ->where('customer_phone', '!=', '')
        ->where('status', '!=', 'cancelled');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $customers = $query->groupBy('customer_phone')
            ->orderByDesc('last_order_date')
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.customers.index', compact('customers'));
    }

    public function show($phone)
    {
        $customer = Order::select(
            'customer_phone',
            DB::raw('MAX(customer_name) as customer_name'),
            DB::raw('COUNT(id) as total_orders'),
            DB::raw('SUM(total_amount) as total_spent'),
            DB::raw('MAX(created_at) as last_order_date')
        )
        ->where('customer_phone', $phone)
        ->where('status', '!=', 'cancelled')
        ->groupBy('customer_phone')
        ->firstOrFail();

        $orders = Order::where('customer_phone', $phone)
            ->with(['payment'])
            ->latest()
            ->paginate(15);

        return view('admin.customers.show', compact('customer', 'orders'));
    }
}
