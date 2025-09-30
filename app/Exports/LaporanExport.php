<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $laporans;

    public function __construct($laporans)
    {
        $this->laporans = $laporans;
    }

    public function collection()
    {
        return $this->laporans->map(function ($laporan) {
            return [
                'Nomor Surat'      => $laporan->nomor_surat,
                'Jenis Surat'      => $laporan->jenis_surat,
                'Pengirim/Penerima'=> $laporan->pengirim_penerima,
                'Perihal'          => $laporan->perihal,
                'Tanggal Surat'    => \Carbon\Carbon::parse($laporan->tanggal_surat)->format('d-m-Y'),
                'Status'           => ucfirst($laporan->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor Surat',
            'Jenis Surat',
            'Pengirim/Penerima',
            'Perihal',
            'Tanggal Surat',
            'Status',
        ];
    }
}
