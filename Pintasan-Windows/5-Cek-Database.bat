@echo off
cd ..
title Cek Koneksi Database
color 0E
echo ========================================================
echo        MEMERIKSA KONEKSI DATABASE (MYSQL/SQLITE)
echo ========================================================
echo Script ini akan mengecek apakah aplikasi Laravel sudah
echo terhubung dengan sukses ke Database XAMPP.
echo ========================================================
echo.

call php artisan db:show
echo.
echo ========================================================
echo Cek tabel "Connections". Jika ada nama database Anda,
echo berarti sistem sudah sukses terhubung!
echo ========================================================
pause
