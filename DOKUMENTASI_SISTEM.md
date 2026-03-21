# Dokumentasi Teknis Mekanisme Pemesanan Coffee Shop

Dokumen ini menjelaskan secara detail alur kerja sistem pemesanan dari sisi pengguna (User) dan pengelola (Admin), termasuk struktur database, model, dan controller yang terlibat.

---

## 1. Arsitektur Database & Model

### **Model Utama**
1.  **`Category`**: Mengelompokkan produk (Minuman, Makanan, dll).
2.  **`Product`**: Informasi produk (Harga, Stok, Gambar, Status).
3.  **`Order`**: Data utama pesanan (Kode, Total, Status, Nama Pelanggan).
4.  **`OrderItem`**: Detail item di dalam setiap pesanan (Snapshot harga, qty, catatan).
5.  **`Payment`**: Data pembayaran (Metode QRIS/Tunai, Bukti bayar, Status Lunas).

### **Skema Database (Penting)**
-   **`orders`**: `status` (PENDING, PROCESSING, COMPLETED, CANCELLED), `queue_number`, `total_price`.
-   **`payments`**: `payment_method` (qris, cash), `status` (pending, paid, failed).
-   **`products`**: `stock` (dikurangi otomatis saat checkout).

---

## 2. Mekanisme Sisi Pengguna (User Flow)

### **A. Pemilihan Menu & Keranjang**
-   **Controller**: `User/MenuController`, `User/CartController`.
-   **Proses**: 
    - User memilih produk. Penambahan ke keranjang menggunakan **AJAX** (instan tanpa reload).
    - Data keranjang disimpan di **Session** (`session('cart')`) untuk keamanan dan efisiensi navigasi.
    - Setiap penambahan memicu Update Badge di navigasi secara real-time via JS.

### **B. Checkout & Pembuatan Pesanan**
-   **Controller**: `User/CheckoutController`.
-   **Proses**:
    1.  **Validasi**: Sistem mengecek stok terakhir dan harga terbaru dari DB (mencegah kecurangan harga di session).
    2.  **Transaksi DB**: Menggunakan `DB::beginTransaction()` untuk memastikan data konsisten.
    3.  **Pembuatan Order**: Data dipindahkan dari session ke tabel `orders` dan `order_items`.
    4.  **Update Stok**: Stok produk di tabel `products` langsung dikurangi sesuai jumlah pesanan.
    5.  **Pembuatan Payment**: Record pembayaran dibuat dengan status `pending`.

### **C. Pembayaran & Konfirmasi**
-   **View**: `user.order.success`.
-   **Proses**:
    - Jika QRIS: Menampilkan QR code dinamis.
    - Jika Tunai: Memberikan instruksi bayar di kasir.
    - User diberikan **Nomor Antrian** (`queue_number`) dan **Kode Pesanan**.

### **D. Pelacakan Real-time**
-   **JS**: `resources/js/order-tracker.js`.
-   **TEKNOLOGI**: **Laravel Reverb (WebSockets)**.
-   **Proses**: Browser mendengarkan channel private pesanan tersebut. Saat admin mengubah status, UI user terupdate otomatis (badge berubah warna, timeline terisi) tanpa perlu refresh.

---

## 3. Mekanisme Sisi Admin (Admin Flow)

### **A. Manajemen Pesanan Masuk**
-   **Controller**: `Admin/OrderController`.
-   **Proses**:
    - Admin melihat daftar pesanan terbaru di Dashboard.
    - Pesanan baru ditandai dengan status `PENDING`.

### **B. Update Status & Live Sync**
-   **Controller**: `Admin/OrderController@updateStatus`.
-   **Event**: `OrderStatusUpdated`.
-   **Proses**:
    1.  Admin mengubah status (misal: dari `PENDING` ke `PROCESSING`).
    2.  Sistem memicu (dispatch) **Event** `OrderStatusUpdated`.
    3.  **Laravel Reverb** menyebarkan pesan ke browser User yang sedang membuka halaman tracking.

### **C. Konfirmasi Pembayaran**
-   **Controller**: `Admin/OrderController@updatePaymentStatus`.
-   **Proses**:
    - Jika admin menandai pembayaran sebagai `PAID` (Lunas), sistem otomatis memperbarui tampilan user.
    - Tombol "Download Receipt" akan muncul di sisi user hanya setelah pembayaran dikonfirmasi Lunas oleh Admin.

---

## 5. Detail Step-by-Step Eksekusi (Klik & Aksi)

### **A. SISI PENGGUNA (USER)**

#### **1. Klik "Tambah ke Keranjang" (di Katalog atau Detail)**
-   **Frontend**: JavaScript mendeteksi submit form (`ajax-cart-form`). Tombol berubah jadi loading (spinner).
-   **Aksi**: Mengirim data (`product_id`, `qty`) menggunakan `fetch()` ke route `/cart/add`.
-   **Backend (`CartController@add`)**:
    - Mencari produk di database.
    - Validasi: Apakah stok cukup? Apakah produk tersedia?
    - Jika OK: Menambahkan item ke session `cart`.
-   **Output**: Mengembalikan JSON berisi pesan sukses dan total item terbaru.
-   **Update UI**: Toast sukses muncul, angka badge keranjang terupdate tanpa reload halaman.

#### **2. Klik "Hapus Semua" di Keranjang**
-   **Frontend**: Menampilkan Modal Konfirmasi (`showClearModal`).
-   **Aksi**: Jika dikonfirmasi, mengirim POST ke route `/cart/clear`.
-   **Backend (`CartController@clear`)**: Menghapus session `cart`.
-   **Update UI**: Redirect kembali ke keranjang yang sudah kosong.

#### **3. Klik "Checkout Sekarang"**
-   **Frontend**: Mengirim form ke route `/checkout/store`.
-   **Backend (`CheckoutController@store`)**:
    - **Validasi Terakhir**: Cek harga dan stok langsung ke database (mencegah manipulasi session).
    - **Database Transaction**: Memulai `DB::beginTransaction()`.
    - **Penyimpanan**: Membuat baris baru di tabel `orders`, `order_items` (looping isi cart), dan `payments`.
    - **Update Stok**: Mengurangi stok produk di tabel `products`.
    - **Penyelesaian**: `DB::commit()` dan menghapus isi session `cart`.
-   **Update UI**: Redirect ke halaman Sukses (`order.success`).

---

### **B. SISI ADMIN**

#### **4. Klik "Sedang Diproses" (Update Status Pesanan)**
-   **Frontend**: Mengirim request update status ke `/admin/orders/{id}/status`.
-   **Backend (`Admin\OrderController@updateStatus`)**:
    - Mengupdate kolom `status` di tabel `orders`.
    - Menjalankan `OrderStatusUpdated::dispatch($order)`.
-   **Broadcast (Reverb)**: Event dikirim ke WebSocket server.
-   **Update UI (Sisi User)**: Script `order-tracker.js` menerima pesan, mengubah badge status, dan mengaktifkan step timeline secara otomatis.

#### **5. Klik "Bayar" / "Konfirmasi Lunas"**
-   **Frontend**: Mengirim data status pembayaran `paid`.
-   **Backend (`Admin\OrderController@updatePaymentStatus`)**:
    - Mengupdate tabel `payments` kolom `status` menjadi `paid`.
    - Memancing `OrderStatusUpdated` kembali jika diperlukan.
-   **Update UI (Sisi User)**: Status pembayaran di halaman tracking user berubah menjadi "Lunas" (Hijau) dan tombol "Cetak Struk" muncul secara real-time.

---

---

## 7. Visualisasi Alur Sistem (Format Teks & Tabel)

Bagian ini menjelaskan alur kerja sistem dalam format teks terstruktur yang mudah dibaca di aplikasi apa pun tanpa perlu plugin tambahan.

### **A. Alur Aktivitas Pemesanan (Langkah-demi-Langkah)**

1.  **PENELUSURAN**: User membuka Katalog -> Pilih Produk.
2.  **KERANJANG**: User Klik "Tambah" -> JavaScript (AJAX) mengirim data ke Server -> Session `cart` diperbarui -> Badge Keranjang berubah otomatis.
3.  **CHECKOUT**: User klik "Checkout Sekarang" -> Mengisi Nama/Meja -> Submit Form.
4.  **VALIDASI & SIMPAN**: 
    - Server cek stok produk di Database.
    - Membuat baris di tabel `orders` (Data Utama).
    - Membuat baris di tabel `order_items` (Detail Menu).
    - Membuat baris di tabel `payments` (Data Bayar).
    - Stok di tabel `products` dikurangi otomatis.
5.  **PEMBAYARAN**: Tampil QRIS (untuk Non-Tunai) atau Instruksi Kasir (untuk Tunai).
6.  **TRACKING**: User diarahkan ke halaman pelacakan pesanan.

---

### **B. Urutan Interaksi (Sequence) - Proses Update Status**

Berikut adalah urutan kejadian saat Admin melakukan update (Tanpa Refresh):

| Urutan | Pemeran (Actor) | Tindakan (Action) |
| :--- | :--- | :--- |
| **1** | **Admin** | Menekan tombol "Proses Pesanan" di Dashboard Admin. |
| **2** | **Server (PHP)** | Mengupdate status di database menjadi `PROCESSING`. |
| **3** | **Server (Event)** | Mengirim sinyal ke sistem Reverb (Broadcaster). |
| **4** | **Reverb** | Menyebarkan data status baru ke browser User via WebSocket. |
| **5** | **User (JS)** | Script `order-tracker.js` menangkap data & update UI secara instan. |

---

### **C. Struktur Hubungan Data (ER-Schema)**

| Nama Tabel | Memiliki Relasi Ke | Penjelasan Fungsi |
| :--- | :--- | :--- |
| **Category** | Products | Satu kategori berisi banyak produk. |
| **Product** | OrderItems | Produk yang dibeli dicatat di detail item. |
| **Order** | OrderItems & Payments | Satu pesanan mengikat semua item & satu pembayaran. |
| **OrderItem** | Orders & Products | Mencatat qty dan harga saat transaksi dilakukan. |
| **Payment** | Orders | Mencatat bukti bayar dan status lunas/tidak. |

---

## 8. Ringkasan Teknis (Cheat Sheet)

| Aksi User | Fungsi / Controller | Hasil |
| :--- | :--- | :--- |
| **Pilih Produk** | `CartController@add` | Item masuk session `cart` (AJAX). |
| **Konfirmasi Order** | `CheckoutController@store` | Pesanan masuk DB, stok berkurang. |
| **Lihat Tracking** | `OrderController@show` | Menunggu update WebSocket dari Admin. |
| **Admin Proses** | `Admin\OrderController@updateStatus` | Memicu Reverb untuk update ke User. |

---
*Dokumentasi ini dirancang agar tetap informatif dan profesional, mudah dibaca, dan 100% bebas biaya penggunaan tool tambahan.*

| Lokasi File | Fungsi |
| :--- | :--- |
| `app/Http/Controllers/User/CheckoutController.php` | Otak pembuatan pesanan dan manajemen stok. |
| `app/Http/Controllers/Admin/OrderController.php` | Kendali Admin untuk mengubah status & broadcast. |
| `app/Models/Order.php` | Logika internal pesanan (Konfigurasi status & relasi). |
| `app/Events/OrderStatusUpdated.php` | Jembatan pengiriman data real-time via WebSocket. |
| `resources/js/order-tracker.js` | Menangani update UI otomatis di sisi User. |
| `resources/views/user/cart/index.blade.php` | Antarmuka keranjang belanja. |
| `resources/views/user/order/success.blade.php` | Halaman konfirmasi & QRIS. |

---
*Dokumentasi ini dibuat untuk menjelaskan integrasi sistem pemesanan yang premium, responsif, dan real-time.*
