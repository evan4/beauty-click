<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shippings')->insert([
            [
                'title' => 'Доставка по городу',
                'description' => '',
                'price' => 200,
            ],
            [
                'title' => 'Доставка курьером',
                'description' => 'Доставка осуществляется в рабочее время с 8 до 20 часов',
                'price' => 550,
            ],
            [
                'title' => 'Самовывоз из магазина',
                'description' => '',
                'price' => 0,
            ],
            [
                'title' => 'Доставка Почта России',
                'description' => 'Стоимость зависит от города доставки и веса посылки',
                'price' => 0,
            ],
        ]);
    }
}
