<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\ServiceType;
use App\Models\ServiceAvailability;

class ServiceAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = Area::all();
        $serviceTypes = ServiceType::all();
        $statuses = ['available', 'maintenance', 'problem'];
        $statusWeights = [70, 20, 10]; // 70% available, 20% maintenance, 10% problem

        foreach ($areas as $area) {
            // Create 2-4 random service types for each area
            $numServices = rand(2, 4);
            $selectedServiceTypes = $serviceTypes->random($numServices);

            foreach ($selectedServiceTypes as $serviceType) {
                // Weighted random status selection
                $rand = rand(1, 100);
                if ($rand <= 70) {
                    $status = 'available';
                    $notes = null;
                } elseif ($rand <= 90) {
                    $status = 'maintenance';
                    $notes = 'Scheduled maintenance in progress. Service will be restored soon.';
                } else {
                    $status = 'problem';
                    $notes = 'Technical issue detected. Our team is working on it.';
                }

                ServiceAvailability::create([
                    'area_id' => $area->id,
                    'service_type_id' => $serviceType->id,
                    'status' => $status,
                    'notes' => $notes,
                    'last_updated' => now()->subHours(rand(1, 24)),
                ]);
            }
        }
    }
}
