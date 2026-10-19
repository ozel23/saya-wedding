<?php

namespace App\Http\Controllers;

use App\Support\WhatsAppLink;
use Illuminate\Contracts\View\View;

class LandingPageController extends Controller
{
    public function __invoke(): View
    {
        $wedding = config('wedding');
        $services = collect($wedding['services'])->filter(fn (array $service): bool => $service['published'] || $wedding['preview']);
        $whatsapp = WhatsAppLink::make($wedding['whatsapp'], $wedding['message']);

        return view('pages.home', compact('wedding', 'services', 'whatsapp'));
    }
}
