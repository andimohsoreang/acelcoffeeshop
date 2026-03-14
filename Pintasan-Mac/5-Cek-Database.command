#!/bin/bash
clear
echo "========================================================"
echo "      MEMERIKSA KONEKSI DATABASE (MYSQL/SQLITE)"
echo "========================================================"
echo "Script ini akan mengecek apakah aplikasi Laravel sudah"
echo "terhubung dengan sukses ke Database lokal."
echo "========================================================"
echo ""

cd "$(dirname "$0")/.."

php artisan db:show

echo ""
echo "========================================================"
echo "Cek tabel 'Connections'. Jika ada nama database Anda,"
echo "berarti sistem sudah sukses terhubung!"
echo "========================================================"
read -p "Tekan Enter untuk keluar..."
