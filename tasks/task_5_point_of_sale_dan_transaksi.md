# Task 5: Point of Sale (POS) dan Transaksi

## Deskripsi Singkat
Mengembangkan modul utama Point of Sale (POS) yang akan digunakan oleh peran Kasir untuk melayani penjualan ke pelanggan. Modul ini melibatkan operasi transaksional yang mencatat `transactions` dan `transaction_details`, serta memotong stok `inventories` yang bersangkutan secara *real-time*.

## Tujuan & Measurable Outcomes
1. Struktur tabel transaksi *header* dan *details* dibuat.
2. Proses checkout pada POS bisa berfungsi untuk mencatat total pesanan, memotong stok, dan menyimpan detail produk yang dijual.
3. Seeder transaksi *dummy* berhasil mendemokan riwayat penjualan historis harian/bulanan di tiap cabang.
4. Performa layanan responsif dengan UI/UX dasar POS (walaupun fokus backend, respons data JSON/keranjang harus cepat).

## Rincian Pekerjaan (To-Do List)

### 1. Struktur Database & Model
- [ ] Buat migration tabel `transactions`: `id`, `invoice_number` (unique), `branch_id`, `user_id`, `total_amount`, `payment_method`, `status`, dan `created_at`.
- [ ] Buat migration tabel `transaction_details`: `id`, `transaction_id`, `product_id`, `quantity`, `price_at_transaction`, `subtotal`.
- [ ] Buat model `Transaction` dan `TransactionDetail` berserta PHP Attributes dan standarisasi koding lainnya.
- [ ] Buat relasi antar model tersebut, dan ke `User`, `Branch`, `Product`.

### 2. Data Dummy (Factory & Seeder)
- [ ] Buat factory untuk `transactions` dan `transaction_details`.
- [ ] Buat `TransactionSeeder` untuk menyimulasikan ratusan riwayat transaksi per cabang dengan status `Completed` dengan waktu lampau (*backdated*) untuk mensimulasikan data analitik.

### 3. Logika Transaksional POS (Controller)
- [ ] Buat `TransactionController` atau `PosController`.
- [ ] Siapkan endpoint/metode untuk fitur Keranjang Belanja dan Pencarian Barang di POS (Search via nama/SKU).
- [ ] Buat metode *Checkout* yang di dalamnya menerapkan `DB::transaction()` (Database Transaction) untuk:
  - Menyimpan *header* transaksi.
  - Menyimpan *detail* item transaksi.
  - Memotong/mengurangi nilai `stock_quantity` pada tabel `inventories` yang terkait dengan `branch_id` milik kasir.
- [ ] Terapkan *filtering* tingkat akses: Kasir hanya bisa transaksi di `branch_id`-nya sendiri.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Skema database untuk `transactions` & `transaction_details` lengkap dan terintegrasi.
- [ ] Proses *checkout* berhasil membuat record transaksi sekaligus memotong stok cabang dengan akurat (atomic operation).
- [ ] `php artisan db:seed` sanggup menghasilkan data transaksi dummy untuk keperluan laporan.
- [ ] Standar *coding style* (terutama terkait validasi request dan format controller) tidak keluar dari pola *existing*.
