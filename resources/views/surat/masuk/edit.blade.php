@extends('layouts.main')

@section('title', 'Edit Surat Masuk - Sistem KP Manajemen Surat')

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
            <span class="ml-1 text-sm font-medium text-gray-500">Edit</span>
        </div>
    </li>
@endsection

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Edit Surat Masuk</h1>
                <p class="text-sm text-gray-600 mt-1">Nomor: {{ $suratMasuk->nomor_surat }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-xs text-gray-500">Dibuat oleh</p>
                    <p class="text-sm font-medium text-gray-900">{{ $suratMasuk->user->name ?? 'System' }}</p>
                    <p class="text-xs text-gray-500">{{ $suratMasuk->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Terakhir diupdate</p>
                    <p class="text-xs text-gray-500">{{ $suratMasuk->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Form Content -->
        <div class="p-6">
            <form action="{{ route('surat.masuk.update', $suratMasuk->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  id="formEditSuratMasuk"
                  x-data="{ isSubmitting: false }"
                  @submit="isSubmitting = true">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column - Informasi Dasar -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-md font-semibold text-gray-800 mb-4">Informasi Dasar Surat</h3>
                            
                            <!-- Nomor Surat -->
                            <div class="mb-4">
                                <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Surat <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nomor_surat" 
                                       id="nomor_surat"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                              @error('nomor_surat') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       value="{{ old('nomor_surat', $suratMasuk->nomor_surat) }}" 
                                       placeholder="Contoh: 001/KEP/2024"
                                       required>
                                @error('nomor_surat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Nomor Agenda -->
                            <div class="mb-4">
                                <label for="nomor_agenda" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Agenda
                                </label>
                                <input type="text" 
                                       name="nomor_agenda" 
                                       id="nomor_agenda"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                              @error('nomor_agenda') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       value="{{ old('nomor_agenda', $suratMasuk->nomor_agenda) }}" 
                                       placeholder="Nomor agenda internal">
                                @error('nomor_agenda')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Tanggal Surat & Tanggal Terima -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Surat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" 
                                           name="tanggal_surat" 
                                           id="tanggal_surat"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                                  @error('tanggal_surat') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                           value="{{ old('tanggal_surat', $suratMasuk->tanggal_surat) }}" 
                                           required>
                                    @error('tanggal_surat')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tanggal_terima" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Terima <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" 
                                           name="tanggal_terima" 
                                           id="tanggal_terima"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                                  @error('tanggal_terima') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                           value="{{ old('tanggal_terima', $suratMasuk->tanggal_terima) }}" 
                                           required>
                                    @error('tanggal_terima')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Perihal -->
                            <div class="mb-4">
                                <label for="perihal" class="block text-sm font-medium text-gray-700 mb-2">
                                    Perihal <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="perihal" 
                                       id="perihal"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                              @error('perihal') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       value="{{ old('perihal', $suratMasuk->perihal) }}" 
                                       placeholder="Perihal/subjek surat"
                                       required>
                                @error('perihal')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Isi Ringkas -->
                            <div>
                                <label for="isi_ringkas" class="block text-sm font-medium text-gray-700 mb-2">
                                    Isi Ringkas
                                </label>
                                <textarea name="isi_ringkas" 
                                          id="isi_ringkas"
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                                 @error('isi_ringkas') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                          placeholder="Ringkasan singkat isi surat">{{ old('isi_ringkas', $suratMasuk->isi_ringkas) }}</textarea>
                                @error('isi_ringkas')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Pengirim -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-md font-semibold text-gray-800 mb-4">Informasi Pengirim</h3>
                            
                            <!-- Pengirim -->
                            <div class="mb-4">
                                <label for="pengirim" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Pengirim <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="pengirim" 
                                       id="pengirim"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                              @error('pengirim') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       value="{{ old('pengirim', $suratMasuk->pengirim) }}" 
                                       placeholder="Nama instansi atau perorangan pengirim"
                                       required>
                                @error('pengirim')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Alamat Pengirim -->
                            <div class="mb-4">
                                <label for="alamat_pengirim" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Pengirim
                                </label>
                                <textarea name="alamat_pengirim" 
                                          id="alamat_pengirim"
                                          rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                                 @error('alamat_pengirim') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                          placeholder="Alamat lengkap pengirim">{{ old('alamat_pengirim', $suratMasuk->alamat_pengirim) }}</textarea>
                                @error('alamat_pengirim')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Telepon & Email -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="telepon_pengirim" class="block text-sm font-medium text-gray-700 mb-2">
                                        Telepon Pengirim
                                    </label>
                                    <input type="text" 
                                           name="telepon_pengirim" 
                                           id="telepon_pengirim"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                                  @error('telepon_pengirim') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                           value="{{ old('telepon_pengirim', $suratMasuk->telepon_pengirim) }}" 
                                           placeholder="Nomor telepon">
                                    @error('telepon_pengirim')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email_pengirim" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email Pengirim
                                    </label>
                                    <input type="email" 
                                           name="email_pengirim" 
                                           id="email_pengirim"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                                  @error('email_pengirim') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                           value="{{ old('email_pengirim', $suratMasuk->email_pengirim) }}" 
                                           placeholder="Email pengirim">
                                    @error('email_pengirim')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Klasifikasi & Settings -->
                    <div class="space-y-6">
                        <!-- Klasifikasi & Prioritas -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-md font-semibold text-gray-800 mb-4">Klasifikasi & Prioritas</h3>
                            
                            <!-- Klasifikasi Surat -->
                            <div class="mb-4">
                                <label for="klasifikasi_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Klasifikasi Surat <span class="text-red-500">*</span>
                                </label>
                                <select name="klasifikasi_id" 
                                        id="klasifikasi_id" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                               @error('klasifikasi_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <option value="">-- Pilih Klasifikasi --</option>
                                    @foreach($klasifikasis as $klasifikasi)
                                        <option value="{{ $klasifikasi->id }}" 
                                                {{ old('klasifikasi_id', $suratMasuk->klasifikasi_id) == $klasifikasi->id ? 'selected' : '' }}>
                                            {{ $klasifikasi->nama_klasifikasi }} - {{ $klasifikasi->kode }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('klasifikasi_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" 
                                        id="status" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                               @error('status') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <option value="baru" {{ old('status', $suratMasuk->status) == 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="diproses" {{ old('status', $suratMasuk->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ old('status', $suratMasuk->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Tingkat Keamanan -->
                            <div class="mb-4">
                                <label for="tingkat_keamanan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tingkat Keamanan <span class="text-red-500">*</span>
                                </label>
                                <select name="tingkat_keamanan" 
                                        id="tingkat_keamanan" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                               @error('tingkat_keamanan') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <option value="biasa" {{ old('tingkat_keamanan', $suratMasuk->tingkat_keamanan) == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="rahasia" {{ old('tingkat_keamanan', $suratMasuk->tingkat_keamanan) == 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                                    <option value="sangat_rahasia" {{ old('tingkat_keamanan', $suratMasuk->tingkat_keamanan) == 'sangat_rahasia' ? 'selected' : '' }}>Sangat Rahasia</option>
                                </select>
                                @error('tingkat_keamanan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Sifat Surat -->
                            <div class="mb-4">
                                <label for="sifat_surat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Sifat Surat <span class="text-red-500">*</span>
                                </label>
                                <select name="sifat_surat" 
                                        id="sifat_surat" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                               @error('sifat_surat') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <option value="biasa" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="penting" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'penting' ? 'selected' : '' }}>Penting</option>
                                    <option value="segera" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'segera' ? 'selected' : '' }}>Segera</option>
                                    <option value="sangat_segera" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'sangat_segera' ? 'selected' : '' }}>Sangat Segera</option>
                                </select>
                                @error('sifat_surat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Priority -->
                            <div class="mb-4">
                                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                                    Prioritas <span class="text-red-500">*</span>
                                </label>
                                <select name="priority" 
                                        id="priority" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                               @error('priority') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <option value="rendah" {{ old('priority', $suratMasuk->priority) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ old('priority', $suratMasuk->priority) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ old('priority', $suratMasuk->priority) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="urgent" {{ old('priority', $suratMasuk->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('priority')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div class="mb-4">
                                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deadline Tindak Lanjut
                                </label>
                                <input type="date" 
                                       name="due_date" 
                                       id="due_date"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                              @error('due_date') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       value="{{ old('due_date', $suratMasuk->due_date) }}">
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Tanggal deadline untuk tindak lanjut surat ini</p>
                            </div>

                            <!-- Keywords -->
                            <div>
                                <label for="keywords" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kata Kunci
                                </label>
                                <input type="text" 
                                       name="keywords" 
                                       id="keywords"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                              @error('keywords') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                       value="{{ old('keywords', $suratMasuk->keywords) }}" 
                                       placeholder="Kata kunci untuk pencarian, pisahkan dengan koma">
                                @error('keywords')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Masukkan kata kunci yang memudahkan pencarian surat ini</p>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-md font-semibold text-gray-800 mb-4">File Surat</h3>
                            
                            @if($suratMasuk->file)
                                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-file-alt text-blue-600"></i>
                                            <div>
                                                <p class="text-sm font-medium text-blue-900">File saat ini</p>
                                                <p class="text-xs text-blue-700">
                                                    @if($suratMasuk->file_type)
                                                        {{ strtoupper($suratMasuk->file_type) }} -
                                                    @endif
                                                    @if($suratMasuk->file_size)
                                                        {{ number_format($suratMasuk->file_size / 1024, 0) }}KB
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . $suratMasuk->file) }}" 
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="bg-white rounded-lg border-2 border-dashed border-gray-300 p-4">
                                <div class="text-center">
                                    <div class="mb-4">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">
                                        @if($suratMasuk->file)
                                            Upload file baru untuk mengganti file yang ada
                                        @else
                                            Upload file surat (PDF, DOC, DOCX, JPG, PNG - Max 5MB)
                                        @endif
                                    </p>
                                    
                                    <input type="file" 
                                           name="file" 
                                           id="file"
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    
                                    @error('file')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    
                                    <!-- Upload Instructions -->
                                    <div class="mt-4 text-xs text-gray-500 space-y-1">
                                        <p>• Format yang diizinkan: PDF, DOC, DOCX, JPG, PNG</p>
                                        <p>• Ukuran maksimal: 5MB</p>
                                        @if($suratMasuk->file)
                                            <p class="text-orange-600">• File baru akan mengganti file yang ada</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('surat.masuk.show', $suratMasuk->id) }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-eye mr-2"></i>
                        Lihat Detail
                    </a>
                    <a href="{{ route('surat.masuk.index') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            :disabled="isSubmitting"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                        <span x-show="!isSubmitting">
                            <i class="fas fa-save mr-2"></i>
                            Update Surat
                        </span>
                        <span x-show="isSubmitting" class="flex items-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Form validation
    const form = document.getElementById('formEditSuratMasuk');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            } else {
                field.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
            showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
        }
    });

    // Enhanced Select2 for klasifikasi (if Select2 is available)
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#klasifikasi_id').select2({
            placeholder: "Pilih Klasifikasi Surat",
            allowClear: true,
            width: '100%',
            theme: 'default'
        });
    }

    // File preview and validation
    const fileInput = document.getElementById('file');
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                showNotification('Ukuran file terlalu besar. Maksimal 5MB', 'error');
                fileInput.value = '';
                return;
            }

            // Validate file type
            const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                showNotification('Tipe file tidak diizinkan. Hanya PDF, DOC, DOCX, JPG, PNG', 'error');
                fileInput.value = '';
                return;
            }

            showNotification('File valid dan siap diupload', 'success');
        }
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

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}
</script>
@endpush
@endsection