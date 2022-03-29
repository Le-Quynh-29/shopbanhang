<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();

        $faker = Factory::create();

        $limit = 50;

        for ($i = 1; $i <= $limit; $i++) {
            $number = rand(2, 10);
            $name = $faker->name;
            DB::table('products')->insert([
                'code' => $faker->numerify('SP#######'),
                'name' => $name,
                'slug' => Str::slug($name, '-'),
                'details' => $this->randDetails($number),
                'description' => $faker->paragraph(6, true),
                'like' => rand(0, 10000),
                'buy' => rand(0, 10000),
                'price_from' => rand(50000, 70000),
                'price_to' => rand(100000, 300000),
                'user_id' => rand(1, 15),
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ]);
        }
    }

    public function randDetails($number)
    {
        $faker = Factory::create();
        $array = [];
        for ($i = 1; $i <= $number; $i++) {
            $key = $faker->stateAbbr;
            $value = $faker->name;
            array_push($array, ['key' => $key, 'value' => $value]);
        }
        return json_encode($array);
    }
}
