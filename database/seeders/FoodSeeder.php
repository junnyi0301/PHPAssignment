<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $array = [
            [
                'name' => 'Tsukimi',
                'description' => 'Udon, soba or ramen noodle with egg',
                'price' => 11.13,
                'image' => 'storage/images/products/1.webp',
                'category' => 'Food',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Unadon',
                'description' => 'Roasted eel on rice',
                'price' => 28.11,
                'image' => 'storage/images/products/2.webp',
                'category' => 'Food',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Chicken Katsudon',
                'description' => 'Chichken cutlet simmered with egg on rice',
                'price' => 13.96,
                'image' => 'storage/images/products/3.webp',
                'category' => 'Drinks',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Chicken Katsu Ramen',
                'description' => 'Fried chicken ramen, choice of miso-based or spicy soup',
                'price' => 14.91,
                'image' => 'storage/images/products/4.webp',
                'category' => 'Food',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($array as $item) {
            $itemExists = DB::table('food')->where('name', $item['name'])->exists();
            if (!$itemExists) {
                DB::table('food')->insert($item);
            }
        }
    }
}