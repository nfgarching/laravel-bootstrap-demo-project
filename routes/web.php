<?php

use App\Http\Controllers\Demo\CoreController;
use App\Http\Controllers\Demo\DemoLoginController;
use App\Http\Controllers\Demo\ExamplePackageController;
use App\Http\Controllers\Demo\FaviconController;
use App\Http\Controllers\Demo\HomeController;
use App\Http\Controllers\Demo\RegistrationDisabledController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('demo.home');

Route::prefix('core')->name('demo.core.')->controller(CoreController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('layout', 'layout')->name('layout');
    Route::get('components', 'components')->name('components');
    Route::get('livewire', 'livewire')->name('livewire');
    Route::get('registries', 'registries')->name('registries');
    Route::get('props', 'props')->name('props');
    Route::get('roles', 'roles')->name('roles');
});

Route::post('core/registries/example-package', ExamplePackageController::class)
    ->name('demo.core.registries.toggle');

Route::post('demo/login/{role}', DemoLoginController::class)
    ->middleware('throttle:demo-login')
    ->name('demo.login');

Route::get('favicons/{variant}.ico', FaviconController::class)->name('demo.favicon');

/*
| Overrides von Package-Routen: App-Routen werden nach denen des Packages
| registriert und ersetzen sie bei gleicher Methode und URI.
*/
Route::match(['get', 'post'], 'register', RegistrationDisabledController::class)->name('register');

Route::redirect('welcome', '/')->name('welcome');
