<?php

namespace Database\Seeders;

use App\Models\Capabilities;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\User;
use App\Models\TestDriver;
use App\Models\Account;
use App\Models\Image;
use App\Models\BookDriver;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AccountSeeder::class,
            AdminSeeder::class,
            CarSeeder::class,
            CarBrandSeeder::class,
            ColorSeeder::class,
            UserSeeder::class,
        ]);
        // Account::factory(100)->create();
        // User::factory(100)->create();
        // TestDriver::factory(100)->create();
        // Customer::factory(100)->create();
        // Image::factory(5)->create();
        // BookDriver::factory(20)->create();
        // Capabilities::factory(1)->create();
    }
}
