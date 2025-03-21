<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Burger',
                'slug' => 'burger',
                'status' => 1,
                'show_at_home' => 1
            ],
            [
                'name' => 'Pizza',
                'slug' => 'pizza',
                'status' => 1,
                'show_at_home' => 1
            ],
            [
                'name' => 'Pasta',
                'slug' => 'pasta',
                'status' => 1,
                'show_at_home' => 1
            ],
            [
                'name' => 'Sandwich',
                'slug' => 'sandwich',
                'status' => 1,
                'show_at_home' => 1
            ]
        ]);
    }
}