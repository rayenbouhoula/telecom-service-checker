<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['name' => 'Tunis', 'code' => 'TUN'],
            ['name' => 'Ariana', 'code' => 'ARI'],
            ['name' => 'Ben Arous', 'code' => 'BEN'],
            ['name' => 'Manouba', 'code' => 'MAN'],
            ['name' => 'Nabeul', 'code' => 'NAB'],
            ['name' => 'Zaghouan', 'code' => 'ZAG'],
            ['name' => 'Bizerte', 'code' => 'BIZ'],
            ['name' => 'Béja', 'code' => 'BEJ'],
            ['name' => 'Jendouba', 'code' => 'JEN'],
            ['name' => 'Kef', 'code' => 'KEF'],
            ['name' => 'Siliana', 'code' => 'SIL'],
            ['name' => 'Sousse', 'code' => 'SOU'],
            ['name' => 'Monastir', 'code' => 'MON'],
            ['name' => 'Mahdia', 'code' => 'MAH'],
            ['name' => 'Sfax', 'code' => 'SFX'],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
