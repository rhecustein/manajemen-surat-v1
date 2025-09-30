<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\File;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            File::create([
                'nama_file' => fake()->word() . '.pdf',
                'path' => 'uploads/' . fake()->uuid() . '.pdf',
                'tipe' => 'pdf',
                'fileable_id' => SuratMasuk::inRandomOrder()->first()->id,
                'fileable_type' => SuratMasuk::class,
            ]);
        }
    }
}
