@echo off
cd ..
title Bersihkan Cache/Sampah Sistem
color 0F
echo ========================================================
echo         MEMBERSIHKAN CACHE APLIKASI (PEMBERSIHAN)
echo ========================================================
echo Jika website terasa aneh, muncul error aneh yang nge-bug,
echo atau editan Anda tidak mau berubah, jalan ninja-nya
echo adalah menjalankan pembersihan Cache ini.
echo ========================================================
echo.

call php artisan optimize:clear
call php artisan view:clear
call php artisan route:clear
echo.
echo ========================================================
echo SUKSES! Seluruh ingatan sementara (Cache) sistem telah
echo dikosongkan. Website akan kembali segar.
echo ========================================================
pause
