<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;


class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan surat.
     */
    public function index(Request $request)
    {
        $jenis = $request->input('jenis');
        $status = $request->input('status');
        $search = $request->input('search');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $suratMasuk = SuratMasuk::query();
        $suratKeluar = SuratKeluar::query();

        // Filter tanggal
        if ($tanggalAwal && $tanggalAkhir) {
            $suratMasuk->whereBetween('tanggal_surat', [$tanggalAwal, $tanggalAkhir]);
            $suratKeluar->whereBetween('tanggal_surat', [$tanggalAwal, $tanggalAkhir]);
        }

        // Filter status
        if ($status) {
            $suratMasuk->where('status', $status);
            $suratKeluar->where('status', $status);
        }

        // Filter search (nomor surat atau perihal)
        if ($search) {
            $suratMasuk->where(function($query) use ($search) {
                $query->where('nomor_surat', 'like', '%' . $search . '%')
                      ->orWhere('perihal', 'like', '%' . $search . '%');
            });

            $suratKeluar->where(function($query) use ($search) {
                $query->where('nomor_surat', 'like', '%' . $search . '%')
                      ->orWhere('perihal', 'like', '%' . $search . '%');
            });
        }

        $data = collect([]);

        // Data surat masuk
        if ($jenis == 'masuk' || !$jenis) {
            $dataMasuk = $suratMasuk->latest()->get()->map(function ($item) {
                $item->jenis_surat = 'Surat Masuk';
                $item->pengirim_penerima = $item->pengirim;
                return $item;
            });
            $data = $data->merge($dataMasuk);
        }

        // Data surat keluar
        if ($jenis == 'keluar' || !$jenis) {
            $dataKeluar = $suratKeluar->latest()->get()->map(function ($item) {
                $item->jenis_surat = 'Surat Keluar';
                $item->pengirim_penerima = $item->penerima;
                return $item;
            });
            $data = $data->merge($dataKeluar);
        }

        // Sort semua data by tanggal surat terbaru
        $sortedData = $data->sortByDesc('tanggal_surat')->values();

        // Manual Pagination
        $perPage = 25;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $sortedData->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $laporans = new LengthAwarePaginator(
            $currentItems,
            $sortedData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();

        return view('laporan.index', compact('laporans', 'totalSuratMasuk', 'totalSuratKeluar'));
    }

    /**
     * Export laporan ke PDF.
     */
    public function export(Request $request)
    {
        $jenis = $request->input('jenis');
        $status = $request->input('status');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $format = $request->input('format'); // excel atau pdf

        $suratMasuk = SuratMasuk::query();
        $suratKeluar = SuratKeluar::query();

        // Filter tanggal
        if ($tanggalAwal && $tanggalAkhir) {
            $suratMasuk->whereBetween('tanggal_surat', [$tanggalAwal, $tanggalAkhir]);
            $suratKeluar->whereBetween('tanggal_surat', [$tanggalAwal, $tanggalAkhir]);
        }

        // Filter status
        if ($status) {
            $suratMasuk->where('status', $status);
            $suratKeluar->where('status', $status);
        }

        $data = collect([]);

        if ($jenis == 'masuk' || !$jenis) {
            $dataMasuk = $suratMasuk->latest()->get()->map(function ($item) {
                $item->jenis_surat = 'Surat Masuk';
                $item->pengirim_penerima = $item->pengirim;
                return $item;
            });
            $data = $data->merge($dataMasuk);
        }

        if ($jenis == 'keluar' || !$jenis) {
            $dataKeluar = $suratKeluar->latest()->get()->map(function ($item) {
                $item->jenis_surat = 'Surat Keluar';
                $item->pengirim_penerima = $item->penerima;
                return $item;
            });
            $data = $data->merge($dataKeluar);
        }

        $laporans = $data->sortByDesc('tanggal_surat')->values();

        if ($format == 'excel') {
            return Excel::download(new LaporanExport($laporans), 'laporan_surat.xlsx');
        } elseif ($format == 'pdf') {
            $pdf = Pdf::loadView('laporan.export-pdf', compact('laporans'));
            return $pdf->download('laporan_surat.pdf');
        } else {
            abort(404, 'Format tidak dikenali.');
        }
    }
}
