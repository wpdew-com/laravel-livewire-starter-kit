# Laravel Livewire Starter Kit

Complete **User Management**, **Role Management** and **Permissions Management** with a Dashboard for Admins.

Supporting multiple languages.

> Updated for Laravel 12.0 **and** Livewire 3.0

This repository contains my starting point when developing a new Laravel project.
It comes with a basic user management, role management and permissions management and a dashboard.

## TALL stack

- [Tailwind CSS](https://tailwindcss.com)
- [Flowbite](https://flowbite.com) for Tailwind CSS components
- [Alpine.js](https://alpinejs.dev)
- [Laravel](https://laravel.com)
- [Laravel Livewire](https://livewire.laravel.com) using the components.
- [Flux UI](https://fluxui.dev) for flexible UI components
- [Heroicons](https://heroicons.com) for icons

## Further it includes:

- [Spatie Roles & Permissions](https://spatie.be/docs/laravel-permission/v5/introduction) for user roles and permissions


### Upcoming features

- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) for debugging


# Installation

```bash
git clone https://github.com/wpdew-com/laravel-livewire-starter-kit .
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

You could also just use this repository as a starting point for your own project by clicking use template.

## 1. Install dependencies Migration end Seeding

```bash
npm install
npm run build

php artisan migrate
php artisan db:seed
php artisan db:seed --class=RolesAndPermissionsSeeder
php artisan db:seed --class=PageSeeder
```


## 2. Creating the first Super Admin user

```bash
php artisan app:create-super-admin
```

or use admin 
```bash
admin@admin.com
adminadmin
```

## 3. Set default timezone if different from UTC

```php
// config/app.php
return [
    // ...
    
    'timezone' => 'Europe/Copenhagen' // Default: UTC
    
    // ...
];
```

## 3. Start the development server

```bash
php artisan serve
```

# Developing


# Donate
If you like this project, please consider donating to support it. Thank you!

[![Donate](https://img.shields.io/badge/Donate-MonoBank-green.svg)](https://send.monobank.ua/jar/31rUKHy9fw)
