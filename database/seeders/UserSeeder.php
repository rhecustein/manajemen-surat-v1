<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@suratapp.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'department' => 'IT',
            'position' => 'System Administrator',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Pimpinan
        User::create([
            'name' => 'Abi Hasan',
            'email' => 'pimpinan@rifia.com',
            'password' => Hash::make('password123'),
            'role' => 'pimpinan',
            'department' => 'Direktur',
            'position' => 'Direktur Utama',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Petugas
        User::create([
            'name' => 'Bintang Wijaya',
            'email' => 'bintang@rifia.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
            'department' => 'Administrasi',
            'position' => 'Staff Administrasi',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Rahma',
            'email' => 'siti@rifia.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
            'department' => 'Sekretariat',
            'position' => 'Sekretaris',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
