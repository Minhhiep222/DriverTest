<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Đỏ', 'user_id' => 0],
            ['name' => 'Xanh dương', 'user_id' => 0],
            ['name' => 'Đen', 'user_id' => 0],
            ['name' => 'Trắng', 'user_id' => 0],
            ['name' => 'Bạc', 'user_id' => 0],
            ['name' => 'Xám', 'user_id' => 0],
            ['name' => 'Xanh lá', 'user_id' => 0],
            ['name' => 'Vàng', 'user_id' => 0],
            ['name' => 'Cam', 'user_id' => 0],
            ['name' => 'Tím', 'user_id' => 0],
            ['name' => 'Nâu', 'user_id' => 0],
            ['name' => 'Vàng đồng', 'user_id' => 0],
            ['name' => 'Hồng', 'user_id' => 0],
        ];

        DB::table('colors')->insert($colors);
    }
}
