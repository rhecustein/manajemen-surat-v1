<?php

namespace App\Http\Controllers;

use App\Models\Klasifikasi;
use Illuminate\Http\Request;

class KlasifikasiSuratController extends Controller
{
    /**
     * Menampilkan daftar semua klasifikasi.
     */
    public function index()
    {
        $klasifikasis = Klasifikasi::latest()->paginate(10);
        return view('klasifikasi.index', compact('klasifikasis'));
    }

    /**
     * Menampilkan form untuk membuat klasifikasi baru.
     */
    public function create()
    {
        return view('klasifikasi.create');
    }

    /**
     * Menyimpan klasifikasi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:klasifikasis,kode',
            'nama_klasifikasi' => 'required|string|max:255',
        ]);

        Klasifikasi::create($request->only('kode', 'nama_klasifikasi'));

        return redirect()->route('klasifikasi.index')
            ->with('success', 'Klasifikasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit klasifikasi.
     */
    public function edit(Klasifikasi $klasifikasi)
    {
        return view('klasifikasi.edit', compact('klasifikasi'));
    }

    /**
     * Update data klasifikasi.
     */
    public function update(Request $request, Klasifikasi $klasifikasi)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:klasifikasis,kode,' . $klasifikasi->id,
            'nama_klasifikasi' => 'required|string|max:255',
        ]);

        $klasifikasi->update($request->only('kode', 'nama_klasifikasi'));

        return redirect()->route('klasifikasi.index')
            ->with('success', 'Klasifikasi berhasil diperbarui.');
    }

    /**
     * Hapus klasifikasi.
     */
    public function destroy(Klasifikasi $klasifikasi)
    {
        $klasifikasi->delete();

        return redirect()->route('klasifikasi.index')
            ->with('deleted', 'Klasifikasi berhasil dihapus.');
    }
}
