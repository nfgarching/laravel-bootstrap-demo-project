<?php

namespace App\Http\Middleware;

use App\Livewire\Demo\SafeRaw;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Fängt Package-Routen ab, die in der öffentlichen Demo nicht aufrufbar sein
 * dürfen (Stubs mit dd(), Testseiten, schreibende Profil-Aktionen), und leitet
 * mit einer Flash-Meldung zurück. Das Package selbst bleibt unverändert.
 */
class DisableDemoRoutes
{
    /**
     * @var list<string>
     */
    public const array DISABLED_ROUTES = [
        'core.props.destroy',
        'core.props.action',
        'settings.update',
        'testpage',
        'testform',
        'testing',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $reason = $this->reason($request, (string) $request->route()?->getName());

        if ($reason === null) {
            return $next($request);
        }

        $previous = url()->previous(route('demo.home'));

        return redirect()
            ->to($request->isMethod('GET') && $previous === $request->fullUrl() ? route('demo.home') : $previous)
            ->with('message', $reason);
    }

    private function reason(Request $request, string $routeName): ?string
    {
        if (in_array($routeName, self::DISABLED_ROUTES, true)) {
            return __('In der Demo deaktiviert.');
        }

        if ($routeName === 'core.props.store') {
            if ($request->input('switchTo') === 'delete') {
                return __('In der Demo deaktiviert.');
            }

            if (! $request->filled('switchTo') && ! $request->filled(['model_type', 'model_id'])) {
                return __('Bitte model_type und model_id angeben.');
            }
        }

        if ($routeName === 'raw' && $request->hasAny(['model', 'keyid']) && ! SafeRaw::allows($request->string('model')->toString())) {
            return __('Dieses Model ist in der Demo nicht freigegeben.');
        }

        return null;
    }
}
