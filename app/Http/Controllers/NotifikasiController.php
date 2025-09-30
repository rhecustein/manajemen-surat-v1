<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\NotificationSetting;

class NotifikasiController extends Controller
{
    /**
     * Tampilkan daftar pengaturan notifikasi.
     * (Di sini hanya ditampilkan satu setting, karena sistem hanya menyimpan satu konfigurasi.)
     */
    public function index()
    {
        $setting = NotificationSetting::firstOrCreate([], [
            'email' => true,
            'web_push' => false,
            'triggers' => ['surat_masuk', 'disposisi'],
            'email_default' => '',
            'webhook_url' => '',
            'frequency' => 'realtime'
        ]);
    
        return view('notifikasi.index', compact('setting'));
    }

    /**
     * Tampilkan halaman pengaturan notifikasi (form edit).
     */
    public function edit()
    {
        $setting = NotificationSetting::firstOrCreate([], [
            'email' => true,
            'web_push' => false,
            'triggers' => ['surat_masuk', 'disposisi'],
            'email_default' => '',
            'webhook_url' => '',
            'frequency' => 'realtime'
        ]);

        return view('notifikasi.edit', compact('setting'));
    }

    /**
     * Update pengaturan notifikasi ke database.
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'nullable|boolean',
            'web_push' => 'nullable|boolean',
            'triggers' => 'nullable|array',
            'triggers.*' => 'string|in:surat_masuk,disposisi,status_berubah,user_baru',
            'email_default' => 'nullable|email',
            'webhook_url' => 'nullable|url',
            'frequency' => 'required|in:realtime,daily,weekly',
        ])->validate();

        $setting = NotificationSetting::first();

        if ($setting) {
            $setting->update([
                'email' => $request->has('email'),
                'web_push' => $request->has('web_push'),
                'triggers' => $request->input('triggers', []),
                'email_default' => $request->input('email_default'),
                'webhook_url' => $request->input('webhook_url'),
                'frequency' => $request->input('frequency'),
            ]);
        }

        return redirect()->route('notifikasi.edit')->with('success', 'Pengaturan notifikasi berhasil diperbarui.');
    }
}
