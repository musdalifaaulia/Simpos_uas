# SIMPOS (Sistem Point of Sales Multi-Cabang) 🛒

SIMPOS adalah aplikasi Point of Sales (Kasir) modern berskala *Enterprise* yang dirancang khusus untuk bisnis ritel dengan banyak cabang. Dibangun menggunakan framework **Laravel 11**, aplikasi ini dilengkapi dengan fitur manajemen inventaris terpusat, otorisasi berbasis peran (RBAC), dan pelacakan keuangan yang canggih.

![SIMPOS Cover](https://raw.githubusercontent.com/musdalifaaulia/Simpos_uas/main/public/niceadmin/img/laravel.png)

## ✨ Daftar Fitur Utama

1. **Role-Based Access Control (RBAC)** 🔐
   - Memiliki 3 tingkat peran: **Superadmin**, **Admin Cabang**, dan **Kasir**.
   - Sistem *Route Protection* dan *UI Filtering* memastikan setiap peran hanya dapat melihat dan mengakses modul yang sesuai dengan wewenangnya.
2. **Manajemen Multi-Cabang** 🏢
   - Seluruh data inventaris, transaksi, dan pengeluaran secara otomatis diisolasi (difilter) berdasarkan cabang (*Global Scope Row-Level Tenancy*).
   - Fitur menonaktifkan cabang (*Deactivate*) tanpa menghapus riwayat data.
3. **Point of Sale (Kasir/POS) Cerdas** 💳
   - Antarmuka kasir *Single Page* interaktif berbasis AJAX/jQuery.
   - Perhitungan keranjang belanja instan dengan pemotongan stok fisik secara otomatis.
   - Dilengkapi *Print Preview* untuk cetak struk/faktur.
4. **Manajemen Mutasi Stok (Inter-Branch Transfer)** 🚚
   - Pemindahan barang antar cabang dengan perlindungan *Database Transactions* yang bersifat *atomic* (jika gagal satu, gagal semua) sehingga mencegah kebocoran/ketidaksinkronan stok.
5. **Peringatan Stok Menipis (Low Stock Alert)** ⚠️
   - Notifikasi dan peringatan otomatis jika stok fisik berada di bawah batas minimum (*min_stock_level*).
6. **Laporan & Dasbor Analitik (Dashboard)** 📊
   - Kalkulasi *Real-time* untuk **Total Penjualan**, **Total Pengeluaran**, dan **Profit Bersih (Laba)**.
   - Superadmin dapat memantau grafik semua cabang, sementara Admin Cabang hanya fokus pada kinerja cabangnya masing-masing.

---

## 🛠️ Prasyarat (Requirements)

Sebelum memulai instalasi, pastikan sistem Anda sudah terinstal:
- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js & NPM (Opsional)

---

## 🚀 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan SIMPOS di mesin lokal Anda:

1. **Clone Repositori**
   ```bash
   git clone https://github.com/musdalifaaulia/Simpos_uas.git
   cd Simpos_uas
   ```

2. **Instal Dependensi PHP (Composer)**
   ```bash
   composer install
   ```

3. **Pengaturan Environment (.env)**
   - Gandakan file `.env.example` dan ubah namanya menjadi `.env`.
   - Buka file `.env` dan atur konfigurasi database Anda.
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=simpos_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi dan Eksekusi Seeder (Wajib!)**
   Jalankan perintah ini untuk membangun tabel database dan memuat *dummy data* (termasuk produk lokal, cabang, dan akun Superadmin bawaan):
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Tautkan Storage (Storage Link)**
   Penting agar logo dan avatar pengguna dapat ditampilkan:
   ```bash
   php artisan storage:link
   ```

7. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi Anda kini bisa diakses melalui browser di alamat: `http://localhost:8000`

---

## 🔑 Akun Default (Superadmin)

Gunakan kredensial berikut untuk melakukan login pertama kali setelah proses *Seeder* selesai:

- **Email** : `musdalifa@gmail.com`
- **Password** : `password`

*(Anda bisa mengelola, menambah, atau mengubah peran (Admin/Kasir) melalui menu **User Management**).*

---
**Dibuat dengan ❤️ oleh Musdalifa Aulia** - 2026
