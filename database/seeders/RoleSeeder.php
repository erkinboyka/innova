<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(['email' => 'admin@innova.tj'], [
            'name' => 'Admin Innova',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        // Scientist
        User::updateOrCreate(['email' => 'scientist@innova.tj'], [
            'name' => 'Бобоев Фарход',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SCIENTIST,
            'position' => 'Доктор химических наук',
        ]);

        // Investor
        User::updateOrCreate(['email' => 'investor@innova.tj'], [
            'name' => 'Somon Capital',
            'password' => Hash::make('password'),
            'role' => User::ROLE_INVESTOR,
        ]);
    }
}
