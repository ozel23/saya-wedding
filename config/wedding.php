<?php

$photo = static function (int $id, int $width, int $height, string $alt, string $position = '50% 50%'): array {
    $sizes = array_unique([min(640, $width), min(960, $width), min(1600, $width), min(1920, $width)]);
    $displayWidth = min(1600, $width);

    return [
        'src' => 'media/photos/photo-'.$id.'-'.$displayWidth.'.webp',
        'sources' => array_map(static fn (int $size): array => ['src' => 'media/photos/photo-'.$id.'-'.$size.'.webp', 'width' => $size], $sizes),
        'width' => $displayWidth,
        'height' => (int) round($height * $displayWidth / $width),
        'alt' => $alt,
        'position' => $position,
    ];
};

$garden = $photo(1, 736, 1104, 'Pasangan berjalan di taman terbuka dengan latar pepohonan.', '50% 53%');
$celebration = $photo(2, 1440, 960, 'Suasana kebersamaan di area perayaan dengan dekorasi bunga.', '50% 48%');
$ceremony = $photo(4, 2726, 1815, 'Prosesi pernikahan dengan busana adat dan rangkaian bunga merah.', '50% 48%');
$dance = $photo(5, 2707, 1789, 'Pasangan berdansa dalam cahaya hangat di ruang resepsi.', '50% 53%');
$intimate = $photo(6, 3088, 4096, 'Suasana perayaan malam dengan cahaya lilin dan dekorasi bunga.', '50% 49%');
$reception = $photo(7, 3072, 4096, 'Pasangan berbusana adat di antara bunga dan cahaya resepsi.', '50% 42%');
$servicePhoto = $photo(8, 3084, 4096, 'Pasangan berbusana putih berjalan melewati taman dan bangunan tradisional.', '50% 50%');

return [
    'name' => env('WEDDING_BRAND_NAME', 'SAYA Wedding Organizer'),
    'whatsapp' => env('WEDDING_WHATSAPP_NUMBER', ''),
    'area' => env('WEDDING_SERVICE_AREA', ''),
    'instagram' => env('WEDDING_INSTAGRAM_URL', ''),
    'preview' => env('WEDDING_PREVIEW', true),
    'description' => 'Hari istimewa, dirancang bersama. Kenali SAYA Wedding Organizer dan ceritakan rencana pernikahan Anda.',
    'message' => 'Halo SAYA Wedding Organizer, saya ingin konsultasi mengenai rencana pernikahan. Boleh dibantu informasi layanan dan ketersediaan tanggal?',
    'navigation' => ['tentang' => 'Tentang', 'inspirasi' => 'Inspirasi', 'layanan' => 'Layanan', 'proses' => 'Proses', 'faq' => 'FAQ'],
    'copy' => [
        'masthead_left' => ['HARI ISTIMEWA,', 'DIRANCANG BERSAMA.'],
        'masthead_right' => ['AGAR ANDA HADIR', 'DI SETIAP MOMEN.'],
        'statement' => ['SETIAP PASANGAN MEMILIKI CERITA.', 'KAMI MEMBANTU MERANGKAI HARI', 'YANG TERASA MILIK ANDA.'],
        'about' => 'Dari percakapan pertama hingga hari perayaan, SAYA mendampingi proses persiapan agar setiap detail terarah dan Anda dapat menikmati momen bersama orang terdekat.',
        'inspiration' => ['RUANG UNTUK', 'CERITA ANDA.'],
    ],
    'media' => [
        'poster' => $dance['src'],
        'interval' => 3000,
        'slides' => [$dance, $ceremony, $celebration],
        'video' => null,
        'approved' => false,
    ],
    'inspirations' => [
        ['title' => 'Garden Celebration', 'description' => 'Terbuka, hangat, dekat dengan alam.', 'photo' => $garden],
        ['title' => 'Intimate Gathering', 'description' => 'Ruang yang dekat untuk orang-orang terdekat.', 'photo' => $intimate],
        ['title' => 'Elegant Reception', 'description' => 'Detail terukur. Kesan yang tinggal lebih lama.', 'photo' => $reception],
    ],
    'service_photo' => $servicePhoto,
    'services' => [
        ['id' => 'planning', 'title' => 'Wedding Planning', 'description' => 'Menata konsep, kebutuhan vendor, anggaran, dan alur persiapan bersama pasangan.', 'published' => false],
        ['id' => 'coordination', 'title' => 'Wedding Coordination', 'description' => 'Membantu koordinasi persiapan akhir, vendor, dan rundown sesuai lingkup yang disepakati.', 'published' => false],
        ['id' => 'intimate', 'title' => 'Intimate Celebration', 'description' => 'Mendiskusikan kebutuhan acara berskala personal dengan pendekatan yang sesuai.', 'published' => false],
    ],
    'process' => [
        ['title' => 'Ceritakan rencana Anda', 'description' => 'Mulai dari tanggal, lokasi, dan gambaran perayaan yang Anda impikan.'],
        ['title' => 'Susun kebutuhan bersama', 'description' => 'Diskusikan prioritas dan bentuk pendampingan yang terasa tepat.'],
        ['title' => 'Rencanakan detailnya', 'description' => 'Siapkan alur dan koordinasi sesuai kesepakatan, selangkah demi selangkah.'],
        ['title' => 'Nikmati hari perayaan', 'description' => 'Pendampingan berjalan sesuai lingkup layanan yang disepakati.'],
    ],
    'faqs' => [
        ['question' => 'Bagaimana mulai konsultasi?', 'answer' => 'Klik tombol WhatsApp lalu ceritakan rencana awal Anda. Admin akan mendiskusikan kebutuhan acara.'],
        ['question' => 'Apakah konsultasi langsung mengamankan tanggal?', 'answer' => 'Belum. Ketersediaan dan proses pemesanan dikonfirmasi langsung oleh admin.'],
        ['question' => 'Informasi apa yang perlu disiapkan?', 'answer' => 'Tanggal rencana, lokasi atau kota, perkiraan tamu, dan bentuk pendampingan yang dicari. Jika belum pasti, Anda tetap dapat memulai percakapan.'],
        ['question' => 'Bisakah kebutuhan layanan disesuaikan?', 'answer' => 'Diskusikan kebutuhan Anda dengan admin untuk mengetahui opsi dan lingkup yang tersedia.'],
    ],
];
