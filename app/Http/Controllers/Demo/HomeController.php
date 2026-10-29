<?php

namespace App\Http\Controllers\Demo;

use App\Demo\DemoPackages;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('demo.home', ['upcoming' => DemoPackages::upcoming()]);
    }
}
