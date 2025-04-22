<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'account_id' => 2,
                'logo' => '',
                'fullname' => 'Thành nhân',
                'shortname' => 'JD',
                'email' => 'thanhnhan@gmail.com',
                'phone' => '0363336575',
                'MST' => '0363336575',
                'address' => '456 Main St',
                'website' => 'http://janedoe.com',
                'description' => 'Another sample user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
