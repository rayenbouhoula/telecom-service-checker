<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceType;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceTypes = [
            [
                'name' => 'Internet',
                'description' => 'High-speed internet connection',
                'icon' => 'bi-globe',
            ],
            [
                'name' => '4G',
                'description' => '4G mobile network',
                'icon' => 'bi-reception-4',
            ],
            [
                'name' => '5G',
                'description' => '5G mobile network',
                'icon' => 'bi-reception-4',
            ],
            [
                'name' => 'Fiber',
                'description' => 'Fiber optic connection',
                'icon' => 'bi-ethernet',
            ],
        ];

        foreach ($serviceTypes as $serviceType) {
            ServiceType::create($serviceType);
        }
    }
}
