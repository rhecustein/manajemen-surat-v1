<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Disposisi;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disposisi>
 */
class DisposisiFactory extends Factory
{
    protected $model = \App\Models\Disposisi::class;

    public function definition(): array
    {
        return [
            'surat_masuk_id' => \App\Models\SuratMasuk::factory(),
            'dari_user_id' => User::factory()->pimpinan(),
            'kepada_user_id' => User::factory()->petugas(),
            'catatan' => fake()->sentence(8),
            'instruksi' => fake()->sentence(10),
            'due_date' => fake()->optional()->dateTimeBetween('now', '+14 days'),
            'priority' => fake()->randomElement(['rendah', 'sedang', 'tinggi', 'urgent']),
            'status' => fake()->randomElement(['diajukan', 'diproses', 'diterima', 'selesai']),
            'is_forwarded' => fake()->boolean(20), // 20% chance
            'user_id' => User::factory(),
        ];
    }

    /**
     * Create pending disposisi
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diajukan',
            'tanggal_baca' => null,
            'tanggal_selesai' => null,
        ]);
    }

    /**
     * Create completed disposisi
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
            'tanggal_baca' => fake()->dateTimeBetween('-7 days', '-1 day'),
            'tanggal_selesai' => fake()->dateTimeBetween('-3 days', 'now'),
            'feedback' => fake()->sentence(6),
        ]);
    }

    /**
     * Create urgent disposisi
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'urgent',
            'due_date' => fake()->dateTimeBetween('now', '+3 days'),
        ]);
    }
}