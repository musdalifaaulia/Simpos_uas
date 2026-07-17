# Task 4: Manajemen Inventaris per Cabang (Inventories)

## Deskripsi Singkat
Mengembangkan fitur pencatatan dan pengelolaan kuantitas fisik stok barang yang dipisahkan berdasarkan masing-masing cabang (`branch_id`). Meskipun katalog produk terpusat, pencatatan jumlah stok barang harus dicatat pada tabel `inventories` secara terpisah untuk tiap cabang.

## Tujuan & Measurable Outcomes
1. Struktur tabel `inventories` disiapkan untuk mencatat stok barang per cabang.
2. Data dummy untuk inventaris di-generate melalui Seeder untuk memperlihatkan distribusi stok yang beragam antar cabang.
3. Fitur pengelolaan stok (update stok manual / low stock alerts) disiapkan.
4. Adanya pemisahan akses tingkat baris (Row-Level Tenancy) di mana pengguna dengan peran Kasir/Manajer hanya bisa melihat/mengelola stok di cabang mereka.

## Rincian Pekerjaan (To-Do List)

### 1. Struktur Database & Model
- [ ] Buat file migration untuk `inventories` dengan kolom: `id`, `branch_id`, `product_id`, `stock_quantity`, `min_stock_level` (sesuai ERD).
- [ ] Buat model `Inventory`.
- [ ] Terapkan atribut `#[Fillable]` pada kolom-kolom terkait, ikuti standar arsitektur pada model `User`.
- [ ] Definisikan relasi `belongsTo` pada `Inventory` untuk merujuk ke model `Branch` dan `Product`.

### 2. Data Dummy (Factory & Seeder)
- [ ] Buat `InventoryFactory` untuk merandom `stock_quantity` dan `min_stock_level`.
- [ ] Buat `InventorySeeder` yang memastikan setiap cabang yang ada memiliki entri inventaris untuk sejumlah produk acak dari tabel `products`.

### 3. Logika CRUD & Scoping (Controller & Model)
- [ ] Terapkan Global/Local Scope pada model `Inventory` untuk memfilter data berdasarkan `branch_id` dari user yang sedang login (kecuali Superadmin).
- [ ] Buat `InventoryController` untuk menampilkan daftar stok, mengubah jumlah stok manual (stock opname), dan menetapkan `min_stock_level`.
- [ ] Buat logika notifikasi "Low Stock Alert" jika `stock_quantity` < `min_stock_level`.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Migrasi tabel `inventories` sukses dieksekusi dengan *foreign keys* yang benar.
- [ ] Data stok dummy per cabang tampil dengan benar berkat Seeder.
- [ ] Pengecekan row-level tenancy berhasil (Admin Cabang A tidak bisa melihat/mengubah stok Cabang B).
- [ ] Menjaga konsistensi gaya kode seperti *Controller* dan *Model* bawaan di dalam proyek.
