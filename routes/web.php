<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

use App\Http\Controllers\Dashboard\TableController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Reservation
Route::view('reservation', 'reservation')
    ->middleware(['auth', 'verified'])
    ->name('reservation');

// Order
Route::view('order', 'order')
    ->middleware(['auth', 'verified'])
    ->name('order');

// Tables
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('dashboard/tables', TableController::class)
        ->names([
            'index' => 'dashboard.tables',
            'create' => 'dashboard.tables.create',
            'store' => 'dashboard.tables.store',
            'show' => 'dashboard.tables.show',
            'edit' => 'dashboard.tables.edit',
        ])
        ->only(['index', 'create', 'store', 'show', 'edit']);
});

Route::delete('dashboard/tables/{table}', [TableController::class, 'destroy'])
    ->name('dashboard.tables.destroy');



// Menu
Route::view('menu', 'menu')
    ->middleware(['auth', 'verified'])
    ->name('menu');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';
