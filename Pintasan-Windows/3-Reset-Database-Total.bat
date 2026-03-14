@echo off
cd ..
title Reset Database Total
color 0C
echo ========================================================
echo        AWAS! RESET DATABASE TOTAL (MIGRATE:FRESH)
echo ========================================================
echo Script ini akan MENGHAPUS SEMUA DATA (Pesanan, User, dll)
echo dan mengembalikannya ke kondisi pabrik (kosong).
echo ========================================================
echo.
pause

echo.
echo Sedang menghapus dan membuat ulang tabel...
call php artisan migrate:fresh --seed
echo.
echo ========================================================
echo SUKSES! Database berhasil di-reset ke kondisi awal.
echo ========================================================
pause
