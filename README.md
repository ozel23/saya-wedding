# saya-wedding

Landing page Laravel 12, Blade, Vite, CSS custom dan JavaScript modular. Versi revisi memakai foto dari folder `assets/`, slideshow hero, panel inspirasi foto penuh, serta navigasi Nunito yang lebih tebal. Tidak membutuhkan database bisnis.

## Menjalankan

Runtime teruji: PHP 8.2.33, Node 24.22.0, Laravel 12.70.0.

```sh
composer install
cp .env.example .env
php artisan key:generate
npm ci
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

Buka http://127.0.0.1:8000. Jangan menimpa `.env` yang sudah dikonfigurasi. Untuk pengembangan, jalankan `npm run dev` di terminal lain. Sesi dan cache menggunakan file; migrasi database tidak diperlukan untuk landing page.

## Konten dan media

`config/wedding.php` mengatur nama, navigasi, copy, FAQ, layanan, foto inspirasi, foto layanan dan urutan slideshow. Source foto tetap utuh di `assets/`; WebP responsive berada di `public/media/photos/`. Konfigurasi foto menyimpan alt, dimensi, ukuran responsive dan focal point crop.

Slideshow berganti otomatis setiap 3 detik dengan transisi opacity/posisi. Kontrol visual telah dihapus; swipe dan tombol panah keyboard tetap bekerja. Spasi menjeda/melanjutkan, Escape menjeda. Otomatis berhenti saat di luar viewport atau tab tersembunyi. Reduced motion/Save-Data menonaktifkan pergantian otomatis. Foto pertama tetap tampil tanpa JavaScript. Indeks foto dan tombol “Lihat lebih dekat” telah dihapus dari inspirasi.

Beranda `/` dan `#beranda` dimulai dari masthead saat dibuka atau dimuat ulang; tautan bagian lain tetap dapat dituju langsung. Masthead memakai entrance per huruf yang langsung terlihat, dan heading editorial memakai reveal per kata. Script pink bergerak sendiri lebih cepat (4,2 detik untuk bersama dan 4,8 detik untuk cerita), tanpa perlu scroll, dan berhenti saat keluar viewport. Semua teks mendapat animasi masuk; judul penutup memiliki reveal per baris serta gerakan script lembut. Semua motion mengikuti reduced motion dan memiliki fallback konten terlihat tanpa JS.

Font Nunito, Archivo Black, Bodoni Moda, Manrope dan Pinyon Script disajikan secara lokal dengan lisensi SIL OFL di `public/fonts/`.

## Kontak dan publikasi

```dotenv
WEDDING_BRAND_NAME="SAYA Wedding Organizer"
WEDDING_PREVIEW=true
WEDDING_WHATSAPP_NUMBER=628153000713
WEDDING_SERVICE_AREA=
WEDDING_INSTAGRAM_URL=https://www.instagram.com/saya.wedding/
```

Nomor kosong/invalid tidak menghasilkan link WhatsApp. Tombol konsultasi menampilkan status kontak dalam dialog. Nomor bisnis yang diberikan pengguna sudah dipasang: 628153000713. Header, layanan, CTA penutup dan footer memakai sumber konfigurasi yang sama. Footer menampilkan Instagram dan WhatsApp dengan ikon cokelat-putih. Helper menerima format `08…`, `+62…` dan digit internasional. Pesan hanya menjadi draft; tidak dikirim otomatis.

Form brief telah dihapus sesuai revisi. Tidak ada pengumpulan tanggal/lokasi, penyimpanan leads atau analitik pemasaran. Layanan tetap memiliki flag `published`; mode non-preview hanya menampilkan layanan yang sudah terbit. Media baru berasal dari aset pengguna, belum dianggap sebagai bukti proyek SAYA atau otomatis disetujui untuk publikasi.

## Pemeriksaan

```sh
php artisan test --compact
vendor/bin/pint --format agent
npm run build
php artisan view:cache
php artisan wedding:check
```

Lihat `docs/business-browser-results.json` untuk revisi kontak/motion terbaru, atau `docs/revision-browser-results.json` dan screenshot `docs/screenshots/revised-*`. Laporan pada `docs/qa-report.md` mencatat revisi terbaru serta hasil historis. `wedding:check` tetap gagal sampai data bisnis, persetujuan media dan konfigurasi produksi lengkap.

## Deployment

Gunakan hosting PHP/Laravel, document root `public/`, HTTPS, izin tulis `storage/` dan `bootstrap/cache/`. Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` domain HTTPS yang benar. Isi kontak, konfirmasi layanan/area/media lalu set `WEDDING_PREVIEW=false`.

```sh
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan wedding:check
```

Preview memakai noindex/robots disallow. Periksa ulang konfigurasi publik setelah deploy. Rujukan deployment: https://laravel.com/docs/12.x/deployment.
