@extends('layouts.main')

@section('title', 'Tambah Surat Masuk - Sistem KP Manajemen Surat')

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
            <span class="ml-1 text-sm font-medium text-gray-500">Tambah</span>
        </div>
    </li>
@endsection

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Form Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900">Form Input Surat Masuk</h1>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle"></i>
                    <span>Fields dengan * wajib diisi</span>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-6">
            <form action="{{ route('surat.masuk.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  id="formSuratMasuk"
                  x-data="{ isSubmitting: false }"
                  @submit="isSubmitting = true">
                @csrf

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
                                       value="{{ old('nomor_surat') }}" 
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
                                       value="{{ old('nomor_agenda') }}" 
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
                                           value="{{ old('tanggal_surat') }}" 
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
                                           value="{{ old('tanggal_terima', date('Y-m-d')) }}" 
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
                                       value="{{ old('perihal') }}" 
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
                                          placeholder="Ringkasan singkat isi surat">{{ old('isi_ringkas') }}</textarea>
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
                                       value="{{ old('pengirim') }}" 
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
                                          placeholder="Alamat lengkap pengirim">{{ old('alamat_pengirim') }}</textarea>
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
                                           value="{{ old('telepon_pengirim') }}" 
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
                                           value="{{ old('email_pengirim') }}" 
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
                                                {{ old('klasifikasi_id') == $klasifikasi->id ? 'selected' : '' }}>
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
                                    <option value="biasa" {{ old('tingkat_keamanan', 'biasa') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="rahasia" {{ old('tingkat_keamanan') == 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                                    <option value="sangat_rahasia" {{ old('tingkat_keamanan') == 'sangat_rahasia' ? 'selected' : '' }}>Sangat Rahasia</option>
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
                                    <option value="biasa" {{ old('sifat_surat', 'biasa') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="penting" {{ old('sifat_surat') == 'penting' ? 'selected' : '' }}>Penting</option>
                                    <option value="segera" {{ old('sifat_surat') == 'segera' ? 'selected' : '' }}>Segera</option>
                                    <option value="sangat_segera" {{ old('sifat_surat') == 'sangat_segera' ? 'selected' : '' }}>Sangat Segera</option>
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
                                    <option value="rendah" {{ old('priority') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ old('priority', 'sedang') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ old('priority') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
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
                                       value="{{ old('due_date') }}" 
                                       min="{{ date('Y-m-d') }}">
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
                                       value="{{ old('keywords') }}" 
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
                            <h3 class="text-md font-semibold text-gray-800 mb-4">Upload File Surat</h3>
                            <div class="bg-white rounded-lg border-2 border-dashed border-gray-300 p-4">
                                <div class="text-center">
                                    <div class="mb-4">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">File opsional (PDF, DOC, DOCX, JPG, PNG - Max 5MB)</p>
                                    
                                    <!-- File Upload Area -->
                                    <div id="drag-drop-area" class="min-h-32">
                                        <!-- Uppy will be initialized here -->
                                    </div>
                                    
                                    <input type="hidden" name="uploaded_file_path" id="uploaded_file_path">
                                    
                                    <!-- Upload Instructions -->
                                    <div class="mt-4 text-xs text-gray-500 space-y-1">
                                        <p>• Drag & drop file atau klik untuk browse</p>
                                        <p>• Format yang diizinkan: PDF, DOC, DOCX, JPG, PNG</p>
                                        <p>• Ukuran maksimal: 5MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
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
                            Simpan Surat
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
<!-- Uppy CSS & JS -->
<link href="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.css" rel="stylesheet">
<script src="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Uppy
    const uppy = new Uppy.Uppy({
        restrictions: {
            maxNumberOfFiles: 1,
            maxFileSize: 5 * 1024 * 1024, // 5MB
            allowedFileTypes: ['.pdf', '.doc', '.docx', '.jpg', '.jpeg', '.png']
        },
        autoProceed: false,
    });

    // Use Dashboard plugin
    uppy.use(Uppy.Dashboard, {
        inline: true,
        target: '#drag-drop-area',
        showProgressDetails: true,
        proudlyDisplayPoweredByUppy: false,
        height: 180,
        theme: 'light',
        note: 'File maksimal 5MB',
        locale: {
            strings: {
                dropPasteFiles: 'Drop file di sini atau %{browseFiles}',
                browseFiles: 'pilih file',
                uploadComplete: 'Upload selesai',
                uploadFailed: 'Upload gagal',
                noFilesFound: 'Tidak ada file yang dipilih',
                uploading: 'Mengupload...',
                complete: 'Selesai'
            }
        }
    });

    // Use XHR Upload plugin
    uppy.use(Uppy.XHRUpload, {
        endpoint: '{{ route("upload") }}',
        fieldName: 'file',
        formData: true,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // Handle upload success
    uppy.on('upload-success', (file, response) => {
        console.log('Upload success:', response);
        if (response.body && response.body.file_path) {
            document.getElementById('uploaded_file_path').value = response.body.file_path;
            showNotification('File berhasil diupload!', 'success');
        }
    });

    // Handle file removal
    uppy.on('file-removed', () => {
        document.getElementById('uploaded_file_path').value = '';
    });

    // Handle upload error
    uppy.on('upload-error', (file, error, response) => {
        console.error('Upload error:', error);
        showNotification('Gagal mengupload file. Silakan coba lagi.', 'error');
    });

    // Form validation
    const form = document.getElementById('formSuratMasuk');
    form.addEventListener('submit', function(e) {
        // Additional validation can be added here
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

    // Auto-set tanggal terima to today if not set
    const tanggalTerima = document.getElementById('tanggal_terima');
    if (!tanggalTerima.value) {
        tanggalTerima.value = new Date().toISOString().split('T')[0];
    }
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