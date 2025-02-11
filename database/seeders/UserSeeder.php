<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => UserRole::ADMIN,
        ]);

        // Créer des clients avec leurs profils
        User::factory(10)
            ->has(Customer::factory())
            ->create([
                'role' => UserRole::CUSTOMER,
            ]);
    }
}
