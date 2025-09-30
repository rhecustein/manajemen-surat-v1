<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KlasifikasiSeeder::class,
            SystemConfigurationSeeder::class,
            EmailTemplateSeeder::class,
            SettingSeeder::class,
        ]);

        // Create notification settings for all users
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            \App\Models\NotificationSetting::createForUser($user);
        }

        // Create sample contacts
        \App\Models\Kontak::create([
            'nama' => 'Dinas Pendidikan Kota Depok',
            'email' => 'disdik@depok.go.id',
            'telepon' => '021-7720002',
            'alamat' => 'Jl. Margonda Raya No. 54, Depok',
            'instansi' => 'Dinas Pendidikan',
            'tipe' => 'client',
        ]);

        \App\Models\Kontak::create([
            'nama' => 'PT Mitra Teknologi',
            'email' => 'info@mitratek.com',
            'telepon' => '021-5551234',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta',
            'instansi' => 'PT Mitra Teknologi',
            'tipe' => 'rekanan',
        ]);

        $this->command->info('Database seeded successfully!');
    }
}
