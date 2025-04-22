<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accounts')->insert([
            'phone' => "0834983286", // Số điện thoại ngẫu nhiên
            'password' => bcrypt('Minh hiep04'), // Mật khẩu mặc định (bạn có thể thay đổi mật khẩu này)
            'role' => "admin", // Role ngẫu nhiên
            'status' => "Active", // Trạng thái ngẫu nhiên
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('accounts')->insert([
            'phone' => "0363336575", // Số điện thoại ngẫu nhiên
            'password' => bcrypt('Minh hiep04'), // Mật khẩu mặc định (bạn có thể thay đổi mật khẩu này)
            'role' => "user", // Role ngẫu nhiên
            'status' => "Active", // Trạng thái ngẫu nhiên
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
