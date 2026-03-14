@echo off
cd ..
title Coffee Shop - Instalasi Keseluruhan
color 0A
echo ========================================================
echo        INSTALASI PROYEK COFFEE SHOP (PERTAMA KALI)
echo ========================================================
echo Script ini akan secara otomatis mengunduh bahan penting, 
echo menyiapkan database (XAMPP harus nyala!), & merapikan sistem.
echo Pastikan komputer terhubung ke Internet.
echo ========================================================
echo.

echo [1/6] Mengunduh Library PHP (Composer)...
call composer install
echo.

echo [2/6] Membuka Segel Rahasia (.env)...
if not exist .env (
    copy .env.example .env
    echo File .env berhasil disalin.
) else (
    echo .env sudah ada, di-skip.
)
echo.

echo [3/6] Menyiapkan Sistem Keamanan...
call php artisan key:generate
echo.

echo [4/6] Membuat Database dan Akun Admin (Migration)...
call php artisan migrate --seed
echo.

echo [5/6] Menyambungkan Folder Penyimpanan Foto...
call php artisan storage:link
echo.

echo [6/6] Mengunduh Library Visual dan Merender UI Tailwind...
call npm install
call npm run build
echo.

echo ========================================================
echo INSTALASI SELESAI DENGAN SUKSES! 🎉
echo Selanjutnya, klik tombol silang (X) untuk keluar.
echo Lalu klik ganda file "2-Jalankan-Toko.bat" untuk membuka Toko.
echo ========================================================
pause
