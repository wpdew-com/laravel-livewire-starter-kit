<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::create([
            'title' => 'Home Page',
            'content' => 'Welcome to our home page',
            'description' => 'Home page',
            'uri' => 'home',
            'foto' => ''
        ]);
    }
}
