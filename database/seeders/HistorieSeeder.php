<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Historie;
use App\Models\User;
use Illuminate\Database\Seeder;

class HistorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            Historie::create([
                'model_type' => fake()->randomElement(['App\Models\SuratMasuk', 'App\Models\SuratKeluar', 'App\Models\Disposisi']),
                'model_id' => fake()->numberBetween(1, 100),
                'aktivitas' => fake()->sentence(),
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        }
    }
}
