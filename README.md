# Sistem Informasi Donasi dan Kurban Masjid Al-Fajri Universitas Fajar

Aplikasi web berbasis **Laravel 12 + PHP 8.3+ + PostgreSQL + Bootstrap 5 (Blade)** untuk mengelola
informasi masjid, donasi, dan pendaftaran kurban secara online, lengkap dengan dashboard admin dan
laporan keuangan.

---

## 1. Fitur Utama

### Halaman Pengunjung (Publik)
- Beranda dengan statistik donasi & kurban
- Profil Masjid (sejarah, visi, misi, fasilitas, lokasi)
- Berita & kegiatan masjid
- **Donasi** — pilih jenis donasi, isi form, bayar via QRIS, upload bukti pembayaran otomatis
  generate kode transaksi (`DON-000001`)
- **Kurban** — pilih paket Sapi (dengan pemilihan slot 1–7 interaktif) atau Kambing, bayar via
  QRIS, upload bukti pembayaran, generate kode transaksi (`KRB-000001`)
- **Cek Status Transaksi** — cek status donasi/kurban berdasarkan kode transaksi
- **Laporan Donasi** — daftar laporan penyaluran dana dalam bentuk file PDF yang diupload admin
- **Hubungi Admin** — kontak & lokasi masjid
- **Login Admin**

### Dashboard Admin
- Statistik ringkas (total donasi, kurban, donatur, berita, transaksi menunggu verifikasi)
- **Kelola Donasi** — verifikasi/tolak pembayaran, filter (nama/kode/status/tanggal), export PDF
- **Kelola Kurban** — verifikasi/tolak pembayaran, filter (nama/kode/status/tanggal), export PDF
- **Kelola Jenis Donasi** — CRUD jenis donasi
- **Kelola Paket Kurban** — CRUD paket sapi/kambing, otomatis generate 7 slot untuk paket sapi,
  serta **Kelola Slot** langsung dari tombol aksi (lihat status slot, reset slot yang terisi)
- **Kelola Berita** — CRUD berita dengan upload gambar
- **Kelola Profil Masjid** — atur profil, foto, dan **QRIS pembayaran** yang tampil di halaman
  Donasi & Kurban
- **Laporan Keuangan** — laporan gabungan pemasukan (donasi terverifikasi) dan pengeluaran dalam
  format akuntansi Debet/Kredit/Saldo berjalan; bisa menambah/edit/hapus data pengeluaran langsung
  dari halaman ini, filter tampilan (Semua / Pemasukan Saja / Pengeluaran Saja), filter rentang
  tanggal, serta export ke PDF
- **Kelola Laporan Donasi** — upload file laporan PDF untuk dipublikasikan ke halaman publik

---

## 2. Instalasi

### a. Prasyarat
- PHP 8.3 atau lebih baru
- Composer
- PostgreSQL
- (Opsional) Laravel Herd untuk kemudahan development di Windows/Mac

### b. Setup project

```bash
composer install
cp .env.example .env
php artisan key:generate
```

### c. Konfigurasi `.env`

Sesuaikan koneksi database dan zona waktu:

```env
APP_TIMEZONE=Asia/Makassar
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=masjid_fajar
DB_USERNAME=postgres
DB_PASSWORD=isi_password_postgres_anda

CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Buat database terlebih dahulu:
```sql
CREATE DATABASE masjid_fajar;
```

### d. Migrasi & seeding database

```bash
php artisan migrate --seed
```

### e. Buat symbolic link storage (untuk upload gambar & bukti pembayaran)

```bash
php artisan storage:link
```

### f. Jalankan aplikasi

**Cara 1 — via `php artisan serve` (localhost):**
```bash
php artisan serve
```
Buka `http://localhost:8000`

**Cara 2 — via Laravel Herd:**
Park folder project di aplikasi Herd, lalu akses `http://nama-folder.test`

---

## 3. Akun Admin Default

| Email                          | Password    |
|--------------------------------|-------------|
| adminfajar@gmail.com           | password123 |

Login lewat menu **Login Admin** di navbar, atau langsung ke `/login`.
**Segera ganti password ini setelah login pertama kali.**

---

## 4. Struktur Database

| Tabel | Keterangan |
|---|---|
| `users` | Akun admin |
| `profil_masjid` | Profil masjid (termasuk QRIS pembayaran) |
| `berita` | Berita & kegiatan |
| `jenis_donasi` | Master jenis donasi |
| `donasi` | Transaksi donasi pengunjung |
| `paket_kurban` | Master paket kurban (sapi/kambing) |
| `slot_sapi` | Slot peserta kurban sapi (maks. 7 per paket) |
| `kurban` | Transaksi pendaftaran kurban pengunjung |
| `laporan_donasi` | Laporan penyaluran donasi (file PDF) |
| `pengeluaran` | Data pengeluaran masjid untuk Laporan Keuangan |

---

## 5. Alur Fitur Utama

- **Donasi**: Beranda → Donasi → pilih jenis donasi → isi form → validasi → tampil QRIS → upload
  bukti → sistem generate kode `DON-000001` → status "Menunggu Verifikasi" → admin
  verifikasi/tolak di **Kelola Donasi**.
- **Kurban**: Beranda → Kurban → pilih Sapi (pilih slot 1–7, otomatis nonaktif jika penuh, dan
  paket otomatis disembunyikan dari pengunjung jika seluruh slot penuh) atau Kambing (langsung
  form) → validasi → QRIS → upload bukti → kode `KRB-000001` → status "Menunggu Verifikasi" →
  admin verifikasi/tolak di **Kelola Kurban** (slot otomatis terkunci saat pembayaran masuk, dan
  dilepas kembali jika ditolak atau di-reset admin).
- **Laporan Keuangan**: Admin mencatat pengeluaran (listrik, air, perawatan, dll), sistem otomatis
  menghitung saldo berjalan dari gabungan donasi terverifikasi (Debet) dan pengeluaran (Kredit),
  diurutkan kronologis berdasarkan waktu data diinput.

---

## 6. Catatan Teknis

- QRIS pada halaman pembayaran mengambil gambar dari **Kelola Profil Masjid**; jika belum
  diupload, sistem memakai QR generator online (`api.qrserver.com`) sebagai fallback visual.
- Validasi upload bukti pembayaran: `jpg, jpeg, png, pdf`, maksimal 2 MB.
- Kode transaksi digenerate otomatis berbasis auto-increment ID (`DON-000001`, `KRB-000001`, dst).
- Semua tanggal & jam yang ditampilkan mengikuti zona waktu **WITA (Asia/Makassar)**.
- Middleware `auth` + `admin` melindungi seluruh route `/admin/*`.
- Semua form menggunakan Form Request Validation terpisah (`app/Http/Requests`).
- Export PDF menggunakan package `barryvdh/laravel-dompdf`.
- Halaman error 403/404/500 sudah disediakan di `resources/views/errors/`.

---

## 7. Tech Stack

- **Backend**: Laravel 12, PHP 8.3+
- **Database**: PostgreSQL (Eloquent ORM)
- **Frontend**: Blade Templating, Bootstrap 5.3.3, Bootstrap Icons, SweetAlert2, Chart.js (CDN,
  tanpa build process/npm)
- **PDF**: barryvdh/laravel-dompdf
- **Development Environment**: Laravel Herd

---