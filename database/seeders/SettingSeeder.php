<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'shop_name', 'value' => 'Coffee Shop', 'group' => 'general'],
            ['key' => 'shop_tagline', 'value' => 'Secangkir Kebahagiaan', 'group' => 'general'],
            ['key' => 'shop_description', 'value' => 'Coffee shop terbaik di kota kami dengan biji kopi pilihan.', 'group' => 'general'],
            ['key' => 'shop_address', 'value' => 'Jl. Kopi No. 1, Jakarta', 'group' => 'general'],
            ['key' => 'shop_phone', 'value' => '08123456789', 'group' => 'general'],
            ['key' => 'shop_email', 'value' => 'hello@coffeeshop.com', 'group' => 'general'],
            ['key' => 'shop_hours', 'value' => '07:00 - 22:00', 'group' => 'general'],
            // Appearance
            ['key' => 'primary_color', 'value' => '#6F4E37', 'group' => 'appearance'],
            ['key' => 'hero_image', 'value' => '', 'group' => 'appearance'],
            // Contact
            ['key' => 'whatsapp_admin', 'value' => '08123456789', 'group' => 'contact'],
            ['key' => 'instagram', 'value' => '@coffeeshop', 'group' => 'contact'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}