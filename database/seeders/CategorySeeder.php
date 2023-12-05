<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get('./database/data/categories.json');

        $categorie =  collect(json_decode($json, true));

        $categorie->each(function ($cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'description' => $cat['description']
            ]);
        });
    }
}
