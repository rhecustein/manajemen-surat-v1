@extends('layouts.main')

@section('title', 'Detail Surat Masuk - Sistem KP Manajemen Surat')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 w-4 h-4 mx-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Manajemen Surat</span>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 w-4 h-4 mx-1"></i>
            <a href="{{ route('surat.masuk.index') }}" class="ml-1 text-sm font-medium text-blue-600 hover:text-blue-500">Surat Masuk</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 w-4 h-4 mx-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Detail</span>
        </div>
    </li>
@endsection

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header with Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $suratMasuk->nomor_surat }}</h1>
                <p class="text-lg text-gray-600 mt-1">{{ $suratMasuk->perihal }}</p>
                <div class="flex items-center space-x-4 mt-3">
                    <!-- Status Badges -->
                    @if($suratMasuk->status_baca == 'belum')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-eye-slash mr-2"></i>
                            Belum Dibaca
                        </span>
                    @elseif($suratMasuk->status_baca == 'arsip')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-archive mr-2"></i>
                            Diarsipkan
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-eye mr-2"></i>
                            Sudah Dibaca
                        </span>
                    @endif

                    @if($suratMasuk->status == 'baru')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Baru
                        </span>
                    @elseif($suratMasuk->status == 'diproses')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            Diproses
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Selesai
                        </span>
                    @endif

                    @if($suratMasuk->priority == 'urgent')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-bolt mr-2"></i>
                            Urgent
                        </span>
                    @elseif($suratMasuk->priority == 'tinggi')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            Tinggi
                        </span>
                    @elseif($suratMasuk->priority == 'rendah')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            Rendah
                        </span>
                    @endif

                    @if($suratMasuk->tingkat_keamanan != 'biasa')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            @if($suratMasuk->tingkat_keamanan == 'rahasia')
                                <i class="fas fa-lock mr-2"></i>
                                Rahasia
                            @elseif($suratMasuk->tingkat_keamanan == 'sangat_rahasia')
                                <i class="fas fa-shield-alt mr-2"></i>
                                Sangat Rahasia
                            @endif
                        </span>
                    @endif

                    @if($suratMasuk->sifat_surat != 'biasa')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($suratMasuk->sifat_surat == 'sangat_segera') bg-red-100 text-red-800
                            @elseif($suratMasuk->sifat_surat == 'segera') bg-orange-100 text-orange-800
                            @elseif($suratMasuk->sifat_surat == 'penting') bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucwords(str_replace('_', ' ', $suratMasuk->sifat_surat)) }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center space-x-3">
                @if($suratMasuk->file)
                    <a href="{{ asset('storage/' . $suratMasuk->file) }}" 
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-lg hover:bg-blue-200 transition-colors">
                        <i class="fas fa-file-alt mr-2"></i>
                        Lihat File
                    </a>
                @endif
                
                <a href="{{ route('surat.masuk.edit', $suratMasuk->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-lg hover:bg-yellow-200 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>

                @if($suratMasuk->status_baca !== 'arsip')
                    <form action="{{ route('surat.masuk.arsip', $suratMasuk->id) }}" 
                          method="POST" 
                          class="inline-block"
                          onsubmit="return confirm('Yakin arsipkan surat ini?')">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-archive mr-2"></i>
                            Arsipkan
                        </button>
                    </form>
                @endif

                <form action="{{ route('surat.masuk.destroy', $suratMasuk->id) }}" 
                      method="POST" 
                      class="inline-block"
                      onsubmit="return confirm('Yakin hapus surat ini? Data akan hilang permanen.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 text-sm font-medium rounded-lg hover:bg-red-200 transition-colors">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Due Date Warning -->
        @if($suratMasuk->due_date)
            @php
                $dueDate = \Carbon\Carbon::parse($suratMasuk->due_date);
                $today = \Carbon\Carbon::today();
                $isOverdue = $dueDate->lt($today);
                $isToday = $dueDate->isToday();
                $daysLeft = $today->diffInDays($dueDate, false);
            @endphp
            
            @if($isOverdue)
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-red-800">Surat Overdue</h4>
                            <p class="text-sm text-red-700">Deadline: {{ $dueDate->format('d M Y') }} ({{ abs($daysLeft) }} hari yang lalu)</p>
                        </div>
                    </div>
                </div>
            @elseif($isToday)
                <div class="mt-4 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-orange-500 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-orange-800">Jatuh Tempo Hari Ini</h4>
                            <p class="text-sm text-orange-700">Deadline: {{ $dueDate->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            @elseif($daysLeft <= 3)
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-yellow-500 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-yellow-800">Segera Jatuh Tempo</h4>
                            <p class="text-sm text-yellow-700">Deadline: {{ $dueDate->format('d M Y') }} ({{ $daysLeft }} hari lagi)</p>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Surat -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Surat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Nomor Surat</h3>
                        <p class="text-sm text-gray-900 font-medium">{{ $suratMasuk->nomor_surat }}</p>
                    </div>
                    
                    @if($suratMasuk->nomor_agenda)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Nomor Agenda</h3>
                            <p class="text-sm text-gray-900">{{ $suratMasuk->nomor_agenda }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Surat</h3>
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($suratMasuk->tanggal_surat)->format('d F Y') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Terima</h3>
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($suratMasuk->tanggal_terima)->format('d F Y') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Klasifikasi</h3>
                        <p class="text-sm text-gray-900">{{ $suratMasuk->klasifikasi->nama_klasifikasi ?? '-' }}</p>
                        @if($suratMasuk->klasifikasi)
                            <p class="text-xs text-gray-500">Kode: {{ $suratMasuk->klasifikasi->kode }}</p>
                        @endif
                    </div>

                    @if($suratMasuk->due_date)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Deadline</h3>
                            <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($suratMasuk->due_date)->format('d F Y') }}</p>
                        </div>
                    @endif
                </div>

                @if($suratMasuk->isi_ringkas)
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Isi Ringkas</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-900 leading-relaxed">{{ $suratMasuk->isi_ringkas }}</p>
                        </div>
                    </div>
                @endif

                @if($suratMasuk->keywords)
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Kata Kunci</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $suratMasuk->keywords) as $keyword)
                                @if(trim($keyword))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ trim($keyword) }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Informasi Pengirim -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengirim</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Nama Pengirim</h3>
                        <p class="text-sm text-gray-900 font-medium">{{ $suratMasuk->pengirim }}</p>
                    </div>
                    
                    @if($suratMasuk->alamat_pengirim)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Alamat</h3>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-sm text-gray-900 leading-relaxed">{{ $suratMasuk->alamat_pengirim }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($suratMasuk->telepon_pengirim)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Telepon</h3>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-phone text-gray-400"></i>
                                    <a href="tel:{{ $suratMasuk->telepon_pengirim }}" 
                                       class="text-sm text-blue-600 hover:text-blue-800">
                                        {{ $suratMasuk->telepon_pengirim }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        @if($suratMasuk->email_pengirim)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Email</h3>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                    <a href="mailto:{{ $suratMasuk->email_pengirim }}" 
                                       class="text-sm text-blue-600 hover:text-blue-800">
                                        {{ $suratMasuk->email_pengirim }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- File Attachment -->
            @if($suratMasuk->file)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">File Lampiran</h2>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    @if($suratMasuk->file_type == 'pdf')
                                        <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                                    @elseif(in_array($suratMasuk->file_type, ['doc', 'docx']))
                                        <i class="fas fa-file-word text-blue-600 text-xl"></i>
                                    @elseif(in_array($suratMasuk->file_type, ['jpg', 'jpeg', 'png']))
                                        <i class="fas fa-file-image text-green-600 text-xl"></i>
                                    @else
                                        <i class="fas fa-file-alt text-gray-600 text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        File Surat
                                        @if($suratMasuk->file_type)
                                            ({{ strtoupper($suratMasuk->file_type) }})
                                        @endif
                                    </p>
                                    @if($suratMasuk->file_size)
                                        <p class="text-xs text-gray-500">
                                            Ukuran: {{ number_format($suratMasuk->file_size / 1024, 0) }}KB
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ asset('storage/' . $suratMasuk->file) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Buka
                                </a>
                                <a href="{{ asset('storage/' . $suratMasuk->file) }}" 
                                   download
                                   class="inline-flex items-center px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-download mr-2"></i>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('surat.masuk.index') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    
                    <a href="{{ route('surat.masuk.edit', $suratMasuk->id) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Surat
                    </a>

                    @if($suratMasuk->file)
                        <a href="{{ asset('storage/' . $suratMasuk->file) }}" 
                           target="_blank"
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-file-alt mr-2"></i>
                            Lihat File
                        </a>
                    @endif

                    <button onclick="window.print()" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-print mr-2"></i>
                        Print Detail
                    </button>
                </div>
            </div>

            <!-- Information Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Status Baca</span>
                        @if($suratMasuk->status_baca == 'belum')
                            <span class="text-sm text-yellow-600 font-medium">Belum Dibaca</span>
                        @elseif($suratMasuk->status_baca == 'arsip')
                            <span class="text-sm text-gray-600 font-medium">Diarsipkan</span>
                        @else
                            <span class="text-sm text-green-600 font-medium">Sudah Dibaca</span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Status Proses</span>
                        @if($suratMasuk->status == 'baru')
                            <span class="text-sm text-blue-600 font-medium">Baru</span>
                        @elseif($suratMasuk->status == 'diproses')
                            <span class="text-sm text-orange-600 font-medium">Diproses</span>
                        @else
                            <span class="text-sm text-green-600 font-medium">Selesai</span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Prioritas</span>
                        <span class="text-sm font-medium
                            @if($suratMasuk->priority == 'urgent') text-red-600
                            @elseif($suratMasuk->priority == 'tinggi') text-orange-600
                            @elseif($suratMasuk->priority == 'sedang') text-blue-600
                            @else text-gray-600
                            @endif">
                            {{ ucfirst($suratMasuk->priority) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Tingkat Keamanan</span>
                        <span class="text-sm font-medium
                            @if($suratMasuk->tingkat_keamanan == 'sangat_rahasia') text-red-600
                            @elseif($suratMasuk->tingkat_keamanan == 'rahasia') text-orange-600
                            @else text-gray-600
                            @endif">
                            {{ ucwords(str_replace('_', ' ', $suratMasuk->tingkat_keamanan)) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Sifat Surat</span>
                        <span class="text-sm font-medium
                            @if($suratMasuk->sifat_surat == 'sangat_segera') text-red-600
                            @elseif($suratMasuk->sifat_surat == 'segera') text-orange-600
                            @elseif($suratMasuk->sifat_surat == 'penting') text-yellow-600
                            @else text-gray-600
                            @endif">
                            {{ ucwords(str_replace('_', ' ', $suratMasuk->sifat_surat)) }}
                        </span>
                    </div>

                    @if($suratMasuk->file)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">File Lampiran</span>
                            <span class="text-sm text-green-600 font-medium">Ada</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Metadata</h3>
                <div class="space-y-3">
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Dibuat oleh</h4>
                        <p class="text-sm text-gray-900">{{ $suratMasuk->user->name ?? 'System' }}</p>
                        <p class="text-xs text-gray-500">{{ $suratMasuk->created_at->format('d M Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Terakhir diupdate</h4>
                        <p class="text-xs text-gray-500">{{ $suratMasuk->updated_at->format('d M Y H:i') }}</p>
                        @if($suratMasuk->created_at != $suratMasuk->updated_at)
                            <p class="text-xs text-gray-400">
                                ({{ $suratMasuk->updated_at->diffForHumans() }})
                            </p>
                        @endif
                    </div>

                    @if($suratMasuk->file_size)
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Ukuran File</h4>
                            <p class="text-sm text-gray-900">
                                {{ number_format($suratMasuk->file_size / 1024, 1) }} KB
                                @if($suratMasuk->file_size > 1024 * 1024)
                                    ({{ number_format($suratMasuk->file_size / (1024 * 1024), 1) }} MB)
                                @endif
                            </p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">ID Surat</h4>
                        <p class="text-xs text-gray-400 font-mono">{{ $suratMasuk->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Related Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Terkait</h3>
                <div class="space-y-3">
                    <a href="{{ route('surat.masuk.create') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-blue-300 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Surat Baru
                    </a>
                    
                    <a href="{{ route('surat.masuk.index', ['search' => $suratMasuk->pengirim]) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Surat dari {{ Str::limit($suratMasuk->pengirim, 15) }}
                    </a>
                    
                    @if($suratMasuk->klasifikasi)
                        <a href="{{ route('surat.masuk.index', ['klasifikasi_id' => $suratMasuk->klasifikasi_id]) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-tags mr-2"></i>
                            Surat {{ Str::limit($suratMasuk->klasifikasi->nama_klasifikasi, 15) }}
                        </a>
                    @endif

                    @if($suratMasuk->priority == 'urgent')
                        <a href="{{ route('surat.masuk.index', ['priority' => 'urgent']) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 text-red-700 text-sm font-medium rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fas fa-bolt mr-2"></i>
                            Surat Urgent Lainnya
                        </a>
                    @endif
                </div>
            </div>

            <!-- Navigation -->
            @php
                $prevSurat = \App\Models\SuratMasuk::where('id', '<', $suratMasuk->id)->orderBy('id', 'desc')->first();
                $nextSurat = \App\Models\SuratMasuk::where('id', '>', $suratMasuk->id)->orderBy('id', 'asc')->first();
            @endphp

            @if($prevSurat || $nextSurat)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Navigasi</h3>
                    <div class="space-y-3">
                        @if($prevSurat)
                            <a href="{{ route('surat.masuk.show', $prevSurat->id) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-left mr-2"></i>
                                Surat Sebelumnya
                            </a>
                        @endif
                        
                        @if($nextSurat)
                            <a href="{{ route('surat.masuk.show', $nextSurat->id) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                Surat Selanjutnya
                                <i class="fas fa-chevron-right ml-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .no-print,
    .no-print * {
        display: none !important;
    }
    
    .print-only {
        display: block !important;
    }
    
    body {
        font-size: 12pt;
        line-height: 1.4;
    }
    
    .bg-white {
        background: white !important;
    }
    
    .shadow-sm,
    .shadow {
        box-shadow: none !important;
    }
    
    .border {
        border: 1px solid #000 !important;
    }
    
    .rounded-xl,
    .rounded-lg {
        border-radius: 0 !important;
    }
    
    .text-gray-500,
    .text-gray-600,
    .text-gray-700,
    .text-gray-800,
    .text-gray-900 {
        color: #000 !important;
    }
    
    .bg-gray-50 {
        background: #f9f9f9 !important;
    }
    
    h1, h2, h3 {
        page-break-after: avoid;
    }
    
    .grid {
        display: block !important;
    }
    
    .space-y-6 > * {
        margin-bottom: 1rem !important;
    }
    
    .page-break {
        page-break-before: always;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success messages
    const alerts = document.querySelectorAll('.alert-auto-hide');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + P for print
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            window.print();
        }
        
        // E for edit
        if (e.key === 'e' && !e.ctrlKey && !e.metaKey && !e.altKey) {
            const activeElement = document.activeElement;
            if (activeElement.tagName !== 'INPUT' && activeElement.tagName !== 'TEXTAREA') {
                window.location.href = '{{ route("surat.masuk.edit", $suratMasuk->id) }}';
            }
        }
        
        // Escape to go back
        if (e.key === 'Escape') {
            window.location.href = '{{ route("surat.masuk.index") }}';
        }

        // Arrow keys for navigation
        @if($prevSurat)
            if (e.key === 'ArrowLeft' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                const activeElement = document.activeElement;
                if (activeElement.tagName !== 'INPUT' && activeElement.tagName !== 'TEXTAREA') {
                    window.location.href = '{{ route("surat.masuk.show", $prevSurat->id) }}';
                }
            }
        @endif

        @if($nextSurat)
            if (e.key === 'ArrowRight' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                const activeElement = document.activeElement;
                if (activeElement.tagName !== 'INPUT' && activeElement.tagName !== 'TEXTAREA') {
                    window.location.href = '{{ route("surat.masuk.show", $nextSurat->id) }}';
                }
            }
        @endif
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Copy to clipboard functionality
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Disalin ke clipboard', 'success');
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    }

    // Add click to copy functionality for metadata
    const metadataElements = document.querySelectorAll('.font-mono');
    metadataElements.forEach(element => {
        element.style.cursor = 'pointer';
        element.title = 'Klik untuk menyalin';
        element.addEventListener('click', function() {
            copyToClipboard(this.textContent);
        });
    });
});

// Notification helper function
function showNotification(message, type = 'info') {
    const colors = {
        success: 'bg-green-50 border-green-200 text-green-800',
        error: 'bg-red-50 border-red-200 text-red-800',
        info: 'bg-blue-50 border-blue-200 text-blue-800'
    };

    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };

    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 ${colors[type]} border rounded-lg p-4 shadow-lg transition-all duration-300 transform translate-x-full`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="${icons[type]} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Print function
function printDetail() {
    window.print();
}
</script>
@endpush
@endsection