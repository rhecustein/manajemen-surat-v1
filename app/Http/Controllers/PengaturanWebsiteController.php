<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use App\Models\Setting;

use Illuminate\Support\Str;

class PengaturanWebsiteController extends Controller
{
    /**
     * Tampilkan halaman pengaturan website.
     */
    public function site()
    {
        //mengambil dari table setting
        $settings = Cache::remember('settings', 60, function () {
            return setting()->all();
        });
        return view('sistem.site', compact('settings'));
    }

    /**
     * Simpan perubahan pengaturan website.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama_website' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,ico|max:1024',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|numeric',
            'smtp_security' => 'nullable|string|max:10',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'maintenance_mode' => 'nullable|boolean',
        ]);

        // Update teks
        setting(['nama_website' => $request->nama_website]);
        setting(['slogan' => $request->slogan]);
        setting(['deskripsi' => $request->deskripsi]);
        setting(['smtp_host' => $request->smtp_host]);
        setting(['smtp_port' => $request->smtp_port]);
        setting(['smtp_security' => $request->smtp_security]);
        setting(['smtp_username' => $request->smtp_username]);
        setting(['smtp_password' => $request->smtp_password]);

        // Upload logo
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('uploads/logo', 'public');
            setting(['logo' => $logo]);
        }

        // Upload favicon
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon')->store('uploads/favicon', 'public');
            setting(['favicon' => $favicon]);
        }

        // Maintenance Mode
        if ($request->maintenance_mode) {
            if (!app()->isDownForMaintenance()) {
                Artisan::call('down');
            }
        } else {
            if (app()->isDownForMaintenance()) {
                Artisan::call('up');
            }
        }

        // Clear cache setting
        Cache::forget('settings');

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
