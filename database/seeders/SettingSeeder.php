<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'nama_web' => 'Sistem Manajemen Surat',
            'meta_description' => 'Sistem Manajemen Surat Elektronik PT Rifia Sen Tosa',
            'meta_keywords' => 'surat, manajemen, elektronik, digital, arsip',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_encryption' => 'tls',
            'smtp_from_name' => 'PT Rifia Sen Tosa',
            'smtp_from_address' => 'noreply@rifia.com',
            'maintenance_mode' => false,
        ];

        foreach ($settings as $key => $value) {
            \App\Models\Setting::create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}