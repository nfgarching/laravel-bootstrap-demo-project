# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this repository is

Two things live side by side:

1. **The host application** — a stock Laravel 13 skeleton (PHP 8.4, Pest 5, Vite 8 + Tailwind 4, SQLite at `database/database.sqlite`). `app/` holds only `User` and the default controller/provider; `routes/web.php` has one route. There is no application domain code yet.
2. **`packages/nfgarching/core`** — a Bootstrap 5 + Livewire 4 base package (`Nfgarching\Core`) with its own git repository (`github.com/nfgarching/laravel-bootstrap-core`), its own `composer.json`, README, CHANGELOG and `docs/`. This is where essentially all real code is.

**The package is currently not wired into the host application.** There is no `repositories`/`require` entry for `nfgarching/core` in the root `composer.json`, no PSR-4 entry under `autoload`, no `vendor/nfgarching/` symlink, and `LibraryServiceProvider` is not in `bootstrap/providers.php`. Consequently none of its routes, views or components are active — `php artisan route:list` shows only `/` and `/up`. Treat the package as a checked-out library, not as loaded code: do not assume `route('core.props.index')`, `<x-card>` or the `core::` view namespace resolve at runtime until it is wired in.

Wiring it in is a dependency change and needs user approval. The package's own README documents the path-repository route; `packages/nfgarching/core/docs/Packages.md` documents both options and recommends the lightweight one (root `autoload` PSR-4 entry + manual provider registration in `bootstrap/providers.php`). Either way it also pulls in `livewire/livewire ^4` and `kyslik/column-sortable ^8`, and some package code references `spatie/laravel-permission` (guarded, optional).

## Commands

```bash
composer setup                      # install, .env, key:generate, migrate, npm install, npm run build
composer run dev                    # php artisan dev — all dev processes (server, vite, queue, logs) in one TUI
npm run dev                         # vite only
npm run build                       # production assets; needed if a frontend change doesn't appear
php artisan test --compact          # full suite
php artisan test --compact tests/Feature/ExampleTest.php
php artisan test --compact --filter=someTestName
vendor/bin/pest                     # same filters, direct runner
vendor/bin/pint --dirty --format agent   # required after touching any PHP file
php artisan pail                    # tail application logs
```

`phpunit.xml` defines two suites, `Unit` and `Feature`, both under `tests/`, and runs against in-memory SQLite. `tests/Pest.php` binds `Tests\TestCase` to `Feature` only and **`RefreshDatabase` is commented out** — enable it per test file, or uncomment it, when a test needs database isolation.

### Running the package's tests

The package's `tests/` directory is not in any suite, so `php artisan test` never picks it up. Its tests are written to run inside a host application (they use `App\Models\User`, the host database and host layouts), so running them means registering a suite in the root `phpunit.xml` pointing at the package path, then:

```bash
php artisan test --compact --testsuite=Core
php artisan test --compact --filter=PropControllerTest
```

Those tests also assume tables the host does not have — `props` has no active migration anywhere (the package's `database/migrations/*.todo` files are drafts, deliberately not `.php`), so the host application must create it.

## Package architecture (`Nfgarching\Core`)

`src/LibraryServiceProvider.php` is the single entry point and the file to read first; the mechanisms it sets up are not discoverable from the view files themselves.

**View namespaces** — `core::` (components), `layout::` (main/guest/popup), `page::` (dashboard, admin, props, …), `auth::`, `core-livewire::` (Livewire partials, deliberately not `livewire` so host overrides can't shadow them). Layouts and pages are publishable (`--tag=nfgarching-layouts`, `--tag=nfgarching-pages`).

**Blade component registration has no central list.** Two mechanisms:
- `Blade::anonymousComponentPath()` makes every file under `resources/views/components/` available as `<x-core::modal.save />` with zero registration.
- Short tags are declared *by the component itself* in the first line of its Blade file: `{{-- x-tags: button, button.link, link --}}`. `registerComponentTags()` scans the first 256 bytes of every component file at boot and registers each alias via `Blade::component()`. A component with no header is reachable only through the `core::` namespace. So: to add a component, drop in a Blade file and optionally add the header — never edit the provider. See `docs/komponenten-registrierung.md`.

**Layout components degrade gracefully** — `<x-app-layout>`, `<x-main-layout>`, `<x-guest-layout>`, `<x-popup-layout>` each resolve to the host's published `resources/views/layouts/*.blade.php` if present, else the package view, and are skipped entirely if the host defines a matching `App\View\Components\*` class.

**Registries instead of hardcoding** — `SidebarNavigation`, `NavbarNavigation` and `ModalRegistry` are singletons bound in `register()` (not `boot()`, so provider boot order never matters). Each feature package contributes its own sidebar section / navbar item / modal partial from its own provider's `boot()` with a view name, an `order`, and an optional `when` closure; core only renders the ordered visible list. This is the extension point for anything cross-cutting — do not add another package's routes to core's sidebar. See `docs/sidebar-navigation.md`, `docs/navbar-navigation.md`, `docs/modal-registry.md`.

**Route roles** — package routes attach `RouteRoles::middleware('<group>')`, which expands to `role:<Roles>` only when spatie/laravel-permission is installed *and* the configured user model has `hasAnyRole()`; otherwise the routes fall back to plain `auth`. Groups (`admin`, `partner`, `user`) map to roles in `config('app.route_roles')`. The provider registers the `role` middleware alias itself if the host hasn't. A host that defines `route_roles` replaces the defaults wholesale, so it must list every group. See `docs/route-rollen.md`.

**Config is merged into `app`, not its own namespace** — `mergeConfigFrom(config/app.php, 'app')`, hence `config('app.start_page')`, `config('app.version')`, `config('app.route_roles')`.

**Shared controller/Livewire logic lives in `src/Traits/`** — `MainControllerTrait` (`get_rows()` for filter/sort/paginate, `getNavigationData()` for first/prev/next/last), `Searchable` (adds a `search()` scope driven by a model's `$searchable` array), `ListingTrait`/`FormTrait`/`ModalTrait` for Livewire components, `HasDataset`/`ManagesDataset`. Check these before writing query or listing code in a controller.

**`Prop`** is a polymorphic key/value/state model (`props` table, `morphTo model()`) usable from any model via `morphMany(Prop::class, 'model')`; `PropController` is the reference CRUD implementation, including a bulk update path through `store()` with `switchTo=change`. Several of its methods (`destroy()`, `action()`) are still stubs.

## Conventions specific to this codebase

- **Package views are Bootstrap 5, not Tailwind.** `docs/Format.md` is binding for Blade/Livewire views in the package: no Tailwind utility classes, Bootstrap 5 + Bootstrap Icons loaded by CDN in the layout head, floating labels as the default form pattern, and core components (`<x-card>`, `<x-button>`, `<x-table>`, `<x-modal>`) preferred over hand-rolled markup. The host skeleton's own `resources/` is Tailwind 4 — keep the two straight and match whichever tree you are editing.
- `docs/Format.md` also flags `<x-form.*>` / `<x-wire.*>` field components as unstable (they render debug text in labels); use direct Bootstrap markup with `wire:` directives for Livewire fields until they settle.
- **Domain language is German** — identifiers, docs, CHANGELOG and commit messages in the package are German; user-facing strings go through `{{ __('…') }}`. The package's `CHANGELOG.md` is maintained by hand, newest entries dated under `[Unreleased]`.
- The package's git repository is independent of the host repository. Commits to `packages/nfgarching/core` must be made in that directory and do not belong in the host's history.

## Agent configuration

- `CLAUDE.md` and `AGENTS.md` are byte-identical; the Laravel Boost guidelines block below (opening tag `laravel-boost-guidelines`) is generated by `php artisan boost:update` (run automatically on `composer update`/`composer require`) and is replaced wholesale on regeneration — put durable project notes above that block, in both files. Never write the literal opening tag in prose above the block: boost:update treats the first occurrence as the block start and truncates everything after it.
- Skills referenced by those guidelines are installed under `.claude/skills/` and `.agents/skills/` (`laravel-best-practices`, `testing-best-practices`, `tailwindcss-development`, `infer-conventions`, `deploying-to-cloud`); `boost.json` controls which are generated.
- The guidelines mention a project rules directory `.ai/rules` — **it does not exist in this repository**, so there is nothing to read there.
- Boost's MCP server is configured in `.mcp.json` (and `.zed/settings.json` for Zed) as `php artisan boost:mcp`.

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

## Foundational Context

This application is a Laravel application running on PHP 8.4. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If a frontend change doesn't show in the UI or you get a "Unable to locate file in Vite manifest" error, run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists, including path-scoped framework guidelines under `.ai/rules/boost`. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.
- Activate the `deploying-to-cloud` skill whenever deploying to Laravel Cloud, configuring Cloud environments or resources, using the Cloud CLI, or troubleshooting Cloud deployments.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

# Pest

- This project uses Pest. Create tests with `php artisan make:test --pest {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.
- Do not delete tests or test files without approval. They are part of the application.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/pest` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.
- After the feature tests pass, ask the user to run the complete suite with `php artisan test --compact`.

</laravel-boost-guidelines>
