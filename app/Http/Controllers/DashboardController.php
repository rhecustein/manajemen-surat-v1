<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data statistik total
        $totalSuratBelumDikirim = SuratKeluar::where('status_kirim', 'draft')->count();
        $totalSuratTerkirim = SuratKeluar::where('status_kirim', 'dikirim')->count();
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalKontak = Kontak::count();

        // Siapkan array bulan
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Inisialisasi array surat masuk dan keluar per bulan
        $dataSuratMasuk = [];
        $dataSuratKeluar = [];

        foreach (range(1, 12) as $month) {
            $dataSuratMasuk[] = SuratMasuk::whereMonth('created_at', $month)
                                ->whereYear('created_at', date('Y'))
                                ->count();
            $dataSuratKeluar[] = SuratKeluar::whereMonth('created_at', $month)
                                ->whereYear('created_at', date('Y'))
                                ->count();
        }

        $statusSuratData = [
            SuratMasuk::where('status', 'baru')->count(),
            SuratMasuk::where('status', 'diproses')->count(),
            SuratMasuk::where('status', 'selesai')->count(),
        ];

        return view('dashboard.index', [
            'totalSuratMasuk' => $totalSuratMasuk,
            'totalSuratKeluar' => $totalSuratKeluar,
            'totalSuratBelumDikirim' => $totalSuratBelumDikirim,
            'totalSuratTerkirim' => $totalSuratTerkirim,
            'totalKontak' => $totalKontak,
            'bulan' => $bulan,
            'dataSuratMasuk' => $dataSuratMasuk,
            'dataSuratKeluar' => $dataSuratKeluar,
            'statusSuratData' => $statusSuratData,
        ]);
    }
}
