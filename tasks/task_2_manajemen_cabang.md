# Task 2: Manajemen Cabang (Branches)

## Deskripsi Singkat
Mengembangkan fitur Manajemen Cabang berdasarkan PRD, di mana aplikasi mendukung sistem multi-cabang. Fitur ini memungkinkan pengguna dengan peran (role) tertentu (seperti Superadmin) untuk mengelola data cabang toko, mulai dari penambahan, pengeditan, hingga penonaktifan cabang.

## Tujuan & Measurable Outcomes
1. Struktur tabel `branches` dibuat sesuai desain ERD pada PRD.
2. Data dummy cabang berhasil dibuat menggunakan Seeder untuk keperluan pengujian dan visualisasi.
3. Fitur CRUD untuk cabang berhasil diimplementasikan, mematuhi standar penamaan dan arsitektur yang ada pada proyek.
4. Akses pengelolan (CRUD) hanya dapat diakses oleh user yang berwenang (Superadmin).

## Rincian Pekerjaan (To-Do List)

### 1. Struktur Database & Model
- [ ] Buat file migration untuk tabel `branches` dengan kolom: `id`, `name`, `address`, `phone`, `created_at`, `updated_at` (sesuai ERD).
- [ ] Buat model `Branch` (`app/Models/Branch.php`).
- [ ] Konfigurasikan model dengan PHP Attributes (contoh: `#[Fillable]`) sesuai standar koding yang sudah ada pada `User` model.
- [ ] Buat relasi di model `Branch` yang mengarah ke `User` (hasMany), `Inventory` (hasMany), dan `Transaction` (hasMany).

### 2. Data Dummy (Factory & Seeder)
- [ ] Buat `BranchFactory` untuk mengenerate nama cabang, alamat, dan nomor telepon dummy.
- [ ] Buat `BranchSeeder` untuk menyisipkan minimal 3 data cabang utama (misal: "Cabang Pusat", "Cabang Jakarta", "Cabang Bandung").
- [ ] Panggil `BranchSeeder` pada `DatabaseSeeder.php` dengan urutan yang benar (sebelum memanggil `UserSeeder` jika `UserSeeder` membutuhkan relasi).

### 3. Logika CRUD (Controller)
- [ ] Buat `BranchController` untuk menangani logika Create, Read, Update, Delete untuk cabang.
- [ ] Pastikan style pembuatan controller selaras dengan pola yang eksis (misalnya menggunakan validasi bawaan atau Form Request yang senada dengan modul yang sudah ada).
- [ ] Berikan otorisasi: operasi pengelolaan hanya boleh diakses oleh Superadmin.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Migrasi berhasil dan tabel `branches` tersedia di database.
- [ ] Menjalankan `php artisan db:seed` berhasil memunculkan data dummy cabang.
- [ ] Endpoint / route CRUD untuk branch bisa digunakan dengan lancar dan data tersimpan.
- [ ] Pola penamaan dan koding konsisten dengan standar yang ada di aplikasi saat ini (tanpa ngoding secara langsung pada fase penyusunan task ini).
