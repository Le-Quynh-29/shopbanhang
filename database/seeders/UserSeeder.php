<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
    }
}
