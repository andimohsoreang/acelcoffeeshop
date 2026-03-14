#!/bin/bash
clear
echo "========================================================"
echo "        MEMBERSIHKAN CACHE APLIKASI (PEMBERSIHAN)"
echo "========================================================"
echo "Jika website terasa aneh, muncul error yang nge-bug,"
echo "atau editan Anda tidak mau berubah, jalan ninja-nya"
echo "adalah menjalankan pembersihan Cache ini."
echo "========================================================"
echo ""

cd "$(dirname "$0")/.."

php artisan optimize:clear
php artisan view:clear
php artisan route:clear

echo ""
echo "========================================================"
echo "SUKSES! Seluruh ingatan sementara (Cache) sistem telah"
echo "dikosongkan. Website akan kembali segar."
echo "========================================================"
read -p "Tekan Enter untuk keluar..."
