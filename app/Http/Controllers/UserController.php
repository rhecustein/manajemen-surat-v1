<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserNotification;

class UserController extends Controller
{
    /**
     * Tampilkan semua users dengan search & filter.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderBy('name')->paginate(25);

        return view('users.index', compact('users'));
    }

    /**
     * Reset password user menjadi default.
     */
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('password123'); // Default password
        $user->save();

        return redirect()->route('users.index')->with('success', 'Password berhasil direset ke default.');
    }

    /**
     * Kirim email ke user.
     */
    public function sendEmail($id)
    {
        $user = User::findOrFail($id);

        Mail::to($user->email)->send(new UserNotification($user));

        return redirect()->route('users.index')->with('success', 'Email berhasil dikirim ke user.');
    }
}
