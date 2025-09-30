@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title dan Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Tambah Surat Keluar</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('surat.keluar.index') }}">Surat Keluar</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Surat Keluar Baru</h4>
                </div>
                <div class="card-body pt-0">

                    {{-- Flash Message & Error --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.keluar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- No Surat --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                    <input type="text" name="nomor_surat" id="nomor_surat" class="form-control"
                                           value="{{ old('nomor_surat') }}" required>
                                </div>
                            </div>

                            {{-- Tanggal_surat Surat --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                                    <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control"
                                           value="{{ old('tanggal_surat') }}" required>
                                </div>
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

                            {{-- Tujuan --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="tujuan" class="form-label">Tujuan</label>
                                    <input type="text" name="tujuan" id="tujuan" class="form-control"
                                           value="{{ old('tujuan') }}" required>
                                </div>
                            </div>

                            {{-- Perihal --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="perihal" class="form-label">Perihal</label>
                                    <input type="text" name="perihal" id="perihal" class="form-control"
                                           value="{{ old('perihal') }}" required>
                                </div>
                            </div>

                            {{-- Upload File --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Upload File Surat (PDF/DOC)</label>
                                    <div id="drag-drop-area" style="height: 300px; padding: 10px;"></div>
                                    <input type="hidden" name="uploaded_file_path" id="uploaded_file_path">
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('surat.keluar.index') }}" class="btn btn-secondary">Batal</a>
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
    const uppy = new Uppy.Uppy({
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
        endpoint: '{{ route("upload") }}',
        fieldName: 'file',
        formData: true,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    uppy.on('upload-success', (file, response) => {
        if (response.body && response.body.file_path) {
            document.getElementById('uploaded_file_path').value = response.body.file_path;
        }
    });

    uppy.on('file-removed', () => {
        document.getElementById('uploaded_file_path').value = '';
    });
});
</script>
@endsection
