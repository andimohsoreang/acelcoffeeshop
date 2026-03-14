<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        // Produk featured untuk landing page
        $featuredProducts = Product::with('category')
            ->available()
            ->featured()
            ->take(6)
            ->get();

        // Semua kategori aktif
        $categories = Category::active()->get();

        // Setting toko
        $shopName = Setting::get('shop_name', 'Coffee Shop');
        $shopTagline = Setting::get('shop_tagline', 'Secangkir Kebahagiaan');
        $shopDescription = Setting::get('shop_description', '');
        $shopPhone = Setting::get('whatsapp_admin', '');

        return view('user.home', compact(
            'featuredProducts',
            'categories',
            'shopName',
            'shopTagline',
            'shopDescription',
            'shopPhone'
        ));
    }
}