<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        User::updateOrCreate(
            ['email' => 'admin@lectureplatform.com'],
            [
                'role_id' => $adminRole->id,
                'name' => 'System Administrator',
                'password' => Hash::make('Password123!'),
                'email_verified_at' => now(),
                'status' => 'active',
            ]
        );
    }
}
