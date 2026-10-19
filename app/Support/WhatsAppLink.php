<?php

namespace App\Support;

class WhatsAppLink
{
    public static function normalize(?string $number): ?string
    {
        $number = trim($number ?? '');
        if (! preg_match('/^\+?[\d\s().-]+$/D', $number)) {
            return null;
        }
        $number = preg_replace('/[\s().-]/', '', $number);
        $number = ltrim($number, '+');
        if (str_starts_with($number, '08')) {
            $number = '62'.substr($number, 1);
        }

        return preg_match('/^[1-9][0-9]{7,14}$/D', $number) ? $number : null;
    }

    public static function make(?string $number, string $message): ?string
    {
        $normalized = self::normalize($number);

        return $normalized ? 'https://wa.me/'.$normalized.'?text='.rawurlencode($message) : null;
    }
}
