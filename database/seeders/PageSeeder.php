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
        ['name' => 'Homepage', 'slug' => 'home', 'is_editable' => false],
        ['name' => 'About Us', 'slug' => 'about', 'is_editable' => false],
        ['name' => 'Contact Us', 'slug' => 'contact'],
        ['name' => 'Privacy Policy', 'slug' => 'privacy', 'is_editable' => true],
        ['name' => 'Terms of Service', 'slug' => 'terms', 'is_editable' => true],
    ];

    foreach ($pages as $page) {
        \App\Models\Page::firstOrCreate(
            ['slug' => $page['slug']],
            ['name' => $page['name']]
        );
    }
}
}
