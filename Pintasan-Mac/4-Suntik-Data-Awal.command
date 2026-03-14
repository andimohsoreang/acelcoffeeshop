#!/bin/bash
clear
echo "========================================================"
echo "            MENYUNTIKKAN DATA AWAL (SEEDER)"
echo "========================================================"
echo "Script ini akan memasukkan data bawaan (seperti akun "
echo "Admin, Kategori, atau Produk default) ke database."
echo "========================================================"
echo ""

cd "$(dirname "$0")/.."

php artisan db:seed

echo ""
echo "========================================================"
echo "SUKSES! Data awal berhasil disuntikkan."
echo "========================================================"
read -p "Tekan Enter untuk keluar..."
