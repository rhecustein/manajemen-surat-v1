@extends('layouts.main')

@section('title', 'Surat Masuk - Sistem KP Manajemen Surat')

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
            <span class="ml-1 text-sm font-medium text-gray-500">Surat Masuk</span>
        </div>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Floating Notifications -->
    @if (session('success') || session('deleted') || session('arsip'))
        <div x-data="{ show: true }" 
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 z-50 min-w-80 max-w-md">
            <div class="
                @if (session('success')) bg-green-50 border border-green-200 
                @elseif (session('deleted')) bg-red-50 border border-red-200 
                @elseif (session('arsip')) bg-yellow-50 border border-yellow-200 
                @endif 
                rounded-lg p-4 shadow-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="
                            w-8 h-8 rounded-full flex items-center justify-center
                            @if (session('success')) bg-green-500 
                            @elseif (session('deleted')) bg-red-500 
                            @elseif (session('arsip')) bg-yellow-500 
                            @endif">
                            <i class="
                                @if (session('success')) fas fa-check 
                                @elseif (session('deleted')) fas fa-trash 
                                @elseif (session('arsip')) fas fa-archive 
                                @endif 
                                text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-semibold 
                            @if (session('success')) text-green-800 
                            @elseif (session('deleted')) text-red-800 
                            @elseif (session('arsip')) text-yellow-800 
                            @endif">
                            @if (session('success')) Berhasil! 
                            @elseif (session('deleted')) Dihapus! 
                            @elseif (session('arsip')) Diarsipkan! 
                            @endif
                        </h3>
                        <p class="text-sm 
                            @if (session('success')) text-green-700 
                            @elseif (session('deleted')) text-red-700 
                            @elseif (session('arsip')) text-yellow-700 
                            @endif">
                            {{ session('success') ?? session('deleted') ?? session('arsip') }}
                        </p>
                    </div>
                    <button @click="show = false" 
                            class="ml-4 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Enhanced Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
        <!-- Total Surat Masuk -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Total Surat</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalSuratMasuk ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Surat Belum Dibaca -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Belum Dibaca</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalSuratBelumDibaca ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-eye-slash text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Surat Bulan Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Bulan Ini</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalSuratBulanIni ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-month text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Surat Hari Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Hari Ini</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalSuratHariIni ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-day text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Surat Overdue -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Overdue</p>
                    <h3 class="text-3xl font-bold text-red-600">{{ $totalSuratOverdue ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Surat Urgent -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Urgent</p>
                    <h3 class="text-3xl font-bold text-orange-600">{{ $totalSuratUrgent ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Filter & Pencarian</h3>
            <button type="button" 
                    onclick="toggleFilter()" 
                    class="text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-filter mr-1"></i>
                <span id="filter-toggle-text">Tampilkan Filter</span>
            </button>
        </div>

        <div id="filter-section" class="hidden">
            <form method="GET" action="{{ route('surat.masuk.index') }}" class="space-y-4">
                <!-- Row 1: Search, Status Baca, Status -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nomor surat, nomor agenda, pengirim, perihal, atau keywords..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Baca</label>
                        <select name="status_baca" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="belum" {{ request('status_baca') == 'belum' ? 'selected' : '' }}>Belum Dibaca</option>
                            <option value="sudah" {{ request('status_baca') == 'sudah' ? 'selected' : '' }}>Sudah Dibaca</option>
                            <option value="arsip" {{ request('status_baca') == 'arsip' ? 'selected' : '' }}>Diarsipkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Surat</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Priority, Tingkat Keamanan, Sifat Surat -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                        <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Prioritas</option>
                            <option value="rendah" {{ request('priority') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ request('priority') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ request('priority') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Keamanan</label>
                        <select name="tingkat_keamanan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Tingkat</option>
                            <option value="biasa" {{ request('tingkat_keamanan') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                            <option value="rahasia" {{ request('tingkat_keamanan') == 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                            <option value="sangat_rahasia" {{ request('tingkat_keamanan') == 'sangat_rahasia' ? 'selected' : '' }}>Sangat Rahasia</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sifat Surat</label>
                        <select name="sifat_surat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Sifat</option>
                            <option value="biasa" {{ request('sifat_surat') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                            <option value="penting" {{ request('sifat_surat') == 'penting' ? 'selected' : '' }}>Penting</option>
                            <option value="segera" {{ request('sifat_surat') == 'segera' ? 'selected' : '' }}>Segera</option>
                            <option value="sangat_segera" {{ request('sifat_surat') == 'sangat_segera' ? 'selected' : '' }}>Sangat Segera</option>
                        </select>
                    </div>
                </div>

                <!-- Row 3: Klasifikasi, File, Due Date Status -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Klasifikasi</label>
                        <select name="klasifikasi_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Klasifikasi</option>
                            @foreach($klasifikasis as $klasifikasi)
                                <option value="{{ $klasifikasi->id }}" {{ request('klasifikasi_id') == $klasifikasi->id ? 'selected' : '' }}>
                                    {{ $klasifikasi->nama_klasifikasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keberadaan File</label>
                        <select name="has_file" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua</option>
                            <option value="ada" {{ request('has_file') == 'ada' ? 'selected' : '' }}>Ada File</option>
                            <option value="tidak_ada" {{ request('has_file') == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada File</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Due Date</label>
                        <select name="due_date_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua</option>
                            <option value="overdue" {{ request('due_date_status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="today" {{ request('due_date_status') == 'today' ? 'selected' : '' }}>Jatuh Tempo Hari Ini</option>
                            <option value="upcoming" {{ request('due_date_status') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                        </select>
                    </div>
                </div>

                <!-- Row 4: Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat (Mulai)</label>
                        <input type="date" 
                               name="tanggal_mulai" 
                               value="{{ request('tanggal_mulai') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat (Selesai)</label>
                        <input type="date" 
                               name="tanggal_selesai" 
                               value="{{ request('tanggal_selesai') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                        <select name="bulan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <select name="tahun" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Tahun</option>
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <div class="flex space-x-2">
                            <select name="sort_by" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                <option value="tanggal_surat" {{ request('sort_by') == 'tanggal_surat' ? 'selected' : '' }}>Tanggal Surat</option>
                                <option value="tanggal_terima" {{ request('sort_by') == 'tanggal_terima' ? 'selected' : '' }}>Tanggal Terima</option>
                                <option value="nomor_surat" {{ request('sort_by') == 'nomor_surat' ? 'selected' : '' }}>Nomor Surat</option>
                                <option value="pengirim" {{ request('sort_by') == 'pengirim' ? 'selected' : '' }}>Pengirim</option>
                                <option value="due_date" {{ request('sort_by') == 'due_date' ? 'selected' : '' }}>Due Date</option>
                                <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Prioritas</option>
                            </select>
                            <select name="sort_direction" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Terlama</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Terapkan Filter
                    </button>
                    
                    <a href="{{ route('surat.masuk.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-refresh mr-2"></i>
                        Reset Filter
                    </a>

                    <div class="ml-auto">
                        <select name="per_page" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per halaman</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per halaman</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per halaman</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per halaman</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <!-- Bulk Actions -->
            <div class="hidden" id="bulk-actions">
                <button type="button" 
                        onclick="markSelectedAsRead()"
                        class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Tandai Dibaca
                </button>
            </div>
        </div>

        <a href="{{ route('surat.masuk.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Tambah Surat Masuk
        </a>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Surat Masuk</h2>
                
                @if($suratMasuk->total() > 0)
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $suratMasuk->firstItem() }} - {{ $suratMasuk->lastItem() }} dari {{ $suratMasuk->total() }} surat
                    </div>
                @endif
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Agenda</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klasifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Terima</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($suratMasuk as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $item->status_baca == 'belum' ? 'bg-blue-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="row-checkbox rounded border-gray-300" value="{{ $item->id }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $suratMasuk->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <div class="flex items-center">
                                    {{ $item->nomor_surat }}
                                    @if($item->status_baca == 'belum')
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            Baru
                                        </span>
                                    @endif
                                    @if($item->priority == 'urgent')
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-bolt mr-1"></i>
                                            Urgent
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->nomor_agenda ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>
                                    <div class="font-medium">{{ $item->pengirim }}</div>
                                    @if($item->email_pengirim)
                                        <div class="text-xs text-gray-500">{{ $item->email_pengirim }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                <div class="truncate" title="{{ $item->perihal }}">
                                    {{ $item->perihal }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $item->klasifikasi->nama_klasifikasi ?? 'Tidak Ada' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($item->due_date)
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($item->due_date);
                                        $today = \Carbon\Carbon::today();
                                        $isOverdue = $dueDate->lt($today);
                                        $isToday = $dueDate->isToday();
                                    @endphp
                                    <div class="flex items-center">
                                        <span class="@if($isOverdue) text-red-600 @elseif($isToday) text-orange-600 @else text-gray-900 @endif">
                                            {{ $dueDate->format('d M Y') }}
                                        </span>
                                        @if($isOverdue)
                                            <i class="fas fa-exclamation-triangle text-red-500 ml-1" title="Overdue"></i>
                                        @elseif($isToday)
                                            <i class="fas fa-clock text-orange-500 ml-1" title="Due Today"></i>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($item->file)
                                    <a href="{{ asset('storage/' . $item->file) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-file-alt mr-1"></i>
                                        @if($item->file_type)
                                            {{ strtoupper($item->file_type) }}
                                        @else
                                            File
                                        @endif
                                        @if($item->file_size)
                                            <span class="ml-1 text-gray-600">({{ number_format($item->file_size / 1024, 0) }}KB)</span>
                                        @endif
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                        Tidak Ada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    <!-- Status Baca -->
                                    @if($item->status_baca == 'belum')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-eye-slash mr-1"></i>
                                            Belum Dibaca
                                        </span>
                                    @elseif($item->status_baca == 'arsip')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-archive mr-1"></i>
                                            Diarsipkan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-eye mr-1"></i>
                                            Sudah Dibaca
                                        </span>
                                    @endif

                                    <!-- Status Processing -->
                                    @if($item->status == 'baru')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Baru
                                        </span>
                                    @elseif($item->status == 'diproses')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            Diproses
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    @endif

                                    <!-- Priority Badge -->
                                    @if($item->priority != 'sedang')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($item->priority == 'urgent') bg-red-100 text-red-800
                                            @elseif($item->priority == 'tinggi') bg-orange-100 text-orange-800
                                            @elseif($item->priority == 'rendah') bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($item->priority) }}
                                        </span>
                                    @endif

                                    <!-- Security Level -->
                                    @if($item->tingkat_keamanan != 'biasa')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            @if($item->tingkat_keamanan == 'rahasia')
                                                <i class="fas fa-lock mr-1"></i>
                                                Rahasia
                                            @elseif($item->tingkat_keamanan == 'sangat_rahasia')
                                                <i class="fas fa-shield-alt mr-1"></i>
                                                Sangat Rahasia
                                            @endif
                                        </span>
                                    @endif

                                    <!-- Sifat Surat -->
                                    @if($item->sifat_surat != 'biasa')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($item->sifat_surat == 'sangat_segera') bg-red-100 text-red-800
                                            @elseif($item->sifat_surat == 'segera') bg-orange-100 text-orange-800
                                            @elseif($item->sifat_surat == 'penting') bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ ucwords(str_replace('_', ' ', $item->sifat_surat)) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-1">
                                    <!-- View Button -->
                                    <a href="{{ route('surat.masuk.show', $item->id) }}" 
                                       class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded hover:bg-blue-200 transition-colors"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('surat.masuk.edit', $item->id) }}" 
                                       class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded hover:bg-yellow-200 transition-colors"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('surat.masuk.destroy', $item->id) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('Yakin hapus surat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded hover:bg-red-200 transition-colors"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                    <!-- Archive Button -->
                                    @if($item->status_baca !== 'arsip')
                                        <form action="{{ route('surat.masuk.arsip', $item->id) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Yakin arsipkan surat ini?')">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded hover:bg-gray-200 transition-colors"
                                                    title="Arsipkan">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="px-6 py-12">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-inbox text-gray-600 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                                        @if(request()->hasAny(['search', 'status_baca', 'status', 'priority', 'tingkat_keamanan', 'sifat_surat', 'klasifikasi_id', 'tanggal_mulai', 'tanggal_selesai', 'bulan', 'tahun', 'has_file', 'due_date_status']))
                                            Tidak ada surat yang sesuai dengan filter
                                        @else
                                            Belum ada surat masuk
                                        @endif
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-6">
                                        @if(request()->hasAny(['search', 'status_baca', 'status', 'priority', 'tingkat_keamanan', 'sifat_surat', 'klasifikasi_id', 'tanggal_mulai', 'tanggal_selesai', 'bulan', 'tahun', 'has_file', 'due_date_status']))
                                            Coba ubah kriteria pencarian atau filter Anda.
                                        @else
                                            Surat masuk akan muncul di sini setelah ditambahkan.
                                        @endif
                                    </p>
                                    @if(!request()->hasAny(['search', 'status_baca', 'status', 'priority', 'tingkat_keamanan', 'sifat_surat', 'klasifikasi_id', 'tanggal_mulai', 'tanggal_selesai', 'bulan', 'tahun', 'has_file', 'due_date_status']))
                                        <a href="{{ route('surat.masuk.create') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah Surat Masuk
                                        </a>
                                    @else
                                        <a href="{{ route('surat.masuk.index') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                            <i class="fas fa-refresh mr-2"></i>
                                            Reset Filter
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Enhanced Pagination -->
        @if($suratMasuk->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $suratMasuk->firstItem() }} sampai {{ $suratMasuk->lastItem() }} 
                        dari {{ $suratMasuk->total() }} hasil
                    </div>
                    <div class="flex space-x-1">
                        {{-- Previous Page Link --}}
                        @if ($suratMasuk->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $suratMasuk->previousPageUrl() }}" 
                               class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $start = max($suratMasuk->currentPage() - 2, 1);
                            $end = min($start + 4, $suratMasuk->lastPage());
                            $start = max($end - 4, 1);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $suratMasuk->url(1) }}" 
                               class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                1
                            </a>
                            @if($start > 2)
                                <span class="px-3 py-2 text-sm text-gray-500">...</span>
                            @endif
                        @endif

                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $suratMasuk->currentPage())
                                <span class="px-3 py-2 text-sm text-white bg-blue-600 rounded-lg">{{ $page }}</span>
                            @else
                                <a href="{{ $suratMasuk->url($page) }}" 
                                   class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endfor

                        @if($end < $suratMasuk->lastPage())
                            @if($end < $suratMasuk->lastPage() - 1)
                                <span class="px-3 py-2 text-sm text-gray-500">...</span>
                            @endif
                            <a href="{{ $suratMasuk->url($suratMasuk->lastPage()) }}" 
                               class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                {{ $suratMasuk->lastPage() }}
                            </a>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($suratMasuk->hasMorePages())
                            <a href="{{ $suratMasuk->nextPageUrl() }}" 
                               class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Filter toggle functionality
    function toggleFilter() {
        const filterSection = document.getElementById('filter-section');
        const toggleText = document.getElementById('filter-toggle-text');
        
        if (filterSection.classList.contains('hidden')) {
            filterSection.classList.remove('hidden');
            toggleText.textContent = 'Sembunyikan Filter';
        } else {
            filterSection.classList.add('hidden');
            toggleText.textContent = 'Tampilkan Filter';
        }
    }

    // Auto-show filter if any filter is active
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilter = Array.from(urlParams.keys()).some(key => 
            ['search', 'status_baca', 'status', 'priority', 'tingkat_keamanan', 'sifat_surat', 'klasifikasi_id', 'tanggal_mulai', 'tanggal_selesai', 'tanggal_terima_mulai', 'tanggal_terima_selesai', 'bulan', 'tahun', 'has_file', 'due_date_status', 'sort_by'].includes(key)
        );
        
        if (hasFilter) {
            document.getElementById('filter-section').classList.remove('hidden');
            document.getElementById('filter-toggle-text').textContent = 'Sembunyikan Filter';
        }
    });

    // Bulk selection functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const bulkActions = document.getElementById('bulk-actions');

        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });

        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
                selectAllCheckbox.checked = checkedCount === rowCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < rowCheckboxes.length;
                toggleBulkActions();
            });
        });

        function toggleBulkActions() {
            const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
            if (checkedCount > 0) {
                bulkActions.classList.remove('hidden');
            } else {
                bulkActions.classList.add('hidden');
            }
        }
    });

    // Mark selected letters as read
    function markSelectedAsRead() {
        const selected = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
        
        if (selected.length === 0) {
            alert('Pilih surat yang ingin ditandai sebagai sudah dibaca');
            return;
        }

        if (confirm(`Tandai ${selected.length} surat sebagai sudah dibaca?`)) {
            fetch('{{ route("surat.masuk.mark-as-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ ids: selected })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }
    }

    // Auto-hide success messages
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('[x-data*="show: true"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert && typeof Alpine !== 'undefined') {
                    Alpine.store('show', false);
                }
            }, 5000);
        });
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                if (document.getElementById('filter-section').classList.contains('hidden')) {
                    toggleFilter();
                }
                searchInput.focus();
            }
        }
        
        // Ctrl/Cmd + N to add new letter
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            window.location.href = '{{ route("surat.masuk.create") }}';
        }
    });
</script>
@endpush
@endsection