<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\User;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $categories = Category::all();
        $countCategories = $categories->count() - 1;
        
        $users = User::all();
        $countUsers = $users->count() - 1;
        
        for ($j=0; $j <3 ; $j++) { 
            for($i=1; $i < 51; $i++){
                $title = $faker->company;
                
                Service::create([
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'description' => $faker->text(100, 300),
                    'price' => $faker->numberBetween(500, 10000),
                    'category_id' => rand(1, $countCategories),
                    'user_id' => rand(1, $countUsers),
                ]);
            }
        }
    }
}
