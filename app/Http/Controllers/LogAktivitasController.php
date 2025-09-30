<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogAktivitasController extends Controller
{
    /**
     * Menampilkan daftar log aktivitas semua user (untuk admin).
     */
    public function index()
    {
        $logs = LogAktivitas::with('user')
                    ->latest()
                    ->paginate(25);

        return view('log.index', compact('logs'));
    }

    /**
     * Menampilkan log aktivitas pribadi user yang login.
     */
    public function myLogs()
    {
        $logs = LogAktivitas::where('user_id', Auth::id())
                    ->latest()
                    ->paginate(25);

        return view('log.mylogs', compact('logs'));
    }

    /**
     * Menyimpan aktivitas baru (dipanggil manual ketika ada aktivitas).
     */
    public static function storeLog($aktivitas)
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => $aktivitas,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Hapus log (opsional, hanya admin boleh).
     */
    public function destroy($id)
    {
        $log = LogAktivitas::findOrFail($id);
        $log->delete();

        return redirect()->back()->with('deleted', 'Log aktivitas berhasil dihapus.');
    }
}
