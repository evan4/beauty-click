<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'title' => 'Бодиарт',
                'slug' => 'bodiart',
                'description' => 'Бодиарт'
            ],
            [
                'title' => 'Советы',
                'slug' => 'soveti',
                'description' => 'Советы'
            ],
            [
                'title' => 'Косметология',
                'slug' => 'kosmetologiya',
                'description' => 'Косметология'
            ],
            [
                'title' => 'Биодобавки',
                'slug' => 'biodobavki',
                'description' => 'Биодобавки'
            ],
            
        ]);

    }
}
