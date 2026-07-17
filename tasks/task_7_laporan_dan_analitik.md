# Task 7: Laporan dan Analitik (Reporting & Analytics)

## Deskripsi Singkat
Mengembangkan modul dashboard pelaporan dan analitik untuk menampilkan metrik operasional harian dan bulanan. Superadmin dapat melihat rekapan konsolidasi semua cabang, sementara Admin/Manajer Cabang hanya dapat melihat analitik spesifik untuk cabangnya.

## Tujuan & Measurable Outcomes
1. Tersedianya layanan agregasi data (API/Queries) untuk metrik kunci: Total Penjualan, Laba Kasar, dan Stok Hampir Habis (Low Stock).
2. Terdapat laporan pergerakan barang (masuk vs keluar) berdasarkan riwayat mutasi dan transaksi penjualan.
3. Kueri laporan dipisahkan atau difilter berbasis `branch_id` tergantung role pengguna yang mengaksesnya.

## Rincian Pekerjaan (To-Do List)

### 1. Pengembangan Kueri & Endpoint Dashboard
- [ ] Buat atau update `DashboardController.php` yang dapat mengakomodasi laporan penjualan dan inventaris.
- [ ] Siapkan kueri aggregasi (misal: `sum` dari `transactions.total_amount` hari ini).
- [ ] Siapkan laporan "Low Stock Alert" dengan mengambil data dari `inventories` yang `stock_quantity <= min_stock_level`.

### 2. Logika Pemisahan Hak Akses (Scoping Laporan)
- [ ] Pastikan kueri mengecek role user. Jika *Superadmin*, tampilkan total global atau berikan filter *dropdown* untuk memilah cabang.
- [ ] Jika user adalah *Admin Cabang*, paksa kueri (menggunakan klausa `where('branch_id', ... )`) agar hanya mereturn data milik cabangnya sendiri.

### 3. Laporan Pergerakan Barang
- [ ] Sediakan kueri *In/Out* yang menggabungkan data penjualan (Barang Keluar) dan data penerimaan dari *Stock Transfer* (Barang Masuk) pada bulan berjalan.
- [ ] Pastikan respons data terformat dengan baik mengikuti standar API/Response JSON eksisting.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Superadmin berhasil melihat ringkasan omset dari semua cabang secara real-time.
- [ ] Admin cabang berhasil login dan hanya melihat omset cabang mereka saja.
- [ ] Daftar barang yang stoknya tipis (berdasarkan data dummy dari Seeder sebelumnya) berhasil ter-listing di dashboard.
- [ ] Kode kueri berada pada arsitektur yang benar (apakah di Controller, Service, atau Model Scope) sesuai kesepakatan pola awal proyek tanpa modifikasi gaya yang drastis.
