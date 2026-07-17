# Task 6: Mutasi Stok Antar Cabang (Stock Transfers)

## Deskripsi Singkat
Mengembangkan fitur Mutasi Stok untuk memungkinkan perpindahan barang dari satu cabang ke cabang lainnya (contoh: dari Gudang Pusat ke Cabang A). Modul ini mencatat status pengiriman (`Pending`, `Completed`, `Cancelled`) untuk memastikan integritas pergerakan barang.

## Tujuan & Measurable Outcomes
1. Struktur tabel `stock_transfers` disiapkan untuk mencatat lalu lintas mutasi inventaris.
2. Fitur Mutasi dapat menahan sementara stok pada cabang pengirim, dan menambahkan stok ke cabang penerima apabila status diubah menjadi "Completed".
3. Terdapat riwayat data (seeder) untuk mensimulasikan mutasi masuk dan keluar.
4. Filter Row-level tenancy untuk menjamin Admin Cabang hanya bisa memanipulasi mutasi yang ditujukan ke/dari cabangnya saja.

## Rincian Pekerjaan (To-Do List)

### 1. Struktur Database & Model
- [ ] Buat migration untuk tabel `stock_transfers`: `id`, `reference_number`, `from_branch_id`, `to_branch_id`, `product_id`, `quantity`, `status`, dan `created_at`.
- [ ] Buat model `StockTransfer` beserta konfigurasi standar `#[Fillable]`.
- [ ] Buat relasi ke model `Branch` (`fromBranch` dan `toBranch`) serta ke model `Product`.

### 2. Data Dummy (Factory & Seeder)
- [ ] Siapkan Factory untuk men-generate data mutasi dengan status bervariasi (`Pending`, `Completed`).
- [ ] Buat Seeder mutasi yang secara logis mengurangi/menambah dummy inventaris terkait jika statusnya `Completed`.

### 3. Logika Mutasi (Controller)
- [ ] Buat `StockTransferController`.
- [ ] Implementasikan form / endpoint pembuatan mutasi baru (status default: `Pending`). Saat dibuat, stok `from_branch` harus dipotong sementara.
- [ ] Sediakan logika update status: Jika status jadi `Completed`, tambahkan stok ke `to_branch`. Jika `Cancelled`, kembalikan stok ke `from_branch`.
- [ ] Pastikan penamaan dan arsitektur mengikuti standar pada project yang sama.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Migrasi berhasil dan relasi cabang (asal dan tujuan) berfungsi dengan baik.
- [ ] Transaksi perpindahan stok (Stock Transfer) ditangani menggunakan `DB::transaction()` agar operasi pengamanan data stok bersifat atomic.
- [ ] Data dummy terlihat pada list Mutasi saat Seeder di-run.
- [ ] Fitur hanya memperbolehkan akses bagi role yang bersangkutan dengan cabang tersebut atau Superadmin.
