<?php

namespace App\Http\Controllers\Demo;

use App\Demo\Favicons;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Liefert die Favicon-Varianten direkt aus dem Package-Verzeichnis aus.
 */
class FaviconController extends Controller
{
    public function __invoke(string $variant): BinaryFileResponse
    {
        $path = Favicons::path($variant);

        abort_if($path === null || ! is_file($path), 404);

        return response()->file($path, [
            'Content-Type' => 'image/x-icon',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
