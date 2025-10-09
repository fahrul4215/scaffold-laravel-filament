<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user already exists
        $superadmin = User::where('email', 'superadmin@superadmin.com')->first();

        if (!$superadmin) {
            // Create superadmin user
            $superadmin = User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@superadmin.com',
                'password' => Hash::make('superadmin'),
                'email_verified_at' => now(),
            ]);

            $this->command->info('Superadmin user created successfully!');
        } else {
            $this->command->info('Superadmin user already exists.');
        }

        // Assign superadmin role (in case it wasn't assigned before)
        if (!$superadmin->hasRole('superadmin')) {
            $superadmin->assignRole('superadmin');
            $this->command->info('Superadmin role assigned.');
        }

        $this->command->info('Email: superadmin@superadmin.com');
        $this->command->info('Password: superadmin');
    }
}
