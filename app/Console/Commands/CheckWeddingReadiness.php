<?php

namespace App\Console\Commands;

use App\Support\WhatsAppLink;
use Illuminate\Console\Command;

class CheckWeddingReadiness extends Command
{
    protected $signature = 'wedding:check';

    protected $description = 'Check required content and environment before publishing the wedding website';

    public function handle(): int
    {
        $issues = [];
        if (! WhatsAppLink::normalize(config('wedding.whatsapp'))) {
            $issues[] = 'Nomor WhatsApp belum valid; isi dan verifikasi tujuan secara manual.';
        }
        if (config('wedding.preview')) {
            $issues[] = 'Mode preview masih aktif.';
        }
        if (! config('wedding.area')) {
            $issues[] = 'Area layanan belum dikonfirmasi.';
        }
        if (! collect(config('wedding.services'))->contains('published', true)) {
            $issues[] = 'Belum ada layanan terkonfirmasi yang diterbitkan.';
        }
        if (! config('wedding.media.approved')) {
            $issues[] = 'Hak penggunaan dan persetujuan media belum dikonfirmasi.';
        }
        foreach (['poster'] as $type) {
            $path = config('wedding.media.'.$type);
            if (! $path || ! is_file(public_path($path))) {
                $issues[] = 'Aset '.$type.' final belum tersedia.';
            }
        }
        $imagePaths = collect(config('wedding.inspirations'))->pluck('photo.src')->push(config('wedding.media.poster'));
        if ($imagePaths->contains(fn (string $path): bool => str_contains($path, '-preview.svg'))) {
            $issues[] = 'Gambar ilustrasi preview perlu diganti dengan media final berlisensi.';
        }
        if (! app()->isProduction() || config('app.debug') || ! str_starts_with(config('app.url'), 'https://')) {
            $issues[] = 'Lingkungan produksi memerlukan APP_ENV=production, APP_DEBUG=false dan APP_URL HTTPS.';
        }
        if ($issues !== []) {
            foreach ($issues as $issue) {
                $this->error($issue);
            }

            return self::FAILURE;
        }
        $this->info('Pemeriksaan konfigurasi lulus. Verifikasi nomor tujuan, lisensi, dan QA produksi tetap diperlukan.');

        return self::SUCCESS;
    }
}
