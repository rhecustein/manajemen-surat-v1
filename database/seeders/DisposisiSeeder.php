<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Database\Seeder;

class DisposisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            Disposisi::create([
                'surat_masuk_id' => SuratMasuk::inRandomOrder()->first()->id,
                'dari_user_id' => User::inRandomOrder()->first()->id,
                'kepada_user_id' => User::inRandomOrder()->first()->id,
                'catatan' => fake()->sentence(),
                'status' => fake()->randomElement(['diajukan', 'diproses', 'diterima']),
            ]);
        }
    }
}
