<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use App\Models\Klasifikasi;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalSuratKeluar = SuratKeluar::count();
        $totalSuratBelumDikirim = SuratKeluar::where('status_kirim', 'draft')->count();
        $totalSuratTerkirim = SuratKeluar::where('status_kirim', 'terkirim')->count();
        $suratKeluar = SuratKeluar::latest()->paginate(10);

        return view('surat.keluar.index', compact(
            'totalSuratKeluar',
            'totalSuratBelumDikirim',
            'totalSuratTerkirim',
            'suratKeluar'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $klasifikasis = Klasifikasi::all();
        return view('surat.keluar.create', compact('klasifikasis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'     => 'required|string|max:255',
            'tujuan'          => 'required|string|max:255',
            'perihal'         => 'required|string|max:255',
            'tanggal_surat'   => 'required|date',
            'klasifikasi_id'  => 'required|exists:klasifikasis,id',
            'file'            => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'uploaded_file_path' => 'nullable|string', // jika pakai Uppy
        ]);

        $data = [
            'nomor_surat'     => $request->nomor_surat,
            'tanggal_surat'   => $request->tanggal_surat,
            'tujuan'          => $request->tujuan,
            'perihal'         => $request->perihal,
            'klasifikasi_id'  => $request->klasifikasi_id,
            'status'          => 'baru',
            'status_kirim'    => 'draft',
            'file'            => null,
        ];

        // Prioritaskan unggahan Uppy jika ada
        if ($request->filled('uploaded_file_path')) {
            $data['file'] = $request->uploaded_file_path;
        }
        // Jika tidak, gunakan file upload manual biasa
        elseif ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('surat_keluar', 'public');
        }

        SuratKeluar::create($data);

        return redirect()->route('surat.keluar.index')->with('success', 'Surat Keluar berhasil ditambahkan.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        return view('surat.keluar.edit', compact('suratKeluar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required',
            'perihal' => 'required',
            'uploaded_file_path' => 'nullable|string',
        ]);

        $surat = SuratKeluar::findOrFail($id);
        $surat->update([
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'tujuan' => $validated['tujuan'],
            'perihal' => $validated['perihal'],
            'file' => $validated['uploaded_file_path'] ?? $surat->file,
        ]);

        return redirect()->route('surat.keluar.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        if ($suratKeluar->file && Storage::disk('public')->exists($suratKeluar->file)) {
            Storage::disk('public')->delete($suratKeluar->file);
        }

        $suratKeluar->delete();

        return redirect()->route('surat.keluar.index')->with('deleted', 'Surat Keluar berhasil dihapus.');
    }

    /**
     * Arsipkan surat keluar.
     */
    public function arsip($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        $suratKeluar->status_kirim = 'arsip';
        $suratKeluar->save();

        return redirect()->route('surat.keluar.index')->with('arsip', 'Surat Keluar berhasil diarsipkan.');
    }

}
