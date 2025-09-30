<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;

class RiwayatSuratController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $jenis = $request->jenis;
        $status = $request->status;

        // Ambil data Surat Masuk
        $masuk = SuratMasuk::query()
            ->when($search, function ($query) use ($search) {
                $query->where('perihal', 'like', "%$search%")
                      ->orWhere('pengirim', 'like', "%$search%");
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Masuk',
                    'nomor_surat' => $item->nomor_surat,
                    'asal' => $item->pengirim,
                    'perihal' => $item->perihal,
                    'tanggal' => $item->tanggal_surat,
                    'status' => $item->status ?? 'arsip',
                    'link' => route('surat.masuk.show', $item->id),
                ];
            });

        // Ambil data Surat Keluar
        $keluar = SuratKeluar::query()
            ->when($search, function ($query) use ($search) {
                $query->where('perihal', 'like', "%$search%")
                      ->orWhere('tujuan', 'like', "%$search%");
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status_kirim', $status);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Keluar',
                    'nomor_surat' => $item->nomor_surat,
                    'asal' => $item->tujuan,
                    'perihal' => $item->perihal,
                    'tanggal' => $item->tanggal_surat,
                    'status' => $item->status_kirim,
                    'link' => route('surat.keluar.show', $item->id),
                ];
            });

        // Gabungkan data sesuai filter jenis
        $riwayat = collect();

        if (!$jenis || $jenis === 'Masuk') {
            $riwayat = $riwayat->merge($masuk);
        }

        if (!$jenis || $jenis === 'Keluar') {
            $riwayat = $riwayat->merge($keluar);
        }

        // Urutkan berdasarkan tanggal terbaru
        $riwayat = $riwayat->sortByDesc('tanggal')->values();

        return view('surat.riwayat.index', compact('riwayat'));
    }
}
