<?php

namespace App\Http\Controllers\Demo;

use App\Demo\ExamplePackage\ExampleServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Schaltet das Beispiel-Package für die aktuelle Session ein oder aus.
 */
class ExamplePackageController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->session()->put(ExampleServiceProvider::SESSION_KEY, ! ExampleServiceProvider::active());

        return redirect()->route('demo.core.registries');
    }
}
