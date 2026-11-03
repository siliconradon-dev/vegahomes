<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Creates (or updates) the admin login from .env:
     *   ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD
     */
    public function run(): void
    {
        $email    = env('ADMIN_EMAIL', 'admin@vegahomes.lk');
        $password = env('ADMIN_PASSWORD', 'ChangeMe@123');

        $user = User::firstOrNew(['email' => $email]);
        $user->forceFill([
            'name'     => env('ADMIN_NAME', 'Vega Admin'),
            'password' => Hash::make($password),
            'is_admin' => true,
        ])->save();
    }
}
