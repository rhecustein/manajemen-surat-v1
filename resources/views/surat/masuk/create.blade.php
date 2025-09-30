@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Tambah Surat Masuk</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('surat.masuk.index') }}">Surat Masuk</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Tambah Surat Masuk --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title mb-0">Form Input Surat Masuk</h4>
                </div>

                <div class="card-body pt-0">
                <form action="{{ route('surat.masuk.store') }}" method="POST" enctype="multipart/form-data" id="formSuratMasuk">
                    @csrf

                    <div class="row">
                        {{-- Nomor Surat --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nomor_surat">Nomor Surat</label>
                            <input type="text" name="nomor_surat" id="nomor_surat"
                                class="form-control @error('nomor_surat') is-invalid @enderror"
                                value="{{ old('nomor_surat') }}" required>
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pengirim --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="pengirim">Pengirim</label>
                            <input type="text" name="pengirim" id="pengirim"
                                class="form-control @error('pengirim') is-invalid @enderror"
                                value="{{ old('pengirim') }}" required>
                            @error('pengirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Perihal --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="perihal">Perihal</label>
                            <input type="text" name="perihal" id="perihal"
                                class="form-control @error('perihal') is-invalid @enderror"
                                value="{{ old('perihal') }}" required>
                            @error('perihal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Surat --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tanggal_surat">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" id="tanggal_surat"
                                class="form-control @error('tanggal_surat') is-invalid @enderror"
                                value="{{ old('tanggal_surat') }}" required>
                            @error('tanggal_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pilih Klasifikasi --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="klasifikasi_id">Klasifikasi Surat</label>
                            <select name="klasifikasi_id" id="klasifikasi_id" class="form-select @error('klasifikasi_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Klasifikasi --</option>
                                @foreach($klasifikasis as $klasifikasi)
                                    <option value="{{ $klasifikasi->id }}" {{ old('klasifikasi_id') == $klasifikasi->id ? 'selected' : '' }}>
                                        {{ $klasifikasi->nama_klasifikasi }} - {{ $klasifikasi->kode }}
                                    </option>
                                @endforeach
                            </select>
                            @error('klasifikasi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload File --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">File Upload (Opsional)</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div id="drag-drop-area" style="height: 300px; padding: 10px;"></div> <!-- ganti id -->
                                    <input type="hidden" name="uploaded_file_path" id="uploaded_file_path">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan Surat</button>
                        <a href="{{ route('surat.masuk.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Tambah Surat Masuk</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('surat.masuk.index') }}">Surat Masuk</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Tambah Surat Masuk --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title mb-0">Form Input Surat Masuk</h4>
                </div>

                <div class="card-body pt-0">
                <form action="{{ route('surat.masuk.store') }}" method="POST" enctype="multipart/form-data" id="formSuratMasuk">
                    @csrf

                    <div class="row">
                        {{-- Nomor Surat --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nomor_surat">Nomor Surat</label>
                            <input type="text" name="nomor_surat" id="nomor_surat"
                                class="form-control @error('nomor_surat') is-invalid @enderror"
                                value="{{ old('nomor_surat') }}" required>
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pengirim --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="pengirim">Pengirim</label>
                            <input type="text" name="pengirim" id="pengirim"
                                class="form-control @error('pengirim') is-invalid @enderror"
                                value="{{ old('pengirim') }}" required>
                            @error('pengirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Perihal --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="perihal">Perihal</label>
                            <input type="text" name="perihal" id="perihal"
                                class="form-control @error('perihal') is-invalid @enderror"
                                value="{{ old('perihal') }}" required>
                            @error('perihal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Surat --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tanggal_surat">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" id="tanggal_surat"
                                class="form-control @error('tanggal_surat') is-invalid @enderror"
                                value="{{ old('tanggal_surat') }}" required>
                            @error('tanggal_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pilih Klasifikasi --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="klasifikasi_id">Klasifikasi Surat</label>
                            <select name="klasifikasi_id" id="klasifikasi_id" class="form-select @error('klasifikasi_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Klasifikasi --</option>
                                @foreach($klasifikasis as $klasifikasi)
                                    <option value="{{ $klasifikasi->id }}" {{ old('klasifikasi_id') == $klasifikasi->id ? 'selected' : '' }}>
                                        {{ $klasifikasi->nama_klasifikasi }} - {{ $klasifikasi->kode }}
                                    </option>
                                @endforeach
                            </select>
                            @error('klasifikasi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    

                        {{-- Upload File --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">File Upload (Opsional)</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div id="drag-drop-area" style="height: 300px; padding: 10px;"></div> <!-- ganti id -->
                                    <input type="hidden" name="uploaded_file_path" id="uploaded_file_path">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan Surat</button>
                        <a href="{{ route('surat.masuk.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
 document.addEventListener('DOMContentLoaded', function () {
    var uppy = new Uppy.Uppy({
        restrictions: {
            maxNumberOfFiles: 1,
            maxFileSize: 5 * 1024 * 1024, 
            allowedFileTypes: ['.pdf', '.doc', '.docx', '.jpg', '.jpeg', '.png']
        },
        autoProceed: true,
    });

    uppy.use(Uppy.Dashboard, {
        inline: true,
        target: '#drag-drop-area',
        showProgressDetails: true,
        proudlyDisplayPoweredByUppy: false,
    });

    uppy.use(Uppy.XHRUpload, {
        endpoint: '{{ route("upload") }}', // atau "/upload" kalau sudah buat
        fieldName: 'file',
        formData: true,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    uppy.on('upload-success', (file, response) => {
        console.log('Upload success:', response);
        document.getElementById('uploaded_file_path').value = response.body.file_path;
    });

    uppy.on('file-removed', () => {
        document.getElementById('uploaded_file_path').value = '';
    });
});

uppy.on('upload-success', (file, response) => {
    if (response.body && response.body.file_path) {
        document.getElementById('uploaded_file_path').value = response.body.file_path;
    }
});


</script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Klasifikasi Surat",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection



