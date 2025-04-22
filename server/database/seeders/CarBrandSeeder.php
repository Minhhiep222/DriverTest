<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        $carBrands = [
            ['name' => 'Toyota', 'user_id' => 0],
            ['name' => 'Ford', 'user_id' => 0],
            ['name' => 'Honda', 'user_id' => 0],
            ['name' => 'Chevrolet', 'user_id' => 0],
            ['name' => 'BMW', 'user_id' => 0],
            ['name' => 'Mercedes-Benz', 'user_id' => 0],
            ['name' => 'Audi', 'user_id' => 0],
            ['name' => 'Volkswagen', 'user_id' => 0],
            ['name' => 'Nissan', 'user_id' => 0],
            ['name' => 'Hyundai', 'user_id' => 0],
            ['name' => 'Kia', 'user_id' => 0],
            ['name' => 'Subaru', 'user_id' => 0],
            ['name' => 'Mazda', 'user_id' => 0],
            ['name' => 'Jaguar', 'user_id' => 0],
            ['name' => 'Land Rover', 'user_id' => 0],
            ['name' => 'Porsche', 'user_id' => 0],
            ['name' => 'Tesla', 'user_id' => 0],
            ['name' => 'Volvo', 'user_id' => 0],
            ['name' => 'Lexus', 'user_id' => 0],
            ['name' => 'Acura', 'user_id' => 0],
            ['name' => 'Infiniti', 'user_id' => 0],
            ['name' => 'Chrysler', 'user_id' => 0],
            ['name' => 'Dodge', 'user_id' => 0],
            ['name' => 'Jeep', 'user_id' => 0],
            ['name' => 'Fiat', 'user_id' => 0],
            ['name' => 'Mitsubishi', 'user_id' => 0],
            ['name' => 'Peugeot', 'user_id' => 0],
            ['name' => 'Renault', 'user_id' => 0],
            ['name' => 'Ferrari', 'user_id' => 0],
            ['name' => 'Lamborghini', 'user_id' => 0],
            ['name' => 'Maserati', 'user_id' => 0],
            ['name' => 'Aston Martin', 'user_id' => 0],
            ['name' => 'Bentley', 'user_id' => 0],
            ['name' => 'Rolls-Royce', 'user_id' => 0],
            ['name' => 'Bugatti', 'user_id' => 0],
            ['name' => 'McLaren', 'user_id' => 0],
            ['name' => 'Suzuki', 'user_id' => 0],
            ['name' => 'Isuzu', 'user_id' => 0],
            ['name' => 'Saab', 'user_id' => 0],
            ['name' => 'Citroën', 'user_id' => 0],
        ];

        foreach ($carBrands as $brand) {
            CarBrand::create($brand);
        }
    }
}
