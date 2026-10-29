<?php

namespace App\Demo;

use App\Http\Middleware\DisableDemoRoutes;
use App\Models\User;
use Closure;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteAction;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Nfgarching\Core\Helpers\RouteRoles;
use ReflectionFunction;

/**
 * Ermittelt zur Laufzeit alle Routen von nfgarching/core und ob der aktuelle
 * Nutzer sie aufrufen darf – aus der wirksamen Middleware der Route und den
 * Rollengruppen von RouteRoles.
 */
class RouteAccessMatrix
{
    public function __construct(private Router $router) {}

    /**
     * @return list<array{methods: string, uri: string, name: ?string, group: ?string, requirement: string, accessible: bool, disabled: bool, overridden: bool}>
     */
    public function rows(?User $user): array
    {
        $packagePath = (string) realpath(base_path('vendor/nfgarching/core'));
        $rows = [];

        foreach ($this->router->getRoutes()->getRoutes() as $route) {
            if (! $this->isPackageRoute($route, $packagePath)) {
                continue;
            }

            $middleware = $route->gatherMiddleware();
            $roleMiddleware = collect($middleware)->first(fn (mixed $entry): bool => is_string($entry) && str_starts_with($entry, 'role:'));
            $roles = $roleMiddleware ? explode('|', Str::after($roleMiddleware, 'role:')) : [];

            $rows[] = [
                'methods' => implode('|', array_diff($route->methods(), ['HEAD'])),
                'uri' => '/'.ltrim($route->uri(), '/'),
                'name' => $route->getName(),
                'group' => $this->groupFor($roleMiddleware),
                'requirement' => $this->requirement($middleware, $roles),
                'accessible' => $this->accessible($middleware, $roles, $user),
                'disabled' => in_array($route->getName(), DisableDemoRoutes::DISABLED_ROUTES, true),
                'overridden' => $this->isOverridden($route),
            ];
        }

        usort($rows, fn (array $a, array $b): int => [$a['uri'], $a['methods']] <=> [$b['uri'], $b['methods']]);

        return $rows;
    }

    private function isPackageRoute(Route $route, string $packagePath): bool
    {
        $action = $route->getAction();

        if (RouteAction::containsSerializedClosure($action)) {
            $action['uses'] = unserialize($action['uses'])->getClosure();
        }

        $uses = $action['uses'] ?? null;

        if ($uses instanceof Closure) {
            return $packagePath !== '' && str_starts_with((string) (new ReflectionFunction($uses))->getFileName(), $packagePath);
        }

        return is_string($uses) && str_starts_with($uses, 'Nfgarching\\Core\\');
    }

    /**
     * Eine später registrierte App-Route mit gleicher Methode und URI ersetzt
     * die Package-Route beim Matching (z. B. /register).
     */
    private function isOverridden(Route $route): bool
    {
        $routes = $this->router->getRoutes();
        $key = $route->getDomain().$route->uri();

        foreach ($route->methods() as $method) {
            if (($routes->get($method)[$key] ?? $route) !== $route) {
                return true;
            }
        }

        return false;
    }

    private function groupFor(?string $roleMiddleware): ?string
    {
        if ($roleMiddleware === null) {
            return null;
        }

        foreach (array_keys((array) config('app.route_roles')) as $group) {
            if (RouteRoles::middleware($group) === [$roleMiddleware]) {
                return $group;
            }
        }

        return null;
    }

    /**
     * @param  array<int, mixed>  $middleware
     * @param  list<string>  $roles
     */
    private function requirement(array $middleware, array $roles): string
    {
        return match (true) {
            in_array('guest', $middleware, true) => __('nur Gäste'),
            $roles !== [] => __('Rolle: :roles', ['roles' => implode(', ', $roles)]),
            in_array('auth', $middleware, true) => __('Login'),
            default => __('öffentlich'),
        };
    }

    /**
     * @param  array<int, mixed>  $middleware
     * @param  list<string>  $roles
     */
    private function accessible(array $middleware, array $roles, ?User $user): bool
    {
        if (in_array('guest', $middleware, true)) {
            return $user === null;
        }

        if (in_array('auth', $middleware, true) && $user === null) {
            return false;
        }

        return $roles === [] || $user?->hasAnyRole($roles) === true;
    }
}
