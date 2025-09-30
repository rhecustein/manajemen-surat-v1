<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            // App Settings
            ['group_name' => 'app', 'key' => 'name', 'value' => 'Sistem Manajemen Surat PT Rifia Sen Tosa', 'data_type' => 'string', 'is_public' => true],
            ['group_name' => 'app', 'key' => 'timezone', 'value' => 'Asia/Jakarta', 'data_type' => 'string', 'is_public' => true],
            ['group_name' => 'app', 'key' => 'locale', 'value' => 'id', 'data_type' => 'string', 'is_public' => true],
            ['group_name' => 'app', 'key' => 'maintenance_mode', 'value' => 'false', 'data_type' => 'boolean', 'is_public' => false],

            // Email Settings
            ['group_name' => 'email', 'key' => 'from_name', 'value' => 'PT Rifia Sen Tosa', 'data_type' => 'string', 'is_public' => false],
            ['group_name' => 'email', 'key' => 'from_address', 'value' => 'noreply@rifia.com', 'data_type' => 'string', 'is_public' => false],
            ['group_name' => 'email', 'key' => 'smtp_host', 'value' => 'smtp.gmail.com', 'data_type' => 'string', 'is_public' => false],
            ['group_name' => 'email', 'key' => 'smtp_port', 'value' => '587', 'data_type' => 'integer', 'is_public' => false],
            ['group_name' => 'email', 'key' => 'smtp_encryption', 'value' => 'tls', 'data_type' => 'string', 'is_public' => false],

            // Notification Settings
            ['group_name' => 'notification', 'key' => 'email_enabled', 'value' => 'true', 'data_type' => 'boolean', 'is_public' => false],
            ['group_name' => 'notification', 'key' => 'sms_enabled', 'value' => 'false', 'data_type' => 'boolean', 'is_public' => false],
            ['group_name' => 'notification', 'key' => 'push_enabled', 'value' => 'true', 'data_type' => 'boolean', 'is_public' => false],

            // File Upload Settings
            ['group_name' => 'upload', 'key' => 'max_file_size', 'value' => '10240', 'data_type' => 'integer', 'is_public' => true], // 10MB in KB
            ['group_name' => 'upload', 'key' => 'allowed_extensions', 'value' => '["pdf","doc","docx","xls","xlsx","jpg","jpeg","png"]', 'data_type' => 'json', 'is_public' => true],

            // Security Settings
            ['group_name' => 'security', 'key' => 'session_timeout', 'value' => '120', 'data_type' => 'integer', 'is_public' => false], // minutes
            ['group_name' => 'security', 'key' => 'max_login_attempts', 'value' => '5', 'data_type' => 'integer', 'is_public' => false],
            ['group_name' => 'security', 'key' => 'password_min_length', 'value' => '8', 'data_type' => 'integer', 'is_public' => true],

            // Surat Settings
            ['group_name' => 'surat', 'key' => 'auto_number_format', 'value' => '{no}/SMS/{year}', 'data_type' => 'string', 'is_public' => false],
            ['group_name' => 'surat', 'key' => 'disposisi_reminder_days', 'value' => '3', 'data_type' => 'integer', 'is_public' => false],
            ['group_name' => 'surat', 'key' => 'archive_after_days', 'value' => '365', 'data_type' => 'integer', 'is_public' => false],
        ];

        foreach ($configs as $config) {
            \App\Models\SystemConfiguration::create($config);
        }
    }
}