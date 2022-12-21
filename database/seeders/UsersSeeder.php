<?php

namespace Database\Seeders;

use Illuminate\Contracts\Pipeline\Hub;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_guid' => Str::uuid(),
            'name' => 'The YP Direct',
            'email' => 'admin@ypdirect.com',
            'password' => Hash::make('123456'),
            'user_type_id' => 1,
            'user_status' => 'Verified',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
