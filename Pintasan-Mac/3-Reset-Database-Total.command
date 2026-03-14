#!/bin/bash
clear
echo "========================================================"
echo "      AWAS! RESET DATABASE TOTAL (MIGRATE:FRESH)"
echo "========================================================"
echo "Script ini akan MENGHAPUS SEMUA DATA (Pesanan, User, dll)"
echo "dan mengembalikannya ke kondisi pabrik (kosong)."
echo "========================================================"
echo ""
read -p "Tekan Enter untuk melanjutkan (atau CMD+C untuk batal)..."

cd "$(dirname "$0")/.."

echo ""
echo "Sedang menghapus dan membuat ulang tabel..."
php artisan migrate:fresh --seed

echo ""
echo "========================================================"
echo "SUKSES! Database berhasil di-reset ke kondisi awal."
echo "========================================================"
read -p "Tekan Enter untuk keluar..."
