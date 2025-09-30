<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class DisposisiSuratController extends Controller
{
    /**
     * Menampilkan daftar disposisi dengan filter.
     */
    public function index(Request $request)
    {
        $query = Disposisi::with('suratMasuk')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('suratMasuk', function ($sub) use ($request) {
                    $sub->where('perihal', 'like', '%'.$request->search.'%')
                        ->orWhere('pengirim', 'like', '%'.$request->search.'%');
                });
            });

        $disposisis = $query->latest()->paginate(10);

        return view('surat.disposisi.index', compact('disposisis'));
    }

    /**
     * Form tambah disposisi surat masuk.
     */
    public function create()
    {
        $suratMasukList = SuratMasuk::latest()->get();

        return view('surat.disposisi.create', compact('suratMasukList'));
    }

    /**
     * Simpan disposisi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'surat_masuk_id'     => 'required|exists:surat_masuks,id',
            'tanggal_disposisi'  => 'required|date',
            'kepada'             => 'required|string|max:255',
            'catatan'            => 'nullable|string',
            'status'             => 'required|in:belum,ditindaklanjuti,selesai',
        ]);

        Disposisi::create([
            'surat_masuk_id'    => $request->surat_masuk_id,
            'tanggal_disposisi' => $request->tanggal_disposisi,
            'kepada'            => $request->kepada,
            'catatan'           => $request->catatan,
            'status'            => $request->status,
        ]);

        return redirect()->route('surat.disposisi.index')->with('success', 'Disposisi berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail disposisi.
     */
    public function show($id)
    {
        $disposisi = Disposisi::with('suratMasuk')->findOrFail($id);

        return view('surat.disposisi.show', compact('disposisi'));
    }
}
