<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Klasifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource with enhanced filtering.
     */
    public function index(Request $request)
    {
        $query = SuratMasuk::with(['klasifikasi', 'user']);

        // Filter berdasarkan pencarian (nomor surat, nomor agenda, pengirim, perihal)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_agenda', 'LIKE', "%{$search}%")
                  ->orWhere('pengirim', 'LIKE', "%{$search}%")
                  ->orWhere('perihal', 'LIKE', "%{$search}%")
                  ->orWhere('keywords', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan status baca
        if ($request->filled('status_baca')) {
            $query->where('status_baca', $request->status_baca);
        }

        // Filter berdasarkan status surat
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter berdasarkan tingkat keamanan
        if ($request->filled('tingkat_keamanan')) {
            $query->where('tingkat_keamanan', $request->tingkat_keamanan);
        }

        // Filter berdasarkan sifat surat
        if ($request->filled('sifat_surat')) {
            $query->where('sifat_surat', $request->sifat_surat);
        }

        // Filter berdasarkan klasifikasi
        if ($request->filled('klasifikasi_id')) {
            $query->where('klasifikasi_id', $request->klasifikasi_id);
        }

        // Filter berdasarkan rentang tanggal surat
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_surat', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_surat', '<=', $request->tanggal_selesai);
        }

        // Filter berdasarkan rentang tanggal terima
        if ($request->filled('tanggal_terima_mulai')) {
            $query->whereDate('tanggal_terima', '>=', $request->tanggal_terima_mulai);
        }

        if ($request->filled('tanggal_terima_selesai')) {
            $query->whereDate('tanggal_terima', '<=', $request->tanggal_terima_selesai);
        }

        // Filter berdasarkan bulan dan tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_surat', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_surat', $request->tahun);
        }

        // Filter berdasarkan keberadaan file
        if ($request->filled('has_file')) {
            if ($request->has_file == 'ada') {
                $query->whereNotNull('file');
            } elseif ($request->has_file == 'tidak_ada') {
                $query->whereNull('file');
            }
        }

        // Filter berdasarkan due date
        if ($request->filled('due_date_status')) {
            $today = Carbon::today();
            switch ($request->due_date_status) {
                case 'overdue':
                    $query->where('due_date', '<', $today)->whereNotNull('due_date');
                    break;
                case 'today':
                    $query->whereDate('due_date', $today);
                    break;
                case 'upcoming':
                    $query->where('due_date', '>', $today)->whereNotNull('due_date');
                    break;
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        $allowedSorts = ['nomor_surat', 'nomor_agenda', 'pengirim', 'perihal', 'tanggal_surat', 'tanggal_terima', 'due_date', 'priority', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->latest();
        }

        // Pagination with query parameters preserved
        $perPage = $request->get('per_page', 10);
        $suratMasuk = $query->paginate($perPage)->appends($request->query());

        // Statistics
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratBelumDibaca = SuratMasuk::where('status_baca', 'belum')->count();
        $totalSuratBulanIni = SuratMasuk::whereMonth('created_at', Carbon::now()->month)
                                       ->whereYear('created_at', Carbon::now()->year)
                                       ->count();
        $totalSuratHariIni = SuratMasuk::whereDate('created_at', Carbon::today())->count();
        $totalSuratOverdue = SuratMasuk::where('due_date', '<', Carbon::today())
                                      ->whereNotNull('due_date')
                                      ->where('status', '!=', 'selesai')
                                      ->count();
        $totalSuratUrgent = SuratMasuk::where('priority', 'urgent')->where('status', '!=', 'selesai')->count();

        // Data untuk dropdown filter
        $klasifikasis = Klasifikasi::orderBy('nama_klasifikasi')->get();
        $availableYears = SuratMasuk::selectRaw('YEAR(tanggal_surat) as year')
                                   ->distinct()
                                   ->orderBy('year', 'desc')
                                   ->pluck('year');

        return view('surat.masuk.index', compact(
            'suratMasuk',
            'totalSuratMasuk',
            'totalSuratBelumDibaca',
            'totalSuratBulanIni',
            'totalSuratHariIni',
            'totalSuratOverdue',
            'totalSuratUrgent',
            'klasifikasis',
            'availableYears'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $klasifikasis = Klasifikasi::orderBy('nama_klasifikasi')->get();
        return view('surat.masuk.create', compact('klasifikasis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'        => 'required|string|max:255|unique:surat_masuks,nomor_surat',
            'nomor_agenda'       => 'nullable|string|max:255',
            'tanggal_surat'      => 'required|date',
            'tanggal_terima'     => 'required|date',
            'pengirim'           => 'required|string|max:255',
            'alamat_pengirim'    => 'nullable|string',
            'telepon_pengirim'   => 'nullable|string|max:20',
            'email_pengirim'     => 'nullable|email|max:255',
            'perihal'            => 'required|string|max:255',
            'isi_ringkas'        => 'nullable|string',
            'klasifikasi_id'     => 'required|exists:klasifikasis,id',
            'tingkat_keamanan'   => 'required|in:biasa,rahasia,sangat_rahasia',
            'sifat_surat'        => 'required|in:biasa,penting,segera,sangat_segera',
            'priority'           => 'required|in:rendah,sedang,tinggi,urgent',
            'due_date'           => 'nullable|date|after_or_equal:today',
            'keywords'           => 'nullable|string',
            'uploaded_file_path' => 'nullable|string',
        ]);

        $data = [
            'nomor_surat'        => $request->nomor_surat,
            'nomor_agenda'       => $request->nomor_agenda,
            'tanggal_surat'      => $request->tanggal_surat,
            'tanggal_terima'     => $request->tanggal_terima,
            'pengirim'           => $request->pengirim,
            'alamat_pengirim'    => $request->alamat_pengirim,
            'telepon_pengirim'   => $request->telepon_pengirim,
            'email_pengirim'     => $request->email_pengirim,
            'perihal'            => $request->perihal,
            'isi_ringkas'        => $request->isi_ringkas,
            'klasifikasi_id'     => $request->klasifikasi_id,
            'tingkat_keamanan'   => $request->tingkat_keamanan,
            'sifat_surat'        => $request->sifat_surat,
            'status'             => 'baru',
            'status_baca'        => 'belum',
            'priority'           => $request->priority,
            'due_date'           => $request->due_date,
            'keywords'           => $request->keywords,
            'user_id'            => Auth::id(),
            'file'               => $request->uploaded_file_path,
        ];

        // Set file metadata if file exists
        if ($request->uploaded_file_path && Storage::disk('public')->exists($request->uploaded_file_path)) {
            $filePath = storage_path('app/public/' . $request->uploaded_file_path);
            $data['file_size'] = filesize($filePath);
            $data['file_type'] = pathinfo($filePath, PATHINFO_EXTENSION);
        }

        SuratMasuk::create($data);

        return redirect()->route('surat.masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $suratMasuk = SuratMasuk::with(['klasifikasi', 'user'])->findOrFail($id);
        
        // Mark as read when viewed
        if ($suratMasuk->status_baca === 'belum') {
            $suratMasuk->update(['status_baca' => 'sudah']);
        }

        return view('surat.masuk.show', compact('suratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $suratMasuk = SuratMasuk::with(['klasifikasi', 'user'])->findOrFail($id);
        $klasifikasis = Klasifikasi::orderBy('nama_klasifikasi')->get();
        
        return view('surat.masuk.edit', compact('suratMasuk', 'klasifikasis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        $request->validate([
            'nomor_surat'        => 'required|string|max:255|unique:surat_masuks,nomor_surat,' . $id,
            'nomor_agenda'       => 'nullable|string|max:255',
            'tanggal_surat'      => 'required|date',
            'tanggal_terima'     => 'required|date',
            'pengirim'           => 'required|string|max:255',
            'alamat_pengirim'    => 'nullable|string',
            'telepon_pengirim'   => 'nullable|string|max:20',
            'email_pengirim'     => 'nullable|email|max:255',
            'perihal'            => 'required|string|max:255',
            'isi_ringkas'        => 'nullable|string',
            'klasifikasi_id'     => 'required|exists:klasifikasis,id',
            'tingkat_keamanan'   => 'required|in:biasa,rahasia,sangat_rahasia',
            'sifat_surat'        => 'required|in:biasa,penting,segera,sangat_segera',
            'status'             => 'required|in:baru,diproses,selesai',
            'priority'           => 'required|in:rendah,sedang,tinggi,urgent',
            'due_date'           => 'nullable|date',
            'keywords'           => 'nullable|string',
            'file'               => 'nullable|file|mimes:pdf,docx,doc,jpg,jpeg,png|max:5120', // 5MB
        ]);

        $updateData = [
            'nomor_surat'        => $request->nomor_surat,
            'nomor_agenda'       => $request->nomor_agenda,
            'tanggal_surat'      => $request->tanggal_surat,
            'tanggal_terima'     => $request->tanggal_terima,
            'pengirim'           => $request->pengirim,
            'alamat_pengirim'    => $request->alamat_pengirim,
            'telepon_pengirim'   => $request->telepon_pengirim,
            'email_pengirim'     => $request->email_pengirim,
            'perihal'            => $request->perihal,
            'isi_ringkas'        => $request->isi_ringkas,
            'klasifikasi_id'     => $request->klasifikasi_id,
            'tingkat_keamanan'   => $request->tingkat_keamanan,
            'sifat_surat'        => $request->sifat_surat,
            'status'             => $request->status,
            'priority'           => $request->priority,
            'due_date'           => $request->due_date,
            'keywords'           => $request->keywords,
        ];

        // Handle file upload if exists
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($suratMasuk->file && Storage::disk('public')->exists($suratMasuk->file)) {
                Storage::disk('public')->delete($suratMasuk->file);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/surat_masuk', $fileName, 'public');
            
            $updateData['file'] = $filePath;
            $updateData['file_size'] = $file->getSize();
            $updateData['file_type'] = $file->getClientOriginalExtension();
        }

        $suratMasuk->update($updateData);

        return redirect()->route('surat.masuk.index')
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        // Delete associated file if exists
        if ($suratMasuk->file && Storage::disk('public')->exists($suratMasuk->file)) {
            Storage::disk('public')->delete($suratMasuk->file);
        }

        $suratMasuk->delete();

        return redirect()->route('surat.masuk.index')
            ->with('deleted', 'Surat masuk berhasil dihapus.');
    }

    /**
     * Archive the specified resource.
     */
    public function arsip($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $surat->update([
            'status_baca' => 'arsip',
            'status' => 'selesai'
        ]);

        return redirect()->route('surat.masuk.index')
            ->with('arsip', 'Surat berhasil diarsipkan.');
    }

    /**
     * Upload file handler for AJAX requests.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,docx,doc,jpg,jpeg,png|max:5120'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/surat_masuk', $fileName, 'public');
            
            return response()->json([
                'success' => true,
                'file_path' => $path,
                'url' => Storage::url($path),
                'filename' => $fileName,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
    }

    /**
     * Mark multiple letters as read (bulk action)
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:surat_masuks,id'
        ]);

        SuratMasuk::whereIn('id', $request->ids)
                  ->where('status_baca', 'belum')
                  ->update(['status_baca' => 'sudah']);

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil ditandai sebagai sudah dibaca.'
        ]);
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats()
    {
        return response()->json([
            'total' => SuratMasuk::count(),
            'belum_dibaca' => SuratMasuk::where('status_baca', 'belum')->count(),
            'urgent' => SuratMasuk::where('priority', 'urgent')->where('status', '!=', 'selesai')->count(),
            'overdue' => SuratMasuk::where('due_date', '<', Carbon::today())
                                  ->whereNotNull('due_date')
                                  ->where('status', '!=', 'selesai')
                                  ->count(),
        ]);
    }
}