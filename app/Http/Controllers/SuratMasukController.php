<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Klasifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suratMasuk = SuratMasuk::latest()->paginate(10);

        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratBelumDibaca = SuratMasuk::where('status_baca', 'belum')->count();

        return view('surat.masuk.index', compact(
            'suratMasuk',
            'totalSuratMasuk',
            'totalSuratBelumDibaca'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $klasifikasis = Klasifikasi::all();
        return view('surat.masuk.create', compact('klasifikasis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'    => 'required|string|max:255',
            'tanggal_surat'  => 'required|date',
            'pengirim'       => 'required|string|max:255',
            'perihal'        => 'required|string|max:255',
            'klasifikasi_id' => 'required|exists:klasifikasis,id',
            'uploaded_file_path' => 'nullable|string', // ini yang dikirim oleh Uppy
        ]);

        $data = [
            'nomor_surat'    => $request->nomor_surat,
            'tanggal_surat'  => $request->tanggal_surat,
            'pengirim'       => $request->pengirim,
            'perihal'        => $request->perihal,
            'klasifikasi_id' => $request->klasifikasi_id,
            'status'         => 'baru',
            'status_baca'    => 'belum',
            'file'           => $request->uploaded_file_path, // LANGSUNG ambil path hasil upload
        ];

        SuratMasuk::create($data);

        return redirect()->route('surat.masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        return view('surat.masuk.edit', compact('suratMasuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png|max:2048',
        ]);

        $suratMasuk->update([
            'nomor_surat' => $request->nomor_surat,
            'pengirim' => $request->pengirim,
            'perihal' => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('file')) {
            if ($suratMasuk->file && Storage::disk('public')->exists($suratMasuk->file)) {
                Storage::disk('public')->delete($suratMasuk->file);
            }
        
            $filePath = $request->file('file')->store('surat_masuk', 'public');
            $suratMasuk->update([
                'file' => $filePath,
            ]);
        }

        return redirect()->route('surat.masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        // Hapus file jika ada
        if ($suratMasuk->file && Storage::disk('public')->exists($suratMasuk->file)) {
            Storage::disk('public')->delete($suratMasuk->file);
        }

        $suratMasuk->delete();

        return redirect()->route('surat.masuk.index')->with('deleted', 'Surat Masuk berhasil dihapus.');
    }

    public function arsip($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $surat->status_baca = 'arsip'; // atau buat field baru misal status_arsip = 'arsip'
        $surat->save();

        return redirect()->route('surat.masuk.index')->with('arsip', 'Surat berhasil diarsipkan.');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('uploads/surat_masuk', 'public');
            return response()->json([
                'path' => Storage::url($path),
                'filename' => basename($path)
            ]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
