# Notwendige Änderungen am Package `nfgarching/core`

Gesammelt beim Aufbau der Demo (Stand: 2026-10-29, Package-Commit `a5514d9`).
Das Package wurde **nicht** geändert; wo die Demo einen Workaround in der App
hat, steht er in der Spalte „Demo“.

## Sicherheit (vor öffentlichem Einsatz beheben)

| Datei | Problem | Vorschlag | Demo |
| --- | --- | --- | --- |
| `src/Livewire/Raw.php` | `open()` (Event `openModalRaw`) und `mount()` (`/raw?model=…&keyid=…`) laden **jede** Model-Klasse. Jeder Besucher kann z. B. `App\Models\User` ansehen (inkl. Passwort-Hash), ändern und löschen. | Whitelist per Config (`core.raw_models`) und/oder Policy-Prüfung (`$this->authorize('update', $item)`) vor Laden, Speichern und Löschen. | Alias `modal.raw` durch `App\Livewire\Demo\SafeRaw` ersetzt (nur `Contact`, Löschen deaktiviert); Middleware sperrt `/raw` für andere Models. |
| `src/Livewire/Modals/Field.php` | `open()` akzeptiert beliebige `modelClass` und `field`; `saveModal()` schreibt jedes Feld (z. B. `password`). `$field` ist eine öffentliche, vom Client änderbare Property. | Whitelist der Models/Felder, `#[Locked]` auf `field`, Autorisierung in `saveModal()`. | `App\Livewire\Demo\SafeField` |
| `resources/views/pages/admin.blade.php` | Gibt `config('database.connections')` aus – inklusive Hosts, Benutzer und Passwörter. | Entfernen oder nur bei `app()->isLocal()` anzeigen. | App-View `resources/views/admin.blade.php` |
| `resources/views/pages/dashboard.blade.php`, `layouts/parts/offcanvas.blade.php` | Zeigen Hostname, Datenbank-Host und -Pfad. | Nur lokal anzeigen oder entfernen. | App-Overrides |
| `resources/views/layouts/parts/toasts.blade.php` | `show-toast` setzt Titel/Text per `innerHTML` – Meldungen mit Benutzerdaten werden als HTML interpretiert. | `textContent` verwenden (wie bereits bei `show-message`). | Override mit `textContent` |
| `resources/views/layouts/{main,guest,popup}.blade.php` | `Session::get('message')` wird ungeschützt in ein JS-String-Literal im `x-init`-Attribut geschrieben; ein Apostroph bricht das Skript, Inhalte können Code einschleusen. | `x-init="$dispatch('show-message', { message: @js(Session::get('message')) })"`. | – |
| `src/Controllers/Auth/AuthenticatedSessionController.php` | Kein Rate-Limit auf `POST /login`. | `throttle:login` bzw. `RateLimiter` wie in Laravel Breeze. | Demo-Login hat eigenes Rate-Limit. |

## Fehler (Exceptions, kaputte Funktionen)

| Datei | Problem | Vorschlag | Demo |
| --- | --- | --- | --- |
| `resources/views/layouts/parts/sidebar.blade.php` | `route('textgenerator.testpage')` ohne `Route::has` → `RouteNotFoundException` in jeder App ohne textgenerator-Package; dazu fest verdrahtete Menüs (Controllers, Docker, Testpages, Externe Links) mit Links auf App-Routen. | Guard ergänzen; die Menüs über die `SidebarNavigation`-Registry beitragen lassen. | Sidebar-Override, nur Registry-Bereiche |
| `resources/views/pages/dashboard.blade.php` | `route('users.index')`, `users.create`, `bookings.create`, `files.create`, `documents.create`, `mails.create`, `names.create`, `registers.create` ohne Guard → Exception. | `Route::has()`-Guards oder Links über Registry. | App-View `resources/views/dashboard.blade.php` |
| `resources/views/pages/testpage.blade.php` | Nutzt `<x-alert>`, die es im Package nicht gibt. | Komponente ergänzen oder Seite entfernen. | `testpage`, `testform`, `testing` per Middleware deaktiviert |
| `resources/views/layouts/parts/toasts.blade.php` | `show-toast` wählt alle `.toast` aus und öffnet damit auch den roten Meldungs-Toast mit „Dies ist eine Testmitteilung.“ | Nur `#liveToast` öffnen (`bootstrap.Toast.getOrCreateInstance(...)`). | Override |
| `src/Controllers/PropController.php` | `destroy()` und `action()` sind Stubs mit `dd()`; `store()` mit `switchTo=delete` liefert eine leere Antwort; `store()`/`update()` validieren nicht – ohne `model_type`/`model_id` entsteht ein SQL-Fehler (500). | Implementieren bzw. entfernen; Form Requests für store/update. | Middleware `DisableDemoRoutes` fängt destroy, action, Sammel-Löschen und store ohne Model ab. |
| `resources/views/pages/props/index.blade.php` | Sammelaktion „Ändern“ hat keine Auswahlfelder für `state`/`type` → bewirkt nichts; der Footer-Button `<x-form.submit />` sendet ohne `switchTo` und legt einen leeren Prop an (→ 500); `<x-slot:header>` wird mit `</x-slot:head>` geschlossen; „No Data found“ englisch. | Selects für state/type im Footer, Submit-Button entfernen, Slot-Tag korrigieren, Texte über `__()`. | – |
| `resources/views/components/button/submit.blade.php` | Rendert zusätzlich einen festen `<button type="submit" class="btn btn-success">Submit</button>`. | Zeile entfernen; `type="submit"` statt `button` für den eigentlichen Button. | In der Galerie sichtbar, Hinweis im Text |
| `resources/views/components/button/props.blade.php` | Nutzt `route('props.show')`/`route('props.index')` – die Routen heißen `core.props.*`; endet mit einem verwaisten `</td>`. | Routennamen korrigieren, `</td>` entfernen. | Nicht in der Galerie |
| `resources/views/components/nav/link.blade.php` und `components/sidebar/link.blade.php` | Beide deklarieren den Tag `nav.link`; welcher gewinnt, hängt von der Scan-Reihenfolge ab. `nav/link` delegiert an `button.dispatch` und öffnet Links per `window.open` in neuem Tab statt normal zu navigieren. | Einen der beiden Aliase umbenennen; Navigationslinks als `<a href>`. | Demo-Navigation nutzt eigenes Markup |
| `resources/views/components/listing/*` | `listing/index`, `listing/card/headerRight` und `modal/switch` binden App-Views (`livewire.listing.*`, `livewire.modal.*`) ein; `headerRight` und `table/row2` nutzen Tags ohne `x-`-Präfix (`<button.insert />`, `<button.raw>`, `<button.select>`), die als unbekannte HTML-Elemente im DOM landen; `listing/empty.blade.php` ist leer. | Auf Package-Komponenten umstellen (`<x-button.raw>` …), `listing.empty` mit Inhalt füllen. | Demo-Listing nutzt nur headerLeft, row1/row2, footer, nodata |
| `resources/views/components/listing/table/header.blade.php` | Feste Spalte `suchbegriff`; nutzt `@sortablelink` (kyslik) – im Livewire-Kontext zeigen die Links auf `/livewire/update`. | Livewire-Sortierung über `sortBy()` wie `dropdown.sort`. | weggelassen |
| `resources/views/components/listing/pagination.blade.php` | Option `--` setzt `pageLimit` auf `'--'` → Fehler beim Paginieren; Werte als Strings `05`. | Werte als Zahlen, Platzhalter als `disabled`-Option. | – |
| `resources/views/components/field/wire/float/search.blade.php` | Laut Kommentar „Does not work yet“; Label zeigt Debug-Text `-c:wire-` mit Uhrzeit. | Fertigstellen oder als experimentell kennzeichnen; Debug-Text entfernen. | In der Galerie sichtbar, Hinweis im Text |
| `resources/views/components/field/wire/float/input.blade.php` | `'form-control' . $class` – fehlendes Leerzeichen, eine übergebene Klasse verschmilzt mit `form-control`. | `'form-control '.$class`. | – |
| `resources/views/components/field/wire/default/text.blade.php` | `wire:model` wird doppelt gesetzt (Switch und danach fest). | Feste Zeile entfernen. | – |
| `resources/views/components/field/wire/float/select-enum.blade.php` | Attribut `id` doppelt. | Doppeltes `id` entfernen. | – |
| `resources/views/components/field/html/default/input.blade.php`, `field/wire/default/input.blade.php` | `list="datalist_…"` passt nicht zur `id="datalist-…"` – die Datalist wird nie verbunden. | Einheitliche ID. | – |
| `resources/views/components/form/select.blade.php` | Literaler Text `$autocomplete` im `<select>`-Tag. | `autocomplete="{{ $autocomplete }}"`. | – |
| `resources/views/components/form/input.blade.php` | Setzt immer `list="datalist-…"`, auch ohne Datalist. | Nur bei `$datalist`. | – |
| `resources/views/components/show/info.blade.php` | Ruft in einer Zeile `dump()` auf – Var-Dumper-Ausgabe auch in Produktion und in Testausgaben. | Entfernen oder nur bei `app()->isLocal()`. | – |
| `resources/views/livewire/partials/raw-fields.blade.php` | SQLite meldet Typen großgeschrieben (`TEXT`, `tinyint(1)`, `datetime`); nur exakte Kleinschreibung wird erkannt, alle anderen Felder sind gesperrt. | Typ normalisieren (`strtolower`, Präfix-Vergleich). | – |
| `src/Livewire/Modals/Field.php` | `saveModal()` sendet `reload`, auf das niemand hört – die Seite zeigt den alten Wert. | `reload-window` senden (Listener existiert im Layout). | – |
| `resources/views/components/modal/msg.blade.php` | Ignoriert übergebene `id`; `size="modal-sm"` landet als HTML-Attribut statt als Klasse; wird bereits global im Layout gerendert – erneutes Einbinden erzeugt doppelte IDs. | `class="modal-sm"` verwenden; Doku: nur einmal pro Seite. | Galerie zeigt nur die Auslöser |
| `resources/views/components/card/index.blade.php` | Ohne `headerLeft`/`headerRight` erscheinen Platzhalter `.get_cardheader_left/right`. | Kopf nur rendern, wenn ein Slot gesetzt ist. | Demo setzt immer `header` oder beide Slots |
| `resources/views/components/table/filter/dropdown-bool.blade.php` | Verweist auf undefiniertes `$enum`; Optionen „True/False“ englisch. | Enum-Logik entfernen, Texte über `__()`. | – |
| `resources/views/components/table/filter/index.blade.php` | Submit-Button hat `type` doppelt. | Zweites `type` entfernen. | – |
| `src/Traits/ListingTrait.php` | Standard-`sortField` ist `NR` (Legacy-Spalte); `build_search()` nutzt MySQL-only `SHOW FIELDS`. | Standard `id`; Spalten über `Schema::getColumnListing()`. | Demo setzt `sortField` in `mount()` |
| `routes/web.php` | `/welcome` und `/greeting_from_bootstrap` laufen ohne `web`-Middleware; `/welcome` rendert die `welcome`-View der App. | In die `web`-Gruppe aufnehmen oder entfernen. | `/welcome` per App-Route auf `/` umgeleitet |

## Konfiguration und Doku

| Datei | Problem | Vorschlag | Demo |
| --- | --- | --- | --- |
| `resources/views/layouts/parts/head.blade.php`, `script.blade.php` | Laden Bootstrap 5.3.2 und Icons 1.10.3 fest per CDN, obwohl README „werden von der Anwendung per Vite geladen“ sagt; eine App mit Vite lädt Bootstrap doppelt. | Config-Schalter (`core.assets = cdn|vite`) oder `@stack('head')`-Hook. | Overrides mit `@vite` |
| `resources/views/components/table/head/sort.blade.php` | kyslik/column-sortable nutzt standardmäßig Font-Awesome-Klassen – im Bootstrap-Theme ohne Icons. | Config mit Bootstrap-Icons mitliefern oder in README dokumentieren. | `config/columnsortable.php` mit `bi-sort-*` |
| `README.md`, `docs/route-rollen.md` | Rollenvorgabe `Administrator`/`Partner`; dass `role:` ohne Rangfolge arbeitet, steht nur in der Detail-Doku. | Hinweis im README-Abschnitt „Rollen“. | – |
| `docs/layout.md` | Nennt die View `layout::layouts.main`, registriert ist `layout::main`. | Namen korrigieren. | – |
| `docs/komponenten-registrierung.md` | Tabelle enthält `nav.popup` nicht und den doppelten Alias `nav.link` (s. o.) nur einmal. | Tabelle neu generieren. | – |

## In der Galerie weggelassen

| Komponente | Grund |
| --- | --- |
| `modal/xmodal.blade.php` | Tailwind-/Breeze-Markup (`fixed inset-0`, `sm:max-w-*`), kein x-tags-Header – im Bootstrap-Theme nicht sinnvoll darstellbar. |
| `listing/index`, `listing/card/headerRight`, `listing/table/header` | Binden App-Views ein bzw. nutzen kaputte Tags (s. o.). |
| `button/props`, `button/open-modal-value` | Falsche Routennamen bzw. Event `openModalValue` ohne Listener im Package. |
| `dataset/panel` | Braucht `ManagesDataset` und eine `dataset_entries`-Tabelle (nur als `.todo`-Migration vorhanden). |
| `nav/buttons` (`nav.pagination-buttons`) | Braucht `MainControllerTrait::getNavigationData()` mit einer Show-Route je Model. |
| `table/check`, `table/toggle`, `table/cell` | Globale `docheck()`/`toggle()`-Funktionen wirken auf alle Checkboxen der Seite; durch `table.head.toggle` ersetzt. |
