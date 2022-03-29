<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        $faker = Factory::create();

        $limit = 50;

        for ($i = 1; $i <= $limit; $i++) {
            $name = $faker->name;
            DB::table('categories')->insert([
                'name' => $name,
                'slug' => Str::slug($name, '-'),
                'user_id' => rand(1,15),
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
