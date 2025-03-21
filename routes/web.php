<?php

use App\Livewire\Settings\UserManagement;
use App\Livewire\Settings\Permissions;
use App\Livewire\Pages\PageComponent;
use App\Livewire\FrontPageComponent;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Livewire\Livewire;
use App\Http\Livewire\Settings\UserList;
use App\Livewire\Settings\RoleList;


//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

Route::get('/', FrontPageComponent::class)->name('home');

// Динамические страницы по slug
Route::get('/page/{slug}', FrontPageComponent::class)->name('page.show');

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
    Volt::route('settings/permissions', Permissions::class)->name('settings.permissions');
    Volt::route('settings/locale', 'settings.locale')->name('settings.locale');
    Volt::route('dashboard/pages', PageComponent::class)->name('dashboard.pages');
    Volt::route('pages', PageComponent::class)->name('pages');

});

require __DIR__.'/auth.php';
