<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Klasifikasi;
use Illuminate\Database\Seeder;

class KlasifikasiSeeder extends Seeder
{
    public function run(): void
    {
        $klasifikasis = [
            ['kode' => '000', 'nama_klasifikasi' => 'Umum'],
            ['kode' => '100', 'nama_klasifikasi' => 'Pemerintahan'],
            ['kode' => '110', 'nama_klasifikasi' => 'Ideologi Negara'],
            ['kode' => '120', 'nama_klasifikasi' => 'Politik'],
            ['kode' => '130', 'nama_klasifikasi' => 'Keamanan/Ketertiban'],
            ['kode' => '140', 'nama_klasifikasi' => 'Kesejahteraan Rakyat'],
            ['kode' => '150', 'nama_klasifikasi' => 'Perekonomian'],
            ['kode' => '160', 'nama_klasifikasi' => 'Pekerjaan Umum'],
            ['kode' => '170', 'nama_klasifikasi' => 'Pengawasan'],
            ['kode' => '180', 'nama_klasifikasi' => 'Kepegawaian'],
            ['kode' => '190', 'nama_klasifikasi' => 'Keuangan'],
            ['kode' => '200', 'nama_klasifikasi' => 'Politik Luar Negeri'],
            ['kode' => '300', 'nama_klasifikasi' => 'Keamanan/Pertahanan'],
            ['kode' => '400', 'nama_klasifikasi' => 'Kesejahteraan Rakyat'],
            ['kode' => '500', 'nama_klasifikasi' => 'Perekonomian'],
            ['kode' => '600', 'nama_klasifikasi' => 'Pekerjaan Umum/Ketenagakerjaan'],
            ['kode' => '700', 'nama_klasifikasi' => 'Pengawasan'],
            ['kode' => '800', 'nama_klasifikasi' => 'Kepegawaian'],
            ['kode' => '900', 'nama_klasifikasi' => 'Keuangan'],
        ];

        foreach ($klasifikasis as $klasifikasi) {
            \App\Models\Klasifikasi::create($klasifikasi);
        }
    }
}