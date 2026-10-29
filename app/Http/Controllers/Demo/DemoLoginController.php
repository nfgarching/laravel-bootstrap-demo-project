<?php

namespace App\Http\Controllers\Demo;

use App\Enums\DemoRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Ein-Klick-Login für die drei Demo-Konten. Andere Konten lassen sich hierüber
 * nicht anmelden; das Route-Binding akzeptiert nur die Werte von DemoRole.
 */
class DemoLoginController extends Controller
{
    public function __invoke(Request $request, DemoRole $role): RedirectResponse
    {
        $user = User::query()->where('email', $role->email())->firstOrFail();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('demo.core.roles')
            ->with('message', __('Angemeldet als :name.', ['name' => $user->name]));
    }
}
