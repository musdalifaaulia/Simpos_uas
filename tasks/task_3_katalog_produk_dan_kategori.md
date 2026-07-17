# Task 3: Katalog Produk dan Kategori (Categories & Products)

## Deskripsi Singkat
Mengembangkan fitur pengelolaan entitas Katalog Produk terpusat yang mencakup Kategori (`categories`) dan Produk (`products`). Karena aplikasi ini bersifat multi-cabang, katalog produk dibuat secara global agar standarisasi nama barang, SKU, dan harga tetap terjaga di semua cabang.

## Tujuan & Measurable Outcomes
1. Struktur tabel `categories` dan `products` dibuat dengan tepat, termasuk mendefinisikan SKU secara "unique" sesuai PRD.
2. Data dummy untuk kategori dan produk dibuat dengan Seeder, agar simulasi daftar produk terlihat variatif.
3. Fitur CRUD untuk Kategori dan Produk (Katalog terpusat) dapat dijalankan sesuai dengan pola arsitektur proyek.

## Rincian Pekerjaan (To-Do List)

### 1. Struktur Database & Model
- [ ] Buat migration untuk `categories`: `id`, `name`, `description`.
- [ ] Buat migration untuk `products`: `id`, `name`, `sku` (unique), `purchase_price`, `selling_price`, `category_id` (foreign key ke tabel categories).
- [ ] Buat model `Category` dan `Product`.
- [ ] Konfigurasikan model dengan atribut seperti `#[Fillable]` untuk menyelaraskan dengan standar di project ini.
- [ ] Buat relasi di model `Category` (hasMany ke `Product`) dan `Product` (belongsTo ke `Category`).

### 2. Data Dummy (Factory & Seeder)
- [ ] Buat `CategoryFactory` dan `ProductFactory`.
- [ ] Buat `CategorySeeder` dengan dummy data relevan (misal kategori: Makanan, Minuman, Pakaian, dsb).
- [ ] Buat `ProductSeeder` yang meng-generate puluhan produk lengkap dengan dummy SKU, Harga Beli, Harga Jual, dan di-assign ke kategori yang telah di-seed.

### 3. Logika CRUD (Controller)
- [ ] Buat `CategoryController` dan `ProductController` dengan method standar (index, store, show, update, destroy).
- [ ] Validasi data SKU agar tidak duplikat saat proses Create dan Update produk.
- [ ] Pastikan *coding style* mengikuti metode dan konvensi *existing* pada controller yang sudah ada sebelumnya.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Skema database untuk kategori dan produk berhasil terbentuk melalui migrasi tanpa kendala.
- [ ] Menjalankan seeder menghasilkan daftar kategori dan produk yang beragam (minimal 5 kategori dan 20 produk dummy).
- [ ] CRUD untuk kategori dan produk berfungsi normal.
- [ ] Sistem memvalidasi SKU agar tidak boleh duplikat (unik).
