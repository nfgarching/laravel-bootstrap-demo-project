<?php

use App\Http\Middleware\DisableDemoRoutes;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Hinter Traefik: X-Forwarded-* übernehmen, damit URLs https nutzen und
        // das Rate-Limit die echte Besucher-IP sieht.
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [DisableDemoRoutes::class]);

        // Gäste landen auf der Seite mit den Demo-Logins, angemeldete Nutzer
        // auf Gast-Routen (z. B. /login) ebenfalls dort statt auf /dashboard.
        $middleware->redirectGuestsTo(fn () => route('demo.core.roles'));
        $middleware->redirectUsersTo(fn () => route('demo.core.roles'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
