<?php

namespace Database\Factories;
use App\Models\Notification;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = \App\Models\Notification::class;

    public function definition(): array
    {
        $types = ['surat_masuk', 'surat_keluar', 'disposisi', 'approval', 'reminder'];
        $type = fake()->randomElement($types);

        $titles = [
            'surat_masuk' => 'Surat Masuk Baru',
            'surat_keluar' => 'Surat Keluar Terkirim',
            'disposisi' => 'Disposisi Baru',
            'approval' => 'Persetujuan Diperlukan',
            'reminder' => 'Pengingat Deadline',
        ];

        $messages = [
            'surat_masuk' => 'Terdapat surat masuk baru yang memerlukan perhatian',
            'surat_keluar' => 'Surat keluar telah berhasil dikirim',
            'disposisi' => 'Anda mendapat disposisi baru',
            'approval' => 'Surat memerlukan persetujuan Anda',
            'reminder' => 'Deadline disposisi akan segera berakhir',
        ];

        return [
            'user_id' => User::factory(),
            'type' => $type,
            'title' => $titles[$type],
            'message' => $messages[$type],
            'data' => [
                'surat_id' => fake()->numberBetween(1, 100),
                'nomor_surat' => 'SM/' . fake()->numerify('###') . '/' . date('Y'),
            ],
            'priority' => fake()->randomElement(['low', 'normal', 'high', 'urgent']),
            'read_at' => fake()->optional()->dateTimeBetween('-7 days', 'now'),
            'expires_at' => fake()->optional()->dateTimeBetween('now', '+30 days'),
        ];
    }

    /**
     * Create unread notification
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => null,
        ]);
    }

    /**
     * Create urgent notification
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'urgent',
        ]);
    }
}