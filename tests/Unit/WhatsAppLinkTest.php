<?php

namespace Tests\Unit;

use App\Support\WhatsAppLink;
use PHPUnit\Framework\TestCase;

class WhatsAppLinkTest extends TestCase
{
    public function test_normalizes_indonesian_numbers(): void
    {
        $this->assertSame('6281234567890', WhatsAppLink::normalize('0812-3456-7890'));
        $this->assertSame('6281234567890', WhatsAppLink::normalize('+62 812 3456 7890'));
        $this->assertSame('6281234567890', WhatsAppLink::normalize('6281234567890'));
    }

    public function test_rejects_missing_invalid_and_injected_numbers(): void
    {
        foreach ([null, '', 'abc', '1234', '00012345678', '1234567890123456', '62abc8123456789', 'https://wa.me/6281234567890', '++6281234567890'] as $number) {
            $this->assertNull(WhatsAppLink::make($number, 'Halo'));
        }
    }

    public function test_encodes_message_exactly_once(): void
    {
        $message = "Halo SAYA & keluarga\nLokasi: A + B / Jakarta? #cinta";
        $url = WhatsAppLink::make('081234567890', $message);
        $this->assertStringStartsWith('https://wa.me/6281234567890?text=', $url);
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        $this->assertSame($message, $query['text']);
    }
}
