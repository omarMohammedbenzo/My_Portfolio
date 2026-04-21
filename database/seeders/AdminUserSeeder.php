<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email    = env('ADMIN_EMAIL', 'umar27.11.2001@gmail.com');
        $password = env('ADMIN_PASSWORD');

        if (! $password) {
            $this->command->error('ADMIN_PASSWORD is not set in .env — skipping admin user creation.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name'     => 'Omar Mohammed Sultan',
                'email'    => $email,
                'password' => Hash::make($password),
                'role'     => 'admin',
            ]
        );

        $this->command->info("Admin user created/updated: {$email}");
    }
}
