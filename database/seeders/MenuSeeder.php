<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data to avoid conflicts mapping to "lama tidak digunakan lagi"
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        Category::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            [
                "category" => "Indomie",
                "icon" => "🍜",
                "items" => [
                    ["name" => "Indomie Polos Goreng", "price" => 7000],
                    ["name" => "Indomie Polos Rendang", "price" => 7000],
                    ["name" => "Indomie Polos Aceh", "price" => 7000],
                    ["name" => "Indomie Polos Kari Ayam", "price" => 7000],
                    ["name" => "Indomie Polos Soto Mie", "price" => 7000],
                    ["name" => "Indomie Nyemek", "price" => 13000],
                    ["name" => "Indomie Nyemek Komplit", "price" => 19000],
                    ["name" => "Indomie Kornet", "price" => 11000],
                    ["name" => "Indomie Telor", "price" => 10000],
                    ["name" => "Indomie Telor Dadar", "price" => 11000],
                    ["name" => "Indomie Telor + Sosis", "price" => 12000],
                    ["name" => "Indomie Telor + Keju", "price" => 13000],
                    ["name" => "Indomie Telor + Kornet", "price" => 14000],
                    ["name" => "Indomie Double", "price" => 14000],
                    ["name" => "Indomie Double + Telor", "price" => 17000],
                    ["name" => "Indomie Telor + Kornet + Keju", "price" => 17000],
                    ["name" => "Indomie Telor + Kornet + Sosis", "price" => 16000]
                ]
            ],
            [
                "category" => "Makanan & Topping",
                "icon" => "🍳",
                "items" => [
                    ["name" => "Nasi Dadar Sambel", "price" => 8000],
                    ["name" => "Nasi Dadar Kornet", "price" => 12000],
                    ["name" => "Omelet Indomie", "price" => 12000],
                    ["name" => "Tambah Nasi", "price" => 4000],
                    ["name" => "Topping Telor Biasa", "price" => 3000],
                    ["name" => "Topping Telor Dadar", "price" => 4000],
                    ["name" => "Topping Kornet", "price" => 4000],
                    ["name" => "Topping Sosis", "price" => 2000],
                    ["name" => "Topping Keju", "price" => 3000]
                ]
            ],
            [
                "category" => "Snack (Roti & Pancong)",
                "icon" => "🍞",
                "items" => [
                    ["name" => "Roti Bakar (Coklat/Keju/Tiramisu/GT/Taro)", "price" => 10000],
                    ["name" => "Roti Bakar Coklat Keju", "price" => 13000],
                    ["name" => "Roti Bakar Tiramisu Keju", "price" => 13000],
                    ["name" => "Roti Bakar Green Tea Keju", "price" => 13000],
                    ["name" => "Roti Bakar Taro Keju", "price" => 13000],
                    ["name" => "Pancong Coklat / Keju", "price" => 7000],
                    ["name" => "Pancong Susu (Coklat/Keju)", "price" => 8000],
                    ["name" => "Pancong Coklat Keju Susu", "price" => 9000],
                    ["name" => "Pancong (Tiramisu/GT/Taro)", "price" => 9000]
                ]
            ],
            [
                "category" => "Minuman",
                "icon" => "🥤",
                "items" => [
                    ["name" => "Soda Susu", "price_reg" => 12000, "price_susu" => null],
                    ["name" => "Teh Tawar (Panas/Es)", "price_reg" => 4000, "price_susu" => 6000],
                    ["name" => "Teh Manis (Panas/Es)", "price_reg" => 4000, "price_susu" => 6000],
                    ["name" => "Nutrisari", "price_reg" => 5000, "price_susu" => 7000],
                    ["name" => "Ovaltine", "price_reg" => 7000, "price_susu" => 9000],
                    ["name" => "Teh Tarik", "price_reg" => 7000, "price_susu" => 9000],
                    ["name" => "Milo", "price_reg" => 7000, "price_susu" => 9000],
                    ["name" => "Drink Beng-Beng", "price_reg" => 7000, "price_susu" => 9000],
                    ["name" => "Chocolatos Matcha", "price_reg" => 7000, "price_susu" => 9000],
                    ["name" => "Susu Bendera", "price_reg" => 5000, "price_susu" => null],
                    ["name" => "Kuku Bima / Xtra Joss", "price_reg" => 5000, "price_susu" => 7000],
                    ["name" => "Adem Sari", "price_reg" => 6000, "price_susu" => null],
                    ["name" => "Susu Jahe", "price_reg" => 5000, "price_susu" => null],
                    ["name" => "Air Mineral", "price_reg" => 3000, "price_susu" => null]
                ]
            ],
            [
                "category" => "Kopi",
                "icon" => "☕",
                "items" => [
                    ["name" => "Kopi Tubruk", "price_reg" => 5000, "price_susu" => 7000],
                    ["name" => "Es Kopi Susu Abang", "price_reg" => 8000, "price_susu" => null],
                    ["name" => "Nescafe Classic", "price_reg" => 5000, "price_susu" => 7000],
                    ["name" => "Nescafe Ice Roast", "price_reg" => 5000, "price_susu" => 7000],
                    ["name" => "Kopi Kapal Api", "price_reg" => 5000, "price_susu" => 7000],
                    ["name" => "Kopi ABC", "price_reg" => 5000, "price_susu" => 7000],
                    ["name" => "White Coffee", "price_reg" => 5000, "price_susu" => 7000],
                    ["name" => "Indocafe", "price_reg" => 5000, "price_susu" => 7000],
                    ["name" => "Good Day Freeze", "price_reg" => 6000, "price_susu" => 8000],
                    ["name" => "Good Day Variant", "price_reg" => 7000, "price_susu" => 9000]
                ]
            ]
        ];

        foreach ($data as $catIndex => $categoryData) {
            $category = Category::create([
                'name' => $categoryData['category'],
                'slug' => Str::slug($categoryData['category']),
                'icon' => $categoryData['icon'],
                'sort_order' => $catIndex + 1,
                'is_active' => true,
            ]);

            foreach ($categoryData['items'] as $item) {
                // If it's a simple price
                if (isset($item['price'])) {
                    Product::create([
                        'category_id' => $category->id,
                        'name' => $item['name'],
                        'slug' => Str::slug($item['name'] . '-' . Str::random(4)),
                        'price' => $item['price'],
                        'stock' => 100,
                        'is_available' => true,
                        'is_featured' => false,
                    ]);
                } else {
                    // It has price_reg and possibly price_susu
                    // Add Regular version
                    Product::create([
                        'category_id' => $category->id,
                        'name' => $item['name'],
                        'slug' => Str::slug($item['name'] . '-' . Str::random(4)),
                        'price' => $item['price_reg'],
                        'stock' => 100,
                        'is_available' => true,
                        'is_featured' => false,
                    ]);

                    // Add Susu version if exists
                    if (isset($item['price_susu']) && $item['price_susu'] !== null) {
                        $susuName = $item['name'] . ' Susu';
                        Product::create([
                            'category_id' => $category->id,
                            'name' => $susuName,
                            'slug' => Str::slug($susuName . '-' . Str::random(4)),
                            'price' => $item['price_susu'],
                            'stock' => 100,
                            'is_available' => true,
                            'is_featured' => false,
                        ]);
                    }
                }
            }
        }
    }
}
