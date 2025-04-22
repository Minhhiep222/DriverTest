<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($day = 1; $day <= 31; $day++) {
            DB::table('settings')->insert([
                'date' => $day,
                'start' => '08:00:00',
                'end' => '16:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
