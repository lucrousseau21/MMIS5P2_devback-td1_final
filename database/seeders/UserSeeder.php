<?php

namespace Database\Seeders;

use App\Models\User;
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

        // Créer quelques clients
        User::factory(10)->create([
            'role' => UserRole::CUSTOMER,
        ]);
    }
}
