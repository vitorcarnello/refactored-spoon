<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::factory()->create([
            'name'        => 'bronze',
            'description' => 'Amazing description for bronze plan',
            'price'       => 29.9,
        ]);

        Plan::factory()->create([
            'name'        => 'silver',
            'description' => 'Amazing description for silver plan',
            'price'       => 59.9,
        ]);

        Plan::factory()->create([
            'name'        => 'gold',
            'description' => 'Amazing description for gold plan',
            'price'       => 69.9,
        ]);
    }
}
