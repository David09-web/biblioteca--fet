<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['code' => '000', 'name' => 'Generalidades'],
            ['code' => '100', 'name' => 'Filosofía y psicología'],
            ['code' => '200', 'name' => 'Religión'],
            ['code' => '300', 'name' => 'Ciencias sociales'],
            ['code' => '400', 'name' => 'Lenguas'],
            ['code' => '500', 'name' => 'Matemáticas y ciencias naturales'],
            ['code' => '600', 'name' => 'Tecnología y ciencias aplicadas'],
            ['code' => '700', 'name' => 'Artes'],
            ['code' => '800', 'name' => 'Literatura'],
            ['code' => '900', 'name' => 'Historia y geografía'],
            ['code' => '1000', 'name' => 'TRABAJOS DE GRADO'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['code' => $category['code']], $category);
        }
    }
}
