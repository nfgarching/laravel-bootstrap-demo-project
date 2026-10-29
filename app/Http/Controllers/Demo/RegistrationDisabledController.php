<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Ersetzt /register des Packages: In der Demo gibt es nur die drei Demo-Konten.
 */
class RegistrationDisabledController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('post')) {
            return redirect()->route('register')
                ->with('message', __('Die Registrierung ist in der Demo deaktiviert.'));
        }

        return view('demo.register-disabled');
    }
}
