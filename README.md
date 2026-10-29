# Demo phpmyoffice

Öffentliche Demo-Anwendung (**demo.phpmyoffice.de**) für die Laravel-Packages
von nfgarching. Den Anfang macht das Basis-Package
[`nfgarching/core`](https://github.com/nfgarching/laravel-bootstrap-core)
(Bootstrap 5 + Livewire 4). Die App rendert sich selbst im Layout von core –
Navbar, Sidebar, Offcanvas und Toasts sind also echte Package-Bausteine.

Stack: Laravel 13, PHP 8.4, Livewire 4, Bootstrap 5.3 und Bootstrap Icons
per Vite, highlight.js, SQLite, spatie/laravel-permission.

## Lokales Setup

Das Package wird als Path-Repository aus `packages/nfgarching/core`
eingebunden (eigenes Git-Repository, vom Host-Repo per `.gitignore`
ausgenommen):

```bash
git clone https://github.com/nfgarching/laravel-bootstrap-core.git packages/nfgarching/core
composer install
cp .env.example .env            # für lokal: APP_ENV=local, APP_DEBUG=true, APP_URL anpassen
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install && npm run build
composer run dev                # oder: php artisan serve
```

Tests: `php artisan test --compact` (Feature-Tests unter `tests/Feature/Demo`).

## Demo-Konten

Der Seeder legt die Rollen `user`, `partner`, `admin` und je ein Konto
(`demo-<rolle>@example.com`) mit zufälligem Passwort an. Angemeldet wird nur
über die Ein-Klick-Buttons (`POST /demo/login/{role}`, rate-limitiert); ein
Passwort erscheint nirgends. `/register` ist durch eine App-Route ersetzt.

## Zurücksetzen: `demo:reset`

```bash
php artisan demo:reset          # migrate:fresh --seed --force + cache:clear
```

Der Scheduler führt den Befehl täglich um 04:00 Uhr (Europe/Berlin) aus.
Auf dem Server dafür den Cron-Eintrag für `php artisan schedule:run` jede
Minute einrichten. Alle Seiten zeigen den Hinweis „Demo – alle Daten werden
täglich zurückgesetzt.“

## Aufbau

| Ort | Inhalt |
| --- | --- |
| `routes/web.php` | Demo-Routen (`demo.home`, `demo.core.*`), Demo-Login, Overrides von `/register` und `/welcome` |
| `app/Providers/DemoServiceProvider.php` | Sidebar-Abschnitt und Navbar-Eintrag über die Registries, Livewire-Komponenten, Rate-Limit |
| `app/Demo/CorePages.php` | Liste der core-Unterseiten (Sidebar, Kacheln, Doku-Links) |
| `app/Demo/ExamplePackage/` | Pseudo-Package für die Registries-Seite (Navbar, Sidebar, Modal mit `when`-Guard) |
| `app/Http/Middleware/DisableDemoRoutes.php` | Sperrt Package-Routen, die in der Demo nicht aufrufbar sein dürfen |
| `app/Livewire/Demo/` | `SafeRaw`/`SafeField` (abgesicherte Package-Modals), `Playground`, `ContactListing` |
| `resources/views/layouts/parts/` | Overrides der App-Shell (Vite statt CDN, Sidebar, Navbar, Offcanvas, Toasts) |
| `resources/views/components/demo/` | `x-demo.page` (Seitenrahmen) und `x-demo.example` (Vorschau + Blade-Code) |
| `resources/views/demo/core/examples/` | Ein Blade-Partial je Beispiel |
| `docs/package-fixes.md` | Gefundene Probleme im Package mit Lösungsvorschlag |

Das Package selbst wird nicht verändert – Anpassungen laufen über das
Override-Pattern, die Registries und eigene Routen.

## Ein weiteres Package als Demo-Bereich ergänzen

Gleiches Muster wie für core, Beispiel `mailer`:

1. **Package einbinden** – Path-Repository in `composer.json`, `composer require nfgarching/mailer:@dev`.
2. **Seitenliste** – `app/Demo/MailerPages.php` analog zu `CorePages` (Route, Titel, Icon, Doku-Datei).
3. **Routen** – eigener Präfix und Namensraum in `routes/web.php`:
   ```php
   Route::prefix('mailer')->name('demo.mailer.')->controller(MailerController::class)->group(function () {
       Route::get('/', 'index')->name('index');
   });
   ```
4. **Sidebar-Abschnitt** – eigene View (z. B. `demo.navigation.mailer`) im
   `DemoServiceProvider` registrieren und in `DemoPackages::upcoming()` den
   „demnächst“-Eintrag entfernen:
   ```php
   $this->app->make(SidebarNavigation::class)->section('demo.navigation.mailer', order: 20);
   ```
5. **Seiten** – je Unterseite ein Rahmen wie `x-demo.page` (Einleitung, Karten,
   Link „Dokumentation auf GitHub“) und je Beispiel ein Partial unter
   `resources/views/demo/mailer/examples/…`, eingebunden mit
   `<x-demo.example title="…" view="demo.mailer.examples.…" />`. Braucht ein
   Beispiel einen Livewire-Kontext, `:livewire="true"` setzen (die
   `Playground`-Komponente akzeptiert dafür Views unter `demo.core.examples.`
   – den Präfix bei Bedarf erweitern).
6. **Kachel** auf der Startseite (`resources/views/demo/home.blade.php`)
   aktivieren und Feature-Tests unter `tests/Feature/Demo` ergänzen.
