@echo off
cd ..
title Coffee Shop - Menjalankan Server Toko
color 0B
echo ========================================================
echo           MENYALAKAN SEMUA MESIN COFFEE SHOP...
echo ========================================================
echo JANGAN MENUTUP JENDELA HITAM YANG MUNCUL! (Biarkan minimaze)
echo Semua proses akan berjalan otomatis di belakang layar.
echo ========================================================

echo Menyalakan Website Utama...
start "Website Server" cmd /c "title Mesin Web Induk && php artisan serve"

echo Menyalakan Mesin UI Visual (Tailwind)...
start "Visual Renderer" cmd /c "title Mesin Visual UI && npm run dev"

echo Menyalakan Radar Notifikasi (Reverb WebSocket)...
start "Radar Reverb" cmd /c "title Mesin Notifikasi && php artisan reverb:start"

echo Menyalakan Pekerja Background (Queue)...
start "Pekerja Belakang" cmd /c "title Mesin Background Queue && php artisan queue:listen"

echo.
echo ========================================================
echo SUKSES! Mesin telah hidup. 
echo Buka browser Chrome dan ketikkan alamat: 
echo http://localhost:8000
echo ========================================================
pause
