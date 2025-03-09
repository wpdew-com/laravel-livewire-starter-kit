<?php

use App\Http\Livewire\Settings\UserManagement;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Livewire\Livewire;
use App\Http\Livewire\Settings\UserList;
use App\Livewire\Settings\RoleList;
use App\Http\Livewire\Settings\Permissions;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Volt::route('settings/user-list', 'settings.user-list')->name('settings.user-list');
    Volt::route('settings/roles', 'settings.role-list')->name('settings.role-list');
    Volt::route('settings/permissions', 'settings.permissions')->name('settings.permissions');

});

Route::middleware(['auth'])->group(function () {

    Route::get('settings/locale', \App\Livewire\Settings\Locale::class)->name('settings.locale');
    //Route::get('settings/user-list', 'settings.user-list')->name('settings.user-list');
    //Route::get('/settings/users', UserManagement::class)->name('settings.users');

});





require __DIR__.'/auth.php';
