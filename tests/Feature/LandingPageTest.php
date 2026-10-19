<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_preview_renders_without_a_database_or_dummy_contact(): void
    {
        config(['wedding.whatsapp' => '', 'wedding.preview' => true]);
        $this->get('/')->assertOk()->assertSee('SAYA')->assertSee('Garden Celebration')->assertSee('Kontak WhatsApp sedang disiapkan')->assertDontSee('https://wa.me/');
    }

    public function test_live_mode_excludes_unpublished_services(): void
    {
        config(['wedding.preview' => false]);
        $this->get('/')->assertOk()->assertDontSee('Wedding Planning')->assertDontSee('Preview layanan');
    }

    public function test_all_contact_links_use_the_configured_number(): void
    {
        config(['wedding.whatsapp' => '+62 812 3456 7890']);
        $response = $this->get('/')->assertOk();
        preg_match_all('/href="(https:\/\/wa\.me\/[^\"]+)"/', $response->getContent(), $links);
        $this->assertGreaterThanOrEqual(2, count($links[1]));
        foreach ($links[1] as $link) {
            $this->assertStringStartsWith('https://wa.me/6281234567890?text=', $link);
        }
    }

    public function test_privacy_404_and_discovery_routes(): void
    {
        $this->get('/privasi')->assertOk()->assertSee('tidak menyediakan form');
        $this->get('/missing-page')->assertNotFound()->assertSee('berbeda arah');
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /');
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml');
    }

    public function test_readiness_fails_for_incomplete_preview(): void
    {
        config(['wedding.whatsapp' => '', 'wedding.preview' => true]);
        $this->artisan('wedding:check')->assertFailed();
    }
}
