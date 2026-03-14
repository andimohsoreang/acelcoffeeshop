@echo off
cd ..
title Injeksi Data Awal (Seeder)
color 0D
echo ========================================================
echo            MENYUNTIKKAN DATA AWAL (SEEDER)
echo ========================================================
echo Script ini akan memasukkan data bawaan (seperti akun 
echo Admin, Kategori, atau Produk default) ke database.
echo ========================================================
echo.

call php artisan db:seed
echo.
echo ========================================================
echo SUKSES! Data awal berhasil disuntikkan.
echo ========================================================
pause
