<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Menampilkan semua file yang sudah diupload.
     */
    public function index()
    {
        $files = File::all();

        foreach ($files as $file) {
            if (Storage::disk('public')->exists($file->path)) {
                $file->ukuran = Storage::disk('public')->size($file->path);
            } else {
                $file->ukuran = null; // Atau kasih keterangan file tidak ditemukan
            }
        }

        return view('file.index', compact('files'));
    }

    /**
     * Form upload file baru.
     */
    public function create()
    {
        return view('file.create');
    }

    /**
     * Proses upload file baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/files', $filename, 'public');

            // Simpan ke database
            File::create([
                'nama_file' => $request->nama_file,
                'ukuran' => $file->getSize(),
                'path' => $path,
                'tipe' => $file->getClientOriginalExtension(),
                'fileable' => null, // default
            ]);
        }

        return redirect()->route('file.index')->with('success', 'File berhasil diupload.');
    }

    /**
     * Tampilkan form edit file.
     */
    public function edit(File $file)
    {
        return view('file.edit', compact('file'));
    }

    /**
     * Update file (opsional, jika mau reupload file baru).
     */
    public function update(Request $request, File $file)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        // Hapus file lama dari storage
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        // Upload file baru
        $newFile = $request->file('file');
        $filename = Str::random(10) . '_' . time() . '.' . $newFile->getClientOriginalExtension();
        $path = $newFile->storeAs('uploads/files', $filename, 'public');

        // Update database
        $file->update([
            'nama_file' => $newFile->getClientOriginalName(),
            'path' => $path,
            'tipe' => $newFile->getClientOriginalExtension(),
        ]);

        return redirect()->route('file.index')->with('success', 'File berhasil diperbarui.');
    }

    /**
     * Hapus file dari storage dan database.
     */
    public function destroy(File $file)
    {
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        return redirect()->route('file.index')->with('deleted', 'File berhasil dihapus.');
    }
}
