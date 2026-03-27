<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stadium;

class StadiumSeeder extends Seeder
{
    public function run(): void
    {
        $stadiums = [
            ['name' => 'Mwatate Stadium', 'capacity' => 5000],
            ['name' => 'Wundanyi Sports Ground', 'capacity' => 3000],
            ['name' => 'Voi Stadium', 'capacity' => 8000],
            ['name' => 'Taveta Arena', 'capacity' => 2000],
            ['name' => 'Mwatate Training Ground', 'capacity' => 1000],
        ];

        foreach ($stadiums as $stadium) {
            Stadium::create($stadium);
        }
    }
}
