<?php

namespace Database\Factories;
use App\Models\Klasifikasi;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratKeluar>
 */
class SuratKeluarFactory extends Factory
{
    protected $model = \App\Models\SuratKeluar::class;

    public function definition(): array
    {
        return [
            'nomor_surat' => 'SK/' . fake()->numerify('###') . '/' . date('Y'),
            'nomor_agenda' => fake()->numerify('###') . '/SK/' . date('Y'),
            'tanggal_surat' => fake()->dateTimeBetween('-30 days', 'now'),
            'tanggal_kirim' => fake()->optional()->dateTimeBetween('-30 days', 'now'),
            'tujuan' => fake()->company(),
            'alamat_tujuan' => fake()->address(),
            'telepon_tujuan' => fake()->phoneNumber(),
            'email_tujuan' => fake()->companyEmail(),
            'perihal' => fake()->sentence(6),
            'isi_ringkas' => fake()->paragraph(2),
            'klasifikasi_id' => \App\Models\Klasifikasi::factory(),
            'tingkat_keamanan' => fake()->randomElement(['biasa', 'rahasia', 'sangat_rahasia']),
            'sifat_surat' => fake()->randomElement(['biasa', 'penting', 'segera', 'sangat_segera']),
            'status_kirim' => fake()->randomElement(['draft', 'terkirim', 'arsip']),
            'status' => fake()->randomElement(['baru', 'diproses', 'selesai']),
            'priority' => fake()->randomElement(['rendah', 'sedang', 'tinggi', 'urgent']),
            'delivery_method' => fake()->randomElement(['email', 'pos', 'kurir', 'fax', 'langsung']),
            'tracking_number' => fake()->optional()->bothify('TRK-####-????'),
            'keywords' => fake()->words(3, true),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Create draft surat keluar
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_kirim' => 'draft',
            'tanggal_kirim' => null,
            'approved_by' => null,
            'approved_at' => null,
        ]);
    }

    /**
     * Create approved surat keluar
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'approved_by' => User::factory()->pimpinan(),
            'approved_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }

    /**
     * Create sent surat keluar
     */
    public function sent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_kirim' => 'terkirim',
            'tanggal_kirim' => fake()->dateTimeBetween('-7 days', 'now'),
            'approved_by' => User::factory()->pimpinan(),
            'approved_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}