<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi as DisposisiSurat;
use App\Models\LogAktivitas;


class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil user.
     */
    public function index()
    {
        $user = Auth::user();

        $totalSuratMasuk = SuratMasuk::where('user_id', $user->id)->count();
        $totalSuratKeluar = SuratKeluar::where('user_id', $user->id)->count();
        $totalDisposisi = DisposisiSurat::where('user_id', $user->id)->count();

        $logs = LogAktivitas::where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('profil.index', compact(
            'user', 
            'totalSuratMasuk', 
            'totalSuratKeluar', 
            'totalDisposisi', 
            'logs'
        ));
    }

    /**
     * Update data profil user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password user.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profil.index')->with('success', 'Password berhasil diperbarui.');
    }

    //profil edit
    public function edit()
    {
        $user = Auth::user();
        return view('profil.edit', compact('user'));
    }
    
}
