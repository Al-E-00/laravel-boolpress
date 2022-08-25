<?php

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Entree', 'Primi', 'Secondi', 'Contorni', 'Dolci'];

        foreach($categories as $category) {
            Category::create([
                'name' =>$category,
                'slug' => Str::slug($category)
            ]);
        }
    }
}
