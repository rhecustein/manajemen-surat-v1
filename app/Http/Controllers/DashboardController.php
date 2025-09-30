<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Kontak;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Ambil data statistik total
            $totalSuratMasuk = SuratMasuk::count();
            $totalSuratKeluar = SuratKeluar::count();
            $totalKontak = Kontak::count();
            $totalUsers = User::count();

            // Data surat masuk berdasarkan status
            $totalSuratBelumDibaca = SuratMasuk::where('status', 'baru')->count();
            $totalSuratDiproses = SuratMasuk::where('status', 'diproses')->count();
            $totalSuratSelesai = SuratMasuk::where('status', 'selesai')->count();

            // Data surat keluar berdasarkan status
            $totalSuratDraft = SuratKeluar::where('status_kirim', 'draft')->count();
            $totalSuratTerkirim = SuratKeluar::where('status_kirim', 'terkirim')->count();

            // Siapkan array bulan untuk grafik
            $bulanLabels = [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ];

            // Data grafik surat masuk dan keluar per bulan (tahun ini)
            $currentYear = date('Y');
            $dataSuratMasuk = [];
            $dataSuratKeluar = [];

            for ($month = 1; $month <= 12; $month++) {
                $dataSuratMasuk[] = SuratMasuk::whereMonth('created_at', $month)
                                    ->whereYear('created_at', $currentYear)
                                    ->count();
                
                $dataSuratKeluar[] = SuratKeluar::whereMonth('created_at', $month)
                                    ->whereYear('created_at', $currentYear)
                                    ->count();
            }

            // Data untuk donut chart status surat masuk
            $statusSuratData = [
                $totalSuratBelumDibaca,
                $totalSuratDiproses,
                $totalSuratSelesai
            ];

            // Data aktivitas terbaru (10 terakhir)
            $aktivitasTerbaru = collect();
            
            // Gabungkan surat masuk dan keluar terbaru
            $suratMasukTerbaru = SuratMasuk::select(
                'id', 'nomor_surat', 'pengirim', 'perihal', 'created_at'
            )->latest()->take(5)->get()->map(function($item) {
                return (object)[
                    'type' => 'masuk',
                    'title' => 'Surat Masuk dari ' . $item->pengirim,
                    'description' => $item->perihal,
                    'nomor' => $item->nomor_surat,
                    'time' => $item->created_at,
                    'icon' => 'fas fa-envelope text-primary',
                    'url' => route('surat.masuk.show', $item->id)
                ];
            });

            $suratKeluarTerbaru = SuratKeluar::select(
                'id', 'nomor_surat', 'tujuan', 'perihal', 'created_at'
            )->latest()->take(5)->get()->map(function($item) {
                return (object)[
                    'type' => 'keluar',
                    'title' => 'Surat Keluar ke ' . $item->tujuan,
                    'description' => $item->perihal,
                    'nomor' => $item->nomor_surat,
                    'time' => $item->created_at,
                    'icon' => 'fas fa-paper-plane text-success',
                    'url' => route('surat.keluar.show', $item->id)
                ];
            });

            $aktivitasTerbaru = $suratMasukTerbaru->concat($suratKeluarTerbaru)
                               ->sortByDesc('time')
                               ->take(8);

            // Data perbandingan bulan ini vs bulan lalu
            $currentMonth = date('n');
            $lastMonth = $currentMonth == 1 ? 12 : $currentMonth - 1;
            $yearForLastMonth = $currentMonth == 1 ? date('Y') - 1 : date('Y');

            $suratMasukBulanIni = SuratMasuk::whereMonth('created_at', $currentMonth)
                                           ->whereYear('created_at', date('Y'))
                                           ->count();
            
            $suratMasukBulanLalu = SuratMasuk::whereMonth('created_at', $lastMonth)
                                            ->whereYear('created_at', $yearForLastMonth)
                                            ->count();

            $suratKeluarBulanIni = SuratKeluar::whereMonth('created_at', $currentMonth)
                                             ->whereYear('created_at', date('Y'))
                                             ->count();
            
            $suratKeluarBulanLalu = SuratKeluar::whereMonth('created_at', $lastMonth)
                                              ->whereYear('created_at', $yearForLastMonth)
                                              ->count();

            // Hitung persentase perubahan
            $perubahanSuratMasuk = $this->hitungPersentasePerubahan($suratMasukBulanIni, $suratMasukBulanLalu);
            $perubahanSuratKeluar = $this->hitungPersentasePerubahan($suratKeluarBulanIni, $suratKeluarBulanLalu);

            // Data untuk widget trending
            $trendingData = [
                'surat_masuk' => [
                    'current' => $suratMasukBulanIni,
                    'previous' => $suratMasukBulanLalu,
                    'percentage' => $perubahanSuratMasuk['percentage'],
                    'trend' => $perubahanSuratMasuk['trend']
                ],
                'surat_keluar' => [
                    'current' => $suratKeluarBulanIni,
                    'previous' => $suratKeluarBulanLalu,
                    'percentage' => $perubahanSuratKeluar['percentage'],
                    'trend' => $perubahanSuratKeluar['trend']
                ]
            ];

            return view('dashboard.index', compact(
                'totalSuratMasuk',
                'totalSuratKeluar',
                'totalSuratBelumDibaca',
                'totalSuratDiproses',
                'totalSuratSelesai',
                'totalSuratDraft',
                'totalSuratTerkirim',
                'totalKontak',
                'totalUsers',
                'bulanLabels',
                'dataSuratMasuk',
                'dataSuratKeluar',
                'statusSuratData',
                'aktivitasTerbaru',
                'trendingData',
                'currentYear'
            ));

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Dashboard Error: ' . $e->getMessage());
            
            // Return view dengan data default jika ada error
            return view('dashboard.index', [
                'totalSuratMasuk' => 0,
                'totalSuratKeluar' => 0,
                'totalSuratBelumDibaca' => 0,
                'totalKontak' => 0,
                'bulanLabels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                'dataSuratMasuk' => array_fill(0, 12, 0),
                'dataSuratKeluar' => array_fill(0, 12, 0),
                'statusSuratData' => [0, 0, 0],
                'aktivitasTerbaru' => collect(),
                'trendingData' => [
                    'surat_masuk' => ['current' => 0, 'previous' => 0, 'percentage' => 0, 'trend' => 'same'],
                    'surat_keluar' => ['current' => 0, 'previous' => 0, 'percentage' => 0, 'trend' => 'same']
                ],
                'currentYear' => date('Y')
            ]);
        }
    }

    /**
     * Hitung persentase perubahan antara nilai sekarang dan sebelumnya
     */
    private function hitungPersentasePerubahan($current, $previous)
    {
        if ($previous == 0) {
            return [
                'percentage' => $current > 0 ? 100 : 0,
                'trend' => $current > 0 ? 'up' : 'same'
            ];
        }

        $percentage = round((($current - $previous) / $previous) * 100, 1);
        
        return [
            'percentage' => abs($percentage),
            'trend' => $percentage > 0 ? 'up' : ($percentage < 0 ? 'down' : 'same')
        ];
    }

    /**
     * API endpoint untuk data chart (jika diperlukan untuk AJAX)
     */
    public function getChartData(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        $dataSuratMasuk = [];
        $dataSuratKeluar = [];

        for ($month = 1; $month <= 12; $month++) {
            $dataSuratMasuk[] = SuratMasuk::whereMonth('created_at', $month)
                                ->whereYear('created_at', $year)
                                ->count();
            
            $dataSuratKeluar[] = SuratKeluar::whereMonth('created_at', $month)
                                ->whereYear('created_at', $year)
                                ->count();
        }

        return response()->json([
            'surat_masuk' => $dataSuratMasuk,
            'surat_keluar' => $dataSuratKeluar,
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        ]);
    }

    /**
     * Get dashboard summary untuk widget
     */
    public function getSummary()
    {
        return response()->json([
            'total_surat_masuk' => SuratMasuk::count(),
            'total_surat_keluar' => SuratKeluar::count(),
            'surat_belum_dibaca' => SuratMasuk::where('status', 'baru')->count(),
            'total_kontak' => Kontak::count(),
            'last_updated' => now()->format('d M Y H:i')
        ]);
    }
}