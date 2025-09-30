<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationSetting;

class NotificationSettingSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        NotificationSetting::firstOrCreate(
            ['id' => 1], // Key untuk memastikan hanya satu record
            [
                'email' => true,
                'web_push' => false,
                'triggers' => json_encode(['surat_masuk', 'disposisi']), // pastikan JSON
                'email_default' => 'admin@kecamatan.go.id',
                'webhook_url' => 'https://example.com/webhook',
                'frequency' => 'realtime',
            ]
        );
    }
}
