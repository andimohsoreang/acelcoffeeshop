# Acel Coffee Shop ☕

Sistem manajemen kedai kopi modern yang dibangun dengan Laravel 12.

## Persyaratan Sistem

Pastikan perangkat Anda sudah terinstall:
- **PHP** 8.2 atau lebih tinggi
- **Composer**
- **Node.js & NPM** (LTS direkomendasikan)
- **Database**: MySQL, PostgreSQL, atau SQLite

## Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di lokal Anda:

### 1. Clone Repositori
```bash
git clone https://github.com/andimohsoreang/acelcoffeeshop.git
cd acelcoffeeshop
```

### 2. Instalasi Dependensi PHP
```bash
composer install
```

### 3. Instalasi Dependensi Frontend
```bash
npm install
```

### 4. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Lalu buka file `.env` dan sesuaikan konfigurasi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Migrasi Database & Seeding
```bash
php artisan migrate --seed
```

### 7. Hubungkan Storage (Penting untuk Gambar)
```bash
php artisan storage:link
```

## Menjalankan Aplikasi

Anda perlu menjalankan terminal berikut untuk pengembangan:

**Terminal 1 (Backend):**
```bash
php artisan serve
```

**Terminal 2 (Frontend/Vite):**
```bash
npm run dev
```

**Terminal 3 (Reverb/Real-time):**
```bash
php artisan reverb:start
```

## Fitur Utama
- **Real-time Notifications**: Menggunakan Laravel Reverb untuk notifikasi instan.
- **PWA Ready**: Aplikasi dapat diinstal langsung di perangkat user.
- **Integrasi QRIS**: Sistem pembayaran digital menggunakan QRIS.
- **Manajemen Order**: Sistem pelacakan status pesanan secara real-time.
