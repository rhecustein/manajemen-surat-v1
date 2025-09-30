@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title dan Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Edit Surat Keluar</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('surat.keluar.index') }}">Surat Keluar</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Edit --}}
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Surat Keluar</h4>
                </div>
                <div class="card-body pt-0">
                        <form action="{{ route('surat.keluar.update', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- Nomor Surat --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="nomor_surat">Nomor Surat</label>
                                    <input type="text" name="nomor_surat" id="nomor_surat" class="form-control"
                                           value="{{ old('nomor_surat', $suratKeluar->nomor_surat) }}" required>
                                </div>
                            </div>

                            {{-- tanggal_surat Surat --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="tanggal_surat">tanggal_surat Surat</label>
                                    <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control"
                                           value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat) }}" required>
                                </div>
                            </div>

                            {{-- Tujuan Surat --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="tujuan">Tujuan Surat</label>
                                    <input type="text" name="tujuan" id="tujuan" class="form-control"
                                           value="{{ old('tujuan', $suratKeluar->tujuan) }}" required>
                                </div>
                            </div>

                            {{-- Perihal --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="perihal">Perihal</label>
                                    <input type="text" name="perihal" id="perihal" class="form-control"
                                           value="{{ old('perihal', $suratKeluar->perihal) }}" required>
                                </div>
                            </div>

                            {{-- Path File --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="file">Path Surat</label>
                                    <input type="text" name="file" id="file" class="form-control"
                                           value="{{ old('file', $suratKeluar->file) }}" readonly>
                                    @if ($suratKeluar->file)
                                        <small class="d-block mt-2">
                                            File saat ini:
                                            <a href="{{ asset('storage/surat_keluar/' . $suratKeluar->file) }}" target="_blank" class="text-primary">Lihat File</a>
                                        </small>
                                    @endif
                                </div>
                            </div>

                            {{-- Upload File Baru --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Upload File Baru (Opsional)</label>
                                    <div id="drag-drop-area" style="height: 300px; padding: 10px;"></div>
                                    <input type="hidden" name="uploaded_file_path" id="uploaded_file_path">
                                </div>
                            </div>

                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
            document.getElementById('file').value = response.body.file_path;
        }
    });

    uppy.on('file-removed', () => {
        document.getElementById('uploaded_file_path').value = '';
    });
});
</script>
@endsection
