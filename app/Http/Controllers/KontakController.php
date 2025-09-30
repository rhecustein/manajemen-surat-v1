<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    /**
     * Menampilkan daftar kontak.
     */
    public function index()
    {
        $kontaks = Kontak::latest()->paginate(10);

        return view('kontak.index', compact('kontaks'));
    }

    /**
     * Tampilkan form tambah kontak baru.
     */
    public function create()
    {
        return view('kontak.create');
    }

    /**
     * Simpan kontak baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'instansi' => 'nullable|string|max:255',
            'tipe' => 'required|in:client,rekanan,internal',
        ]);

        Kontak::create($request->all());

        return redirect()->route('kontak.index')->with('success', 'Kontak berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kontak.
     */
    public function edit(Kontak $kontak)
    {
        return view('kontak.edit', compact('kontak'));
    }

    /**
     * Update data kontak yang dipilih.
     */
    public function update(Request $request, Kontak $kontak)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'instansi' => 'nullable|string|max:255',
            'tipe' => 'required|in:client,rekanan,internal',
        ]);

        $kontak->update($request->all());

        return redirect()->route('kontak.index')->with('success', 'Kontak berhasil diperbarui.');
    }

    /**
     * Hapus kontak dari database.
     */
    public function destroy(Kontak $kontak)
    {
        $kontak->delete();

        return redirect()->route('kontak.index')->with('deleted', 'Kontak berhasil dihapus.');
    }
}
