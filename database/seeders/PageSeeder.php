<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $pages = [
        ['name' => 'Homepage', 'slug' => 'home'],
        ['name' => 'About Us', 'slug' => 'about'],
        ['name' => 'Contact Us', 'slug' => 'contact'],
        ['name' => 'Privacy Policy', 'slug' => 'privacy'],
        ['name' => 'Terms of Service', 'slug' => 'terms'],
    ];

    foreach ($pages as $page) {
        \App\Models\Page::firstOrCreate(
            ['slug' => $page['slug']],
            ['name' => $page['name']]
        );
    }
}
}
