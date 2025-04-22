<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carModels = [
            ['name' => 'Corolla', 'brand' => 'Toyota'],
            ['name' => 'Camry', 'brand' => 'Toyota'],
            ['name' => 'RAV4', 'brand' => 'Toyota'],
            ['name' => 'F-150', 'brand' => 'Ford'],
            ['name' => 'Mustang', 'brand' => 'Ford'],
            ['name' => 'Escape', 'brand' => 'Ford'],
            ['name' => 'Civic', 'brand' => 'Honda'],
            ['name' => 'Accord', 'brand' => 'Honda'],
            ['name' => 'CR-V', 'brand' => 'Honda'],
            ['name' => 'Silverado', 'brand' => 'Chevrolet'],
            ['name' => 'Malibu', 'brand' => 'Chevrolet'],
            ['name' => 'Equinox', 'brand' => 'Chevrolet'],
            ['name' => 'X5', 'brand' => 'BMW'],
            ['name' => 'X3', 'brand' => 'BMW'],
            ['name' => '3 Series', 'brand' => 'BMW'],
            ['name' => 'E-Class', 'brand' => 'Mercedes-Benz'],
            ['name' => 'C-Class', 'brand' => 'Mercedes-Benz'],
            ['name' => 'GLE', 'brand' => 'Mercedes-Benz'],
            ['name' => 'A4', 'brand' => 'Audi'],
            ['name' => 'Q5', 'brand' => 'Audi'],
            ['name' => 'A6', 'brand' => 'Audi'],
            ['name' => 'Golf', 'brand' => 'Volkswagen'],
            ['name' => 'Passat', 'brand' => 'Volkswagen'],
            ['name' => 'Tiguan', 'brand' => 'Volkswagen'],
            ['name' => 'Altima', 'brand' => 'Nissan'],
            ['name' => 'Sentra', 'brand' => 'Nissan'],
            ['name' => 'Rogue', 'brand' => 'Nissan'],
            ['name' => 'Elantra', 'brand' => 'Hyundai'],
            ['name' => 'Sonata', 'brand' => 'Hyundai'],
            ['name' => 'Tucson', 'brand' => 'Hyundai'],
            ['name' => 'Sportage', 'brand' => 'Kia'],
            ['name' => 'Sorento', 'brand' => 'Kia'],
            ['name' => 'Optima', 'brand' => 'Kia'],
            ['name' => 'Forester', 'brand' => 'Subaru'],
            ['name' => 'Outback', 'brand' => 'Subaru'],
            ['name' => 'Impreza', 'brand' => 'Subaru'],
            ['name' => 'CX-5', 'brand' => 'Mazda'],
            ['name' => 'Mazda3', 'brand' => 'Mazda'],
            ['name' => 'MX-5 Miata', 'brand' => 'Mazda'],
            ['name' => 'F-PACE', 'brand' => 'Jaguar'],
            ['name' => 'XF', 'brand' => 'Jaguar'],
            ['name' => 'XE', 'brand' => 'Jaguar'],
            ['name' => 'Range Rover', 'brand' => 'Land Rover'],
            ['name' => 'Defender', 'brand' => 'Land Rover'],
            ['name' => 'Discovery', 'brand' => 'Land Rover'],
            ['name' => '911', 'brand' => 'Porsche'],
            ['name' => 'Cayenne', 'brand' => 'Porsche'],
            ['name' => 'Macan', 'brand' => 'Porsche'],
            ['name' => 'Model S', 'brand' => 'Tesla'],
            ['name' => 'Model 3', 'brand' => 'Tesla'],
            ['name' => 'Model X', 'brand' => 'Tesla'],
        ];

        foreach ($carModels as $model) {
            DB::table('cars')->insert([
                'name' => $model['brand'] . ' ' . $model['name'], // Ví dụ: Toyota Corolla
                'user_id' => 0, // Admin tạo
            ]);
        }
    }
}
