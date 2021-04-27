<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerUser = User::factory()->create([
            'email'    => 'customer@customer.com',
            'password' => bcrypt('123456Aa@')
        ]);

        $adminUser = User::factory()->create([
            'email'    => 'admin@admin.com',
            'password' => bcrypt('123456Aa@')
        ]);

        $customerUser->assignRole(Role::CUSTOMER);
        $adminUser->assignRole(Role::ADMIN);
    }
}
