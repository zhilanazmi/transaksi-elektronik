# LaundryPay - Sistem Transaksi Elektronik Jasa Laundry

LaundryPay adalah platform berbasis web yang dirancang untuk mengotomatisasi proses bisnis jasa laundry, mulai dari pengajuan pesanan oleh customer, manajemen mitra (supplier/distributor), hingga sistem Point of Sales (POS) untuk operasional harian. Proyek ini dibangun dengan fokus pada aspek legalitas transaksi melalui pembuatan kontrak otomatis (PDF) dan integrasi pembayaran elektronik.

---

## 🚀 Fitur Utama

### 1. Sistem Multi-Role
Aplikasi memiliki 4 level akses pengguna:
- **Admin**: Oversight seluruh sistem, approval pesanan & mitra, manajemen database.
- **Staff**: Operasional harian melalui menu POS (Point of Sales).
- **Customer**: Mengajukan pesanan laundry, melakukan pembayaran, dan mengunduh kontrak.
- **Mitra**: Mengajukan kerjasama sebagai Supplier/Distributor dan mengunduh kontrak kerjasama.

### 2. Alur Kerja Pesanan (Customer)
- **Pengajuan**: Customer mengisi form detail cucian (berat, jenis layanan, lokasi).
- **Approval Admin**: Admin memeriksa detail dan memberikan estimasi harga.
- **Pembayaran**: Customer membayar melalui Midtrans (Otomatis) atau Manual (QRIS/Transfer).
- **Kontrak Otomatis**: Setelah status pembayaran lunas, sistem secara otomatis men-generate file PDF Kontrak Layanan yang sah antara LaundryPay dan Customer.

### 3. Manajemen Kemitraan (Mitra)
- **Pengajuan Mitra**: Calon mitra mengisi form profil, jenis (Supplier/Distributor), produk, serta poin-poin kewajiban kedua belah pihak.
- **Review Admin**: Admin menyetujui atau menolak pengajuan berdasarkan profil dan poin kewajiban.
- **Kontrak Mitra**: Setelah disetujui, kontrak kerjasama PDF dihasilkan secara otomatis dengan isi yang sesuai dengan input form pengajuan.

### 4. Point of Sales (POS)
- Digunakan oleh Staff untuk mencatat transaksi laundry offline secara cepat.
- Mendukung pencatatan jenis layanan, berat, dan status pembayaran.

### 5. Keamanan & Privasi Kontrak
- Kontrak hanya dapat diakses oleh pihak yang terlibat (Owner kontrak & Admin).
- Mencegah kebocoran data antar mitra atau antar customer.

---

## 🛠️ Tech Stack

- **Framework**: Laravel 12.x
- **Frontend**: TailwindCSS, Vite, AlpineJS
- **Database**: MySQL (via Laragon/XAMPP) atau SQLite
- **PDF Engine**: Barryvdh/Laravel-DomPDF
- **Payment Gateway**: Midtrans SDK
- **Language**: PHP 8.2+

---

## 🔄 Cara Kerja Fitur (Core Workflows)

### 1. Alur Transaksi Customer (B2C)
*   **Registrasi**: User mendaftar sebagai `Customer`.
*   **Pengajuan**: User membuat "Pesanan Baru". Data disimpan di tabel `projects` dengan status `pending`.
*   **Validasi**: Admin melihat daftar pengajuan di menu "Approval", menentukan harga per kg, dan memberikan catatan. Status berubah menjadi `waiting_payment`.
*   **Pembayaran**: Customer memilih metode pembayaran. Jika menggunakan Midtrans, sistem menunggu webhook sukses. Jika manual, admin memverifikasi bukti.
*   **Kontrak**: Setelah lunas (status `approved`), sistem memicu `ContractController` untuk membuat record di tabel `contracts` dan menghasilkan konten legal otomatis.

### 2. Alur Kemitraan (B2B)
*   **Registrasi**: User mendaftar sebagai `Mitra`.
*   **Pengajuan**: Mitra mengisi detail profil bisnis dan menyusun draft kewajiban (klausul kontrak).
*   **Review**: Admin memeriksa integritas mitra. Jika disetujui, Admin menekan "Approve".
*   **Legalitas**: Sistem langsung mengunci data pengajuan dan men-generate kontrak digital yang mencantumkan seluruh poin kewajiban yang telah disepakati.

### 3. Sistem POS (Staff)
*   **Input Cepat**: Staff memasukkan nama customer, jenis laundry, dan berat.
*   **Direct Transaction**: Berbeda dengan alur Customer web yang butuh approval, POS dianggap transaksi langsung (Walk-in). Data disimpan di tabel `pos_transactions`.

---

## 🧪 Panduan Testing (Step-by-Step)

Untuk memastikan aplikasi berjalan 100%, lakukan langkah berikut:

### Pengujian Fitur Customer
1.  **Register** akun baru sebagai "Customer".
2.  Ke menu **Pesanan**, klik **Ajukan Pesanan**. Isi data sembarang.
3.  **Logout**, masuk sebagai **Admin** (`admin@laundrypay.test`).
4.  Buka menu **Approval**, klik **Review** pada pesanan tadi. Masukkan harga (misal: 8000) dan klik **Setujui**.
5.  **Logout**, masuk kembali sebagai **Customer**.
6.  Klik pesanan tersebut, pilih **Bayar Sekarang**. (Jika testing lokal, gunakan pembayaran simulasi/manual).
7.  Setelah lunas, pastikan tombol **Download Kontrak** muncul dan file PDF bisa dibuka.

### Pengujian Fitur Mitra
1.  **Register** akun baru sebagai "Mitra".
2.  Klik menu **Pengajuan Mitra** > **Ajukan Mitra**.
3.  Isi seluruh form (Supplier/Distributor). Pastikan bagian **Kewajiban** diisi dengan poin-poin (Gunakan Enter untuk baris baru).
4.  **Logout**, masuk sebagai **Admin**.
5.  Buka menu **Pengajuan Mitra**, klik **Review**. Klik **Setujui Pengajuan**.
6.  Buka menu **Daftar Mitra** untuk memastikan mitra baru sudah masuk list.
7.  **Logout**, masuk sebagai **Mitra**. Pastikan status berubah jadi **Approved** dan kontrak tersedia untuk di-download.

### Pengujian Keamanan (Privasi)
1.  Buka dua browser berbeda atau gunakan mode Incognito.
2.  Login dengan **Mitra A** dan **Mitra B**.
3.  Coba akses URL kontrak milik Mitra A menggunakan akun Mitra B (misal: `/contracts/1/download`).
4.  Sistem harus menampilkan halaman **403 Forbidden**.

---

## 📊 Detail Skema Database (Database Schema)

Aplikasi ini menggunakan skema database relasional yang dirancang untuk mendukung integritas data transaksi dan kontrak. Berikut adalah detail dari tabel-tabel utama:

### 1. Tabel `users` (Manajemen Pengguna)
Mengelola identitas dan hak akses seluruh aktor dalam sistem.
- `role`: Menentukan akses (admin, staff, customer, mitra).
- `email`: Identifier unik untuk login.

### 2. Tabel `projects` (Pengajuan Laundry)
Menampung data pengajuan dari `customer`.
- `user_id`: Relasi ke `users` (pemilik pesanan).
- `project_code`: Kode unik pesanan (misal: PRJ-20260608-0001).
- `status`: Lifecycle pesanan (`pending`, `waiting_payment`, `approved`, `rejected`).
- `laundry_weight` & `service_price`: Data teknis untuk kalkulasi biaya.

### 3. Tabel `mitra_applications` (Pengajuan Kemitraan)
Menampung proposal kerjasama dari `mitra`.
- `user_id`: Relasi ke `users` (pemilik pengajuan).
- `jenis_mitra`: Enum (`supplier`, `distributor`).
- `kewajiban_mitra` & `kewajiban_pemilik`: Konten hukum yang akan dimasukkan ke kontrak.
- `status`: Lifecycle pengajuan (`pending`, `approved`, `rejected`).

### 4. Tabel `contracts` (Dokumen Legal)
Pusat metadata kontrak yang dihasilkan sistem.
- `project_id`: Nullable, terisi jika kontrak untuk Customer.
- `mitra_application_id`: Nullable, terisi jika kontrak untuk Mitra.
- `contract_number`: Nomor unik kontrak resmi.
- `content`: Teks lengkap kontrak yang digenerate sistem.

### 5. Tabel `payments` (Transaksi Keuangan)
Mencatat seluruh pembayaran untuk pesanan laundry.
- `project_id`: Relasi ke pesanan yang dibayar.
- `method`: Metode (midtrans, qris, cash, dll).
- `midtrans_order_id`: ID unik untuk sinkronisasi dengan gateway Midtrans.
- `status`: Status pembayaran (`pending`, `paid`, `failed`).

### 6. Tabel `pos_transactions` (Point of Sales)
Transaksi cepat yang dilakukan oleh `staff`.
- Mencatat transaksi langsung di lokasi tanpa alur approval panjang.

### 7. Tabel `audit_logs`
Mencatat aktivitas penting (siapa melakukan apa) untuk keperluan audit transaksi elektronik.

---

## 🔗 Relasi Antar Tabel (Entity Relationships)

1.  **User 1:N Projects**: Seorang Customer dapat memiliki banyak pengajuan laundry.
2.  **User 1:N MitraApplications**: Seorang Mitra dapat mengajukan beberapa jenis kemitraan.
3.  **Project 1:1 Contract**: Setiap pesanan laundry yang lunas memiliki tepat satu kontrak legal.
4.  **MitraApplication 1:1 Contract**: Setiap kemitraan yang disetujui memiliki tepat satu kontrak kerjasama.
5.  **Project 1:N Payments**: Satu pesanan laundry bisa memiliki beberapa record pembayaran (misal: jika ada kegagalan transaksi sebelumnya).

---

## ⚙️ Panduan Instalasi (Running the Project)

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- Laragon atau XAMPP (dengan MySQL aktif)

### Langkah-langkah Setup:

1. **Clone Repository**
   ```bash
   git clone https://github.com/zhilanazmi/transaksi-elektronik.git
   cd transaksi-elektronik
   ```

2. **Install Dependensi**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   - Salin `.env.example` menjadi `.env`:
     ```bash
     cp .env.example .env
     ```
   - Sesuaikan database di `.env`:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=laundrypay
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Persiapan Database**
   - Buat database manual di MySQL dengan nama `laundrypay`.
   - Jalankan migrasi dan seeder:
     ```bash
     php artisan key:generate
     php artisan migrate --seed
     ```

5. **Build Asset Frontend**
   ```bash
   npm run build
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```
   Akses di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔑 Akun Uji Coba (Demo Accounts)

Sistem telah dilengkapi dengan data awal untuk memudahkan testing:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@laundrypay.test` | `password` |
| **Staff** | `staff@laundrypay.test` | `password` |
| **Customer** | `customer@laundrypay.test` | `password` |

---

## 📁 Struktur Folder Penting

- `app/Http/Controllers/`: Logika utama aplikasi.
  - `Admin/`: Khusus fitur manajemen admin.
  - `MitraApplicationController.php`: Alur pengajuan mitra.
- `app/Models/`: Definisi tabel dan relasi.
- `resources/views/`: Template tampilan (Blade).
  - `mitra/`: View khusus user mitra.
  - `contracts/`: Template PDF kontrak.
- `database/migrations/`: Struktur database.
- `routes/web.php`: Daftar seluruh endpoint URL.

---

## 🔒 Keamanan & Data Sensitif

Aplikasi ini mengikuti standar keamanan Laravel:
1.  **Environment Variables**: Seluruh data sensitif (DB Credentials, Midtrans Keys, App Keys) **TIDAK** disimpan dalam source code. Data tersebut wajib disimpan di file `.env`.
2.  **Git Ignore**: File `.env` telah dimasukkan ke dalam `.gitignore` agar tidak terunggah ke repository publik.
3.  **Setup Baru**: Jika Anda meng-clone proyek ini, Anda **WAJIB** membuat file `.env` baru (bisa mencontoh `.env.example`) dan menjalankan `php artisan key:generate`.
4.  **Midtrans**: Pastikan `MIDTRANS_SERVER_KEY` dan `MIDTRANS_CLIENT_KEY` diisi dengan Sandbox Key Anda sendiri untuk mencoba fitur pembayaran.

---

## 📄 Lisensi
Proyek ini dikembangkan untuk kebutuhan akademik (Tugas UAS Transaksi Elektronik).

**Maintained by:** [Zhilan Azmi]
