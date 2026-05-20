# LaundryPay

LaundryPay adalah aplikasi web transaksi elektronik untuk jasa laundry. Project ini dibuat untuk kebutuhan tugas kuliah dengan fitur pengajuan pesanan, approval admin, generate kontrak formal, export kontrak PDF, pembayaran manual/QRIS, POS sederhana, dan alur yang mendukung pembayaran nominal kecil yang realistis untuk sekali scan uang.

## Tech Stack

- Laravel 12
- Laravel Breeze Blade
- Tailwind CSS
- Alpine.js
- SQLite default development database
- DOMPDF via `barryvdh/laravel-dompdf`

## Fitur Utama

- Login, register, profile, dan auth bawaan Laravel Breeze.
- Role user: `admin`, `staff`, dan `customer`.
- Customer dapat mengajukan pesanan laundry.
- Customer dapat melihat, mengedit, dan membatalkan pengajuan selama status masih `pending`.
- Admin dapat approve atau reject pengajuan pesanan.
- Saat pesanan di-ACC admin, status menjadi `waiting_payment`.
- Kontrak memakai format formal, dibuat setelah pembayaran lunas, dan dapat diexport ke PDF.
- Customer dapat membuat invoice pembayaran untuk pesanan berstatus `waiting_payment` atau `approved`.
- Metode pembayaran: cash, debit, credit, QRIS, digital wallet, dan bank transfer.
- POS untuk admin/staff mencatat pembayaran langsung.
- Validasi server-side untuk pengajuan pesanan dan pembayaran.
- Audit log sederhana untuk aktivitas penting.

## Requirement Lokal

- PHP 8.2+
- Composer
- Node.js
- npm

Catatan: saat project dibuat, Node lokal adalah `22.11.0`. Vite memberi warning karena merekomendasikan Node `20.19+` atau `22.12+`, tetapi build tetap berhasil. Jika ada masalah frontend, upgrade Node ke `22.12+` atau gunakan versi LTS yang sesuai.

## Instalasi Dari Nol

Clone atau buka folder project, lalu jalankan:

```bash
composer install
```

```bash
npm install
```

Salin env jika belum ada:

```bash
cp .env.example .env
```

Untuk Windows PowerShell, jika `cp` tidak tersedia:

```powershell
Copy-Item .env.example .env
```

Generate app key:

```bash
php artisan key:generate
```

Buat database SQLite jika belum ada:

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

Jalankan migration dan seed data demo:

```bash
php artisan migrate:fresh --seed
```

Build asset frontend:

```bash
npm run build
```

## Menjalankan Aplikasi

Jalankan Laravel server:

```bash
php artisan serve
```

Jalankan Vite dev server di terminal lain:

```bash
npm run dev
```

Buka aplikasi:

```text
http://127.0.0.1:8000
```

Alternatif, bisa menjalankan beberapa proses development dari script Composer:

```bash
composer run dev
```

## Akun Demo

Semua akun demo memakai password:

```text
password
```

Admin:

```text
admin@laundrypay.test
```

Staff POS:

```text
staff@laundrypay.test
```

Customer:

```text
customer@laundrypay.test
```

## Flow Aplikasi

1. Customer login/register.
2. Customer mengajukan pesanan dari menu `Pesanan`.
3. Status awal pesanan adalah `pending`.
4. Admin membuka menu `Approval`.
5. Admin melakukan ACC atau reject pesanan.
6. Jika di-ACC, status pesanan menjadi `waiting_payment`.
7. Customer membuka detail pesanan dan membuat pembayaran.
8. Admin/staff mencatat atau mengonfirmasi pembayaran.
9. Setelah pembayaran tercatat lunas, status pesanan menjadi `approved` dan kontrak otomatis dibuat.
10. Setelah kontrak tersedia, customer/admin/staff dapat download kontrak PDF.
11. Staff dapat mencatat pembayaran langsung melalui menu `POS`.

## Struktur Folder Penting

Model utama:

```text
app/Models/Project.php
app/Models/Contract.php
app/Models/Payment.php
app/Models/PosTransaction.php
app/Models/AuditLog.php
```

Controller utama:

```text
app/Http/Controllers/DashboardController.php
app/Http/Controllers/ProjectController.php
app/Http/Controllers/AdminProjectController.php
app/Http/Controllers/PaymentController.php
app/Http/Controllers/PosController.php
app/Http/Controllers/ContractController.php
```

View utama:

```text
resources/views/dashboard.blade.php
resources/views/projects/index.blade.php
resources/views/projects/create.blade.php
resources/views/projects/edit.blade.php
resources/views/projects/show.blade.php
resources/views/payments/create.blade.php
resources/views/admin/projects/index.blade.php
resources/views/pos/index.blade.php
resources/views/contracts/pdf.blade.php
```

Route:

```text
routes/web.php
```

Seeder demo:

```text
database/seeders/DatabaseSeeder.php
```

## Database

Default database saat ini menggunakan SQLite.

File database:

```text
database/database.sqlite
```

Tabel domain yang ditambahkan:

```text
projects
contracts
payments
pos_transactions
audit_logs
```

Kolom tambahan pada `users`:

```text
role
phone
address
```

## Role Dan Akses

Customer:

- Membuat pengajuan pesanan.
- Melihat pesanan miliknya sendiri.
- Mengedit/menghapus pesanan selama masih `pending`.
- Membuat pembayaran jika pesanan sudah `waiting_payment` atau `approved`.
- Download kontrak PDF miliknya.

Admin:

- Melihat semua pesanan.
- Approve/reject pesanan.
- Mengubah pesanan dari `pending` menjadi `waiting_payment` lewat ACC.
- Mengelola keputusan utama pesanan dan validasi pengajuan.
- Mengakses POS.
- Menandai pembayaran lunas.
- Download semua kontrak PDF.

Staff:

- Fokus ke operasional pembayaran/POS.
- Mencatat transaksi pembayaran langsung.
- Menandai pembayaran lunas jika pembayaran sudah diterima.
- Staff tidak bisa melakukan ACC/reject pesanan.
- Download kontrak PDF.

## Kontrak PDF

Kontrak formal dibuat setelah pembayaran pesanan tercatat lunas dan status pesanan menjadi `approved`.

Template PDF ada di:

```text
resources/views/contracts/pdf.blade.php
```

Download PDF tersedia melalui route:

```text
GET /contracts/{contract}/download
```

Nama route:

```text
contracts.download
```

PDF hanya bisa diakses oleh pemilik pesanan, admin, atau staff.

## QRIS

Untuk pembayaran QRIS, sistem saat ini mengarah ke path:

```text
public/images/qris.png
```

Jika ingin memakai QRIS asli, letakkan gambar QRIS di path tersebut. Jika folder `public/images` belum ada, buat folder tersebut lalu simpan file dengan nama `qris.png`.

## Validasi Yang Sudah Ada

- Estimasi total pesanan minimal `10000`.
- Detail cucian minimal 20 karakter.
- Tanggal pickup tidak boleh sebelum hari ini.
- Payment hanya bisa dibuat untuk pesanan `waiting_payment` atau `approved`.
- Nominal pembayaran minimal `10000`.
- Nominal pembayaran tidak boleh melebihi sisa tagihan.
- POS hanya bisa mencatat pembayaran untuk pesanan `waiting_payment` atau `approved`.
- Customer tidak bisa mengakses pesanan milik user lain.
- Export PDF dibatasi berdasarkan role dan kepemilikan pesanan.

## Command Verifikasi

Jalankan test:

```bash
php artisan test
```

Build frontend:

```bash
npm run build
```

Lihat route:

```bash
php artisan route:list
```

Render test PDF via Tinker:

```bash
php artisan tinker --execute="$contract = App\Models\Contract::with('project.customer')->first(); Barryvdh\DomPDF\Facade\Pdf::loadView('contracts.pdf', ['contract' => $contract, 'project' => $contract->project])->setPaper('a4')->output(); echo 'PDF rendered';"
```

Untuk PowerShell, `$` perlu di-escape:

```powershell
php artisan tinker --execute="`$contract = App\Models\Contract::with('project.customer')->first(); Barryvdh\DomPDF\Facade\Pdf::loadView('contracts.pdf', ['contract' => `$contract, 'project' => `$contract->project])->setPaper('a4')->output(); echo 'PDF rendered';"
```

## Catatan Lanjutan Untuk Developer Berikutnya

Fitur yang masih bisa dilanjutkan:

- Buat landing page custom menggantikan halaman Laravel default.
- Rapikan desain login/register agar sesuai tema laundry.
- Tambah upload gambar QRIS dari dashboard admin.
- Tambah halaman invoice PDF atau receipt PDF.
- Tambah status pembayaran lebih detail: `pending`, `paid`, `failed`, `refunded`.
- Tambah filter/search pada approval, pesanan, dan POS.
- Tambah middleware khusus role supaya pengecekan role tidak tersebar di controller.
- Tambah test fitur untuk pengajuan pesanan, approval, pembayaran, POS, dan export kontrak.
- Jika ingin production-like, pindahkan database dari SQLite ke MySQL.

## Status Verifikasi Terakhir

Verifikasi terakhir yang sudah dilakukan:

```text
php artisan test
25 passed
```

```text
npm run build
berhasil
```

```text
PDF rendered
```
