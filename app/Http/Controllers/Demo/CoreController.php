<?php

namespace App\Http\Controllers\Demo;

use App\Demo\ExamplePackage\ExampleServiceProvider;
use App\Demo\Favicons;
use App\Demo\RouteAccessMatrix;
use App\Enums\ContactStatus;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Nfgarching\Core\Modals\ModalRegistry;
use Nfgarching\Core\Models\Prop;
use Nfgarching\Core\Navigation\NavbarNavigation;
use Nfgarching\Core\Navigation\SidebarNavigation;

/**
 * Seiten des Demo-Bereichs /core.
 */
class CoreController extends Controller
{
    public function index(): View
    {
        return view('demo.core.index');
    }

    public function layout(): View
    {
        return view('demo.core.layout', ['favicons' => Favicons::VARIANTS]);
    }

    public function components(Request $request): View
    {
        $perPage = min(max($request->integer('per_page', 5), 1), 100);

        $contacts = Contact::search($request->string('search')->toString())
            ->when($request->filled('city'), fn ($query) => $query->where('city', $request->string('city')->toString()))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->when($request->filled('newsletter'), fn ($query) => $query->where('newsletter', $request->boolean('newsletter')))
            ->sortable(['id' => 'asc'])
            ->paginate($perPage)
            ->withQueryString()
            ->fragment('tabelle');

        return view('demo.core.components', [
            'contacts' => $contacts,
            'contact' => Contact::query()->with('props')->first(),
            'prop' => Prop::query()->first(),
            'cities' => Contact::query()->distinct()->orderBy('city')->pluck('city', 'city')->all(),
            'statusEnum' => ContactStatus::class,
            'request' => $request,
        ]);
    }

    public function livewire(): View
    {
        return view('demo.core.livewire', ['contact' => Contact::query()->first()]);
    }

    public function registries(): View
    {
        return view('demo.core.registries', [
            'active' => ExampleServiceProvider::active(),
            'providerSource' => file_get_contents((new \ReflectionClass(ExampleServiceProvider::class))->getFileName()),
            'navbarItems' => app(NavbarNavigation::class)->visibleItems(),
            'sidebarSections' => app(SidebarNavigation::class)->visibleSections(),
            'modals' => app(ModalRegistry::class)->visibleModals(),
        ]);
    }

    public function props(): View
    {
        return view('demo.core.props', [
            'propCount' => Prop::query()->count(),
            'contactCount' => Contact::query()->has('props')->count(),
            'states' => Prop::query()->toBase()->selectRaw('state, count(*) as total')->groupBy('state')->pluck('total', 'state'),
            'types' => Prop::query()->toBase()->selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type'),
            'contact' => Contact::query()->withCount('props')->first(),
        ]);
    }

    public function roles(Request $request, RouteAccessMatrix $matrix): View
    {
        return view('demo.core.roles', ['routes' => $matrix->rows($request->user())]);
    }
}
