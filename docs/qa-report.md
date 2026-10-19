# Revisi kontak dan motion — 19 Oktober 2026

- Nomor bisnis pengguna 628153000713 diterapkan pada environment lokal dan contoh. Enam tautan aktif (header, tiga layanan, penutup, footer) diverifikasi menuju nomor yang sama; tidak ada pesan dikirim.
- Instagram mengarah langsung ke https://www.instagram.com/saya.wedding/. Footer menggunakan dua ikon cokelat/putih; tautan navigasi footer lama, indeks inspirasi, tombol zoom dan kontrol slideshow dihapus.
- Interval slideshow 3000 ms. Pergantian beberapa foto dan putaran kembali ke foto pertama diamati tanpa menggeser pointer; foto berikutnya dipramuat. Saat keyboard difokuskan ke media, Spasi menjeda/melanjutkan dan panah memilih foto. Reduced motion tetap menampilkan foto pertama.
- Tulisan pink berubah transform saat posisi scroll tetap: gerak otomatis dikonfirmasi. Teks halaman diberi reveal bertahap; heading penutup reveal per baris. Motion berhenti di luar viewport/tab tersembunyi dan mengikuti reduced motion.
- Tidak ada error JavaScript/404 atau overflow horizontal pada 320, 390, 758, 1440, 1920 px. Link WhatsApp umum tetap ada tanpa JavaScript.
- PHP: 10 tes / 43 assertions lulus. Pint dan build Vite lulus.
- Hasil browser: `docs/business-browser-results.json`. Screenshot: `docs/screenshots/business-footer-758.png`, `business-footer-390.png`, `business-closing.png`.

---

## Catatan revisi sebelumnya

# QA revisi tampilan — 19 Oktober 2026

- Build Vite dan Pint lulus. PHP: **10 tes, 41 assertions lulus**.
- Chrome: tidak ada error JavaScript atau respons aset 404 pada run revisi.
- Lebar 320, 390, 640, 758, 1024, 1440, 1920 px: tidak ada overflow horizontal; header 65–66 px.
- Font navigasi aktual Nunito weight 800. Tiga panel inspirasi penuh, foto assets, dan seluruh selector elemen yang diminta dihapus tidak ditemukan lagi.
- Slideshow otomatis pindah foto; dot manual memilih foto ketiga; pause aktif. Reduced motion mempertahankan foto pertama, menyembunyikan auto-control dan menonaktifkan motion masthead.
- Dialog foto membuka, Escape menutup dan fokus kembali ke tombol. Dialog kontak kosong juga bekerja. Cursor native dipertahankan di dialog top layer.
- Pilihan layanan native details berfungsi. Tanpa JS, navigasi, foto pertama dan heading tetap terlihat.
- Screenshot revisi: `docs/screenshots/revised-{390,758,1440}-*`. Data: `docs/revision-browser-results.json`.
- Form konsultasi, caption preview, indeks tentang, logo kotak footer, panah yang ditandai, dan catatan footer/proses telah dihapus. Kebijakan privasi diperbarui untuk website tanpa form.

Audit performa lama di bawah memakai ilustrasi preview dan **tidak berlaku untuk versi foto ini**. Safari/iOS/perangkat fisik belum diuji. Persetujuan media dan data bisnis masih menjadi pemeriksaan rilis terpisah.

---

## Hasil sebelum revisi (historis)

# QA aktual — 19 Oktober 2026

## Status

Preview lokal berjalan di Laravel 12.70.0 / PHP 8.2.33, Node 24.22.0, Vite 7.3.7. Belum siap rilis. Pemeriksaan dilakukan di Chrome headless yang terpasang pada macOS. Tidak ada pesan WhatsApp dikirim dan tidak ada deployment.

## Pemeriksaan otomatis

- `php artisan test --compact`: **10 tes lulus, 41 assertions**. Mencakup normalisasi nomor 08/+62, format invalid, URL encoding newline/ampersand, halaman utama, privasi, 404, sitemap/robots, pembatasan layanan terbit, tujuan CTA yang sama, dan kegagalan readiness untuk preview yang belum lengkap.
- `vendor/bin/pint --format agent`: lulus. Workspace belum menggunakan Git, sehingga `--dirty` tidak tersedia; formatter dijalankan pada source proyek.
- `npm run build`: lulus. CSS sekitar 17.8 KB dan JS 3.8 KB sebelum gzip. Peringatan font URL publik merupakan resolusi runtime; seluruh font termuat dalam browser.
- `php artisan view:cache` dan `php artisan route:cache`: lulus. Route cache kemudian dibersihkan untuk pengembangan.
- `php artisan wedding:check`: exit 1 sesuai harapan. Melaporkan nomor, mode preview, area, layanan terbit, media final, video, ilustrasi placeholder dan environment produksi yang belum lengkap.
- Logo asli dibandingkan secara biner dengan sumber: sama, tidak diubah.
- `/robots.txt` pada server lokal memberikan `Disallow: /`; file robots statis bawaan Laravel dihapus agar route mengontrol hasilnya.

## Browser dan visual

- Lebar CSS 320, 360, 390, 768, 1024, 1440, 1920 px: lebar dokumen sama dengan viewport; tidak ditemukan overflow horizontal. Satu H1 pada tiap pemeriksaan.
- Screenshot desktop 1440×1000 dan mobile 390×844 serta full page tersimpan pada `docs/screenshots/`. Heading dan panel gelap diperiksa secara visual; ruang kaligrafi disesuaikan agar paragraf tetap terbaca.
- Setelah seluruh halaman di-scroll: tidak ada gambar rusak. Tidak ada page error atau respons aset 404 pada pemeriksaan halaman normal.
- Menu hanya tampil sebagai tombol pada mobile; state expanded bekerja, Escape menutup dan mengembalikan fokus.
- FAQ native details membuka isi jawaban. Navigasi tetap terlihat tanpa JavaScript. Konten utama tetap ada.
- Reduced motion: cursor khusus tidak dibuat. Simulasi cursor image gagal: cursor sistem dipertahankan.
- Zoom 200% diperiksa melalui viewport CSS 720×500 dengan device scale 2: tidak ada overflow. Ini proxy layout, bukan pengujian zoom UI manual seluruh browser.
- Brief diperiksa dengan tanggal dan lokasi `A & B + Jakarta`: ringkasan terbuka, URL decode menghasilkan pesan yang sama; mengubah input membatalkan ringkasan lama. Nomor uji hanya disuntikkan pada DOM browser pengujian, tidak disimpan ke config/environment dan tidak dibuka/dikirimi pesan.
- Keyboard diperiksa untuk Escape/fokus menu dan kontrol native. Belum dilakukan pengujian screen reader lengkap atau audit WCAG formal.

Komposisi mengikuti referensi melalui masthead besar, nav tipis, panel blush/cokelat, serif editorial, script pink, gutter galeri sempit dan identitas besar pada footer. Perbedaan disengaja: merek SAYA, label preview, galeri bertingkat, ilustrasi vektor sementara dan kaligrafi mobile yang lebih terkendali. Ini bukan klaim pixel-perfect atau timing animasi yang identik.

## Sampel performa lokal

PerformanceObserver, viewport 390×844, reduced motion, CDP 4× CPU slowdown, latency 150 ms, download 200.000 byte/detik, upload 93.750 byte/detik. Hasil run terakhir: **LCP 860 ms**, **CLS 0,0499**, resource transfer sekitar **660 KB**. Data mentah tersedia di `docs/browser-results.json`.

Ini satu sampel lab lokal pada ilustrasi preview, bukan audit Lighthouse atau Core Web Vitals lapangan. Tidak ada klaim INP lapangan. Foto/video final, hosting, kompresi dan cache produksi akan mengubah hasil; audit ulang setelah media diganti.

## Yang belum dapat diverifikasi

- Video final belum tersedia: playback/loop, transisi poster, kualitas crop foto, ukuran transfer media final dan autoplay nyata belum diuji. Modul fallback tersedia, tetapi belum tervalidasi dengan footage final.
- Nomor WhatsApp nyata dan perilaku aplikasi WhatsApp pada ponsel fisik belum diverifikasi.
- Safari/iOS/Firefox, screen reader dan perangkat nyata belum diuji.
- Persetujuan pemilik atas layanan, area, kebijakan, copy, lisensi dan hasil turunan logo masih diperlukan sebelum publikasi.
- Foto responsive AVIF/WebP dan varian video belum dibuat karena sumber final belum ada.

Screenshot, manifest dan hasil browser merupakan bukti preview saat ini; bukan persetujuan rilis.
