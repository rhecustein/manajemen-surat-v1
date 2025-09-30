<?php

namespace Database\Factories;
use App\Models\Klasifikasi;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SuratMasukFactory extends Factory
{
    protected $model = \App\Models\SuratMasuk::class;

    public function definition(): array
    {
        return [
            'nomor_surat' => 'SM/' . fake()->numerify('###') . '/' . date('Y'),
            'nomor_agenda' => fake()->numerify('###') . '/SM/' . date('Y'),
            'tanggal_surat' => fake()->dateTimeBetween('-30 days', 'now'),
            'tanggal_terima' => fake()->dateTimeBetween('-30 days', 'now'),
            'pengirim' => fake()->company(),
            'alamat_pengirim' => fake()->address(),
            'telepon_pengirim' => fake()->phoneNumber(),
            'email_pengirim' => fake()->companyEmail(),
            'perihal' => fake()->sentence(6),
            'isi_ringkas' => fake()->paragraph(2),
            'klasifikasi_id' => \App\Models\Klasifikasi::factory(),
            'tingkat_keamanan' => fake()->randomElement(['biasa', 'rahasia', 'sangat_rahasia']),
            'sifat_surat' => fake()->randomElement(['biasa', 'penting', 'segera', 'sangat_segera']),
            'status' => fake()->randomElement(['baru', 'diproses', 'selesai']),
            'status_baca' => fake()->randomElement(['belum', 'sudah', 'arsip']),
            'priority' => fake()->randomElement(['rendah', 'sedang', 'tinggi', 'urgent']),
            'due_date' => fake()->optional()->dateTimeBetween('now', '+30 days'),
            'keywords' => fake()->words(3, true),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Create urgent surat masuk
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'urgent',
            'sifat_surat' => 'sangat_segera',
            'due_date' => fake()->dateTimeBetween('now', '+3 days'),
        ]);
    }

    /**
     * Create confidential surat masuk
     */
    public function confidential(): static
    {
        return $this->state(fn (array $attributes) => [
            'tingkat_keamanan' => 'sangat_rahasia',
        ]);
    }

    /**
     * Create unread surat masuk
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_baca' => 'belum',
            'status' => 'baru',
        ]);
    }
}
