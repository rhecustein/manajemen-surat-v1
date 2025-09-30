<?php

namespace Database\Factories;

use App\Models\Klasifikasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class KlasifikasiFactory extends Factory
{
    protected $model = \App\Models\Klasifikasi::class;

    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->numerify('###'),
            'nama_klasifikasi' => fake()->sentence(3),
        ];
    }
}