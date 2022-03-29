<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $faker = Factory::create();

        DB::table('users')->insert([
            'fullname' => 'admin',
            'username' => 'admin',
            'gender' => 2,
            'birthday' => '29/04/2002',
            'number_phone' => '0358166794',
            'email' => 'lequynh290402@gmail.com',
            'password' => Hash::make('quynh2904'),
            'active' => 1,
            'role' => 1,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        DB::table('users')->insert([
            'fullname' => 'ctv',
            'username' => 'ctv',
            'gender' => 1,
            'birthday' => '05/06/1998',
            'email' => 'khuatanhquan@gmail.com',
            'password' => Hash::make('12345678'),
            'active' => 1,
            'role' => 2,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        DB::table('users')->insert([
            'fullname' => 'user',
            'username' => 'user',
            'gender' => 1,
            'birthday' => '13/03/1999',
            'email' => 'phamquanganh@gmail.com',
            'password' => Hash::make('12345678'),
            'active' => 1,
            'role' => 3,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        $limit = 12;

        for ($i = 1; $i <= $limit; $i++) {
            DB::table('users')->insert([
                'fullname' => $faker->name,
                'username' => $faker->lastName(),
                'gender' => rand(1,2),
                'birthday' => '13/03/1999',
                'email' => $faker->email(),
                'password' => Hash::make('12345678'),
                'active' => rand(0,1),
                'role' => rand(1,3),
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTime()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
