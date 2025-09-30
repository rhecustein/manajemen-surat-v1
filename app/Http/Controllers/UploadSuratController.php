<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadSuratController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads/surat_masuk', 'public');
    
            return response()->json([
                'success' => true,
                'file_path' => $path, // Kirim path ke frontend
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'No file uploaded.'
        ], 400);
    }
}