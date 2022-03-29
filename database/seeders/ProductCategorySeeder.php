<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_category')->truncate();

        $limit = 50;

        for ($i = 1; $i <= $limit; $i++) {
            DB::table('product_category')->insert([
                'category_id' => rand(1, 50),
                'product_id' => rand(1, 50)
            ]);
        }
    }
}
