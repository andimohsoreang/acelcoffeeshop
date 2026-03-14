<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // KOPI
            [
                'category' => 'kopi',
                'name' => 'Espresso',
                'desc' => 'Kopi espresso murni dengan crema tebal, cocok untuk pecinta kopi sejati.',
                'price' => 18000,
                'stock' => 50,
                'featured' => true,
            ],
            [
                'category' => 'kopi',
                'name' => 'Cappuccino',
                'desc' => 'Perpaduan sempurna espresso, susu steamed, dan foam susu yang lembut.',
                'price' => 28000,
                'stock' => 50,
                'featured' => true,
            ],
            [
                'category' => 'kopi',
                'name' => 'Latte',
                'desc' => 'Espresso dengan banyak susu steamed, ringan dan creamy.',
                'price' => 30000,
                'stock' => 50,
                'featured' => false,
            ],
            [
                'category' => 'kopi',
                'name' => 'V60 Manual Brew',
                'desc' => 'Pour over dengan biji kopi single origin pilihan, diseduh dengan teliti.',
                'price' => 35000,
                'stock' => 30,
                'featured' => true,
            ],
            [
                'category' => 'kopi',
                'name' => 'Cold Brew',
                'desc' => 'Kopi seduhan dingin 12 jam, smooth dengan rasa yang kompleks.',
                'price' => 32000,
                'stock' => 20,
                'featured' => false,
            ],

            // MINUMAN
            [
                'category' => 'minuman',
                'name' => 'Matcha Latte',
                'desc' => 'Matcha premium Jepang dengan susu segar, manis dan segar.',
                'price' => 32000,
                'stock' => 40,
                'featured' => true,
            ],
            [
                'category' => 'minuman',
                'name' => 'Thai Tea',
                'desc' => 'Teh Thailand asli dengan susu kental manis, segar dan manis.',
                'price' => 22000,
                'stock' => 40,
                'featured' => false,
            ],
            [
                'category' => 'minuman',
                'name' => 'Taro Milk Tea',
                'desc' => 'Minuman taro lembut dengan tekstur creamy yang memanjakan.',
                'price' => 28000,
                'stock' => 35,
                'featured' => false,
            ],

            // MAKANAN
            [
                'category' => 'makanan',
                'name' => 'Croissant Butter',
                'desc' => 'Croissant berlapis mentega dengan tekstur renyah di luar lembut di dalam.',
                'price' => 25000,
                'stock' => 20,
                'featured' => true,
            ],
            [
                'category' => 'makanan',
                'name' => 'Avocado Toast',
                'desc' => 'Roti sourdough dengan alpukat segar, telur poached dan bumbu rahasia.',
                'price' => 45000,
                'stock' => 15,
                'featured' => false,
            ],
            [
                'category' => 'makanan',
                'name' => 'Sandwich Chicken',
                'desc' => 'Sandwich dengan ayam panggang, sayuran segar dan saus spesial.',
                'price' => 38000,
                'stock' => 20,
                'featured' => false,
            ],

            // DESSERT
            [
                'category' => 'dessert',
                'name' => 'Tiramisu',
                'desc' => 'Dessert Italia klasik dengan mascarpone, kopi dan cocoa powder.',
                'price' => 35000,
                'stock' => 15,
                'featured' => true,
            ],
            [
                'category' => 'dessert',
                'name' => 'Brownies',
                'desc' => 'Brownies cokelat fudgy dengan topping walnut renyah.',
                'price' => 22000,
                'stock' => 25,
                'featured' => false,
            ],
        ];

        foreach ($products as $p) {
            $category = Category::where('slug', $p['category'])->first();
            Product::create([
                'category_id' => $category->id,
                'name' => $p['name'],
                'slug' => \Illuminate\Support\Str::slug($p['name']),
                'description' => $p['desc'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'is_available' => true,
                'is_featured' => $p['featured'],
            ]);
        }
    }
}