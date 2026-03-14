<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    /**
     * Dapatkan nilai setting berdasarkan key.
     * Secara otomatis di-cache selamanya agar aplikasi tidak lambat.
     * Jika terjadi perubahan di DB (SettingController), kita wajib menghapus cache.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }
}
