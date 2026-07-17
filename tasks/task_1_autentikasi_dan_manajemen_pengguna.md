# Task 1: Autentikasi dan Manajemen Pengguna

## Deskripsi Singkat
Menyesuaikan sistem autentikasi dan manajemen pengguna (user management) yang sudah ada di Laravel agar selaras dengan PRD.md, khususnya terkait pengaturan peran pengguna (user role) menjadi Superadmin, Admin/Manajer Cabang, dan Kasir. 

## Tujuan & Measurable Outcomes
1. Struktur tabel `users` diperbarui untuk mengakomodasi `role` yang sesuai PRD dan `branch_id` sebagai *foreign key* (nullable).
2. Data dummy untuk setiap role berhasil dibuat melalui Seeder untuk keperluan visualisasi data.
3. Logika Create, Read, Update, dan Delete (CRUD) pada `UserController` diperbarui untuk mengenali role baru dan `branch_id`.
4. Kode tetap konsisten dengan standar coding style, pola arsitektur, dan konvensi penamaan yang sudah ada (misalnya penggunaan PHP Attributes pada Model).

## Rincian Pekerjaan (To-Do List)

### 1. Pembaruan Struktur Database (Migration)
- [ ] Buat file migration baru (atau sesuaikan yang sudah ada) untuk memodifikasi tabel `users`.
- [ ] Pastikan kolom `role` tersedia dan dapat menyimpan nilai: `Superadmin`, `Admin`, dan `Cashier`.
- [ ] Tambahkan kolom `branch_id` bertipe `bigint` (nullable) sebagai foreign key yang merujuk ke tabel `branches` sesuai dengan ERD di PRD. (Catatan: tabel `branches` disiapkan pada Task 2, maka relasi harus dipertimbangkan).

### 2. Pembaruan Model `User`
- [ ] Perbarui PHP Attributes `#[Fillable]` pada model `app/Models/User.php` dengan menambahkan `branch_id` (saat ini sudah ada `name`, `email`, `password`, `avatar`, `role`).
- [ ] Buat relasi `belongsTo` ke model `Branch` (jika diperlukan untuk visualisasi list user nantinya).
- [ ] Pastikan tidak mengubah pola penulisan yang sudah eksis (menggunakan Attributes `#[Fillable]` dan `#[Hidden]`).

### 3. Pembaruan Data Dummy (Seeder & Factory)
- [ ] Sesuaikan `UserFactory.php` (jika ada) untuk mendukung pembuatan data dummy dengan variasi role dan `branch_id`.
- [ ] Buat atau perbarui class Seeder untuk men-generate data dummy spesifik:
  - Minimal 1 user dengan role `Superadmin`.
  - Minimal 2 user dengan role `Admin` (Manajer Cabang) yang terhubung ke cabang berbeda.
  - Minimal 2 user dengan role `Cashier` (Kasir) yang terhubung ke cabang masing-masing.

### 4. Pembaruan Logika CRUD (Controller)
- [ ] Sesuaikan logika pada `app/Http/Controllers/UserController.php` (metode `store` dan `update`) untuk memvalidasi dan menyimpan input `role` dan `branch_id`.
- [ ] Sesuaikan metode `index` atau `show` agar dapat memuat dan menampilkan informasi role dan cabang pengguna (bisa memuat data relasi).
- [ ] Pastikan kode selaras dengan pola CRUD yang sudah ada di `UserController`, jangan membuat pola desain/arsitektur baru.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Migrasi berhasil dijalankan tanpa error, dan skema database untuk `users` telah memiliki kolom yang diminta.
- [ ] Menjalankan `php artisan db:seed` berhasil men-generate akun Superadmin, Admin, dan Cashier beserta cabangnya (jika cabang sudah ada).
- [ ] Proses CRUD melalui aplikasi atau API berjalan lancar dengan struktur data yang baru, dan bisa dipastikan datanya tersimpan sesuai role dan cabang yang di-assign.
- [ ] Kodingan telah direview dan dinilai selaras dengan standar saat ini. Dilarang ngoding fitur di luar requirement ini.
