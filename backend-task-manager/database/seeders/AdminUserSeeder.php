<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('ADMIN_SEED_PASSWORD');

        if (!is_string($password) || strlen($password) < 12) {
            throw new RuntimeException(
                'ADMIN_SEED_PASSWORD must contain at least 12 characters.'
            );
        }

        $admin = User::firstOrNew([
            'email' => 'admin@taskmanager.local',
        ]);

        $admin->name = 'Task Manager Admin';
        $admin->password = Hash::make($password);
        $admin->role = 'ADMIN';
        $admin->email_verified_at = now();

        $admin->save();
    }
}
