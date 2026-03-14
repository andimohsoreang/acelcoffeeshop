#!/bin/bash
clear
echo "========================================================"
echo "      INSTALASI PROYEK COFFEE SHOP (MAC / LINUX)"
echo "========================================================"
echo "Script ini akan mengunduh semua library dan"
echo "menyiapkan konfigurasi database otomatis."
echo "Pastikan koneksi internet stabil & database lokal nyala."
echo "========================================================"
echo ""

cd "$(dirname "$0")/.."

echo "[1/6] Mengunduh Library PHP (Composer)..."
composer install
echo ""

echo "[2/6] Membuka Segel Rahasia (.env)..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "File .env berhasil disalin."
else
    echo "File .env sudah ada, di-skip."
fi
echo ""

echo "[3/6] Menyiapkan Sistem Keamanan Aplikasi..."
php artisan key:generate
echo ""

echo "[4/6] Membuat Database dan Akun Admin (Migration)..."
php artisan migrate --seed
echo ""

echo "[5/6] Menyambungkan Folder Penyimpanan Foto..."
php artisan storage:link
echo ""

echo "[6/6] Mengunduh Library Visual dan Merender UI Tailwind..."
npm install
npm run build
echo ""

echo "========================================================"
echo "INSTALASI SELESAI DENGAN SUKSES! 🎉"
echo "Boleh tutup terminal ini, lalu buka file"
echo "2-Jalankan-Toko.command untuk mulai berjualan."
echo "========================================================"
read -p "Tekan Enter untuk keluar..."
