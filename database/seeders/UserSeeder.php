<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'dylan',
            'email' => 'dylan@localhost.com',
            'role' => 'manager',
            'password' => '12345678',
            'phone' => '081234567890'
        ]);

        User::create([
            'name' => 'shatrya',
            'email' => 'shatryaa@localhost.com',
            'role' => 'receptionist',
            'password' => '12345678',
            'phone' => '081234567890'
        ]);
    }
}
