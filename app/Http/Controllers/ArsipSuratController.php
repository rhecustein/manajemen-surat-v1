<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class ArsipSuratController extends Controller
{
    /**
     * Menampilkan daftar surat masuk dan keluar yang diarsipkan.
     */
    public function index(Request $request)
    {
        $jenis = $request->jenis; // 'masuk', 'keluar' atau null
        $search = $request->search;

        $arsips = collect();

        if (!$jenis || $jenis === 'masuk') {
            $masuk = SuratMasuk::query()
                ->where('status', 'arsip')
                ->when($search, fn($q) => $q->where('perihal', 'like', "%$search%")
                                            ->orWhere('pengirim', 'like', "%$search%"))
                ->get()
                ->map(function ($surat) {
                    return [
                        'id' => $surat->id,
                        'jenis' => 'Masuk',
                        'jenis_slug' => 'masuk',
                        'nomor_surat' => $surat->nomor_surat,
                        'asal' => $surat->pengirim,
                        'perihal' => $surat->perihal,
                        'tanggal' => $surat->tanggal_surat,
                        'link' => route('surat.masuk.show', $surat->id),
                    ];
                });
            $arsips = $arsips->merge($masuk);
        }

        if (!$jenis || $jenis === 'keluar') {
            $keluar = SuratKeluar::query()
                ->where('status_kirim', 'arsip')
                ->when($search, fn($q) => $q->where('perihal', 'like', "%$search%")
                                            ->orWhere('tujuan', 'like', "%$search%"))
                ->get()
                ->map(function ($surat) {
                    return [
                        'id' => $surat->id,
                        'jenis' => 'Keluar',
                        'jenis_slug' => 'keluar',
                        'nomor_surat' => $surat->nomor_surat,
                        'asal' => $surat->tujuan,
                        'perihal' => $surat->perihal,
                        'tanggal' => $surat->tanggal_surat,
                        'link' => route('surat.keluar.show', $surat->id),
                    ];
                });
            $arsips = $arsips->merge($keluar);
        }

        $arsips = $arsips->sortByDesc('tanggal')->values();

        return view('surat.arsip.index', compact('arsips'));
    }

    /**
     * Kembalikan surat dari arsip ke status aktif/draft.
     */
    public function restore($jenis, $id)
    {
        if ($jenis === 'masuk') {
            $surat = SuratMasuk::findOrFail($id);
            $surat->status = 'aktif';
            $surat->save();
        } elseif ($jenis === 'keluar') {
            $surat = SuratKeluar::findOrFail($id);
            $surat->status_kirim = 'draft';
            $surat->save();
        } else {
            abort(404);
        }

        return redirect()->route('surat.arsip.index')->with('success', 'Surat berhasil dikembalikan.');
    }
}
