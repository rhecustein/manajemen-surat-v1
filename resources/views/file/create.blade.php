@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title dan Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Upload File Baru</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen File</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('file.index') }}">Daftar File</a></li>
                        <li class="breadcrumb-item active">Upload</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Upload --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Form Upload File</h5>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama File --}}
                        <div class="mb-3">
                            <label class="form-label" for="nama_file">Nama File</label>
                            <input type="text" name="nama_file" id="nama_file"
                                   class="form-control @error('nama_file') is-invalid @enderror"
                                   value="{{ old('nama_file') }}" placeholder="Masukkan nama file" required>
                            @error('nama_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- type File --}}
                        <div class="mb-3">
                            <label class="form-label" for="tipe">Tipe File</label>
                            <select name="tipe" id="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                                <option value="">Pilih tipe file</option>
                                {{-- Tipe file berdasarkan tipe, penting, surat, dll --}}
                                <option value="Penting" {{ old('tipe') == 'Penting' ? 'selected' : '' }}>Penting</option>
                                <option value="Surat" {{ old('tipe') == 'Surat' ? 'selected' : '' }}>Surat</option>
                                <option value="Dokumen" {{ old('tipe') == 'Dokumen' ? 'selected' : '' }}>Dokumen</option>
                                <option value="Laporan" {{ old('tipe') == 'Laporan' ? 'selected' : '' }}>Laporan</option>
                                <option value="Lainnya" {{ old('tipe') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('tipe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Upload File --}}
                        <div class="mb-3">
                            <label class="form-label" for="file">File</label>
                            <input type="file" name="file" id="file"
                                   class="form-control @error('file') is-invalid @enderror" required>
                            <small class="text-muted">Maksimal 5MB. Tipe yang didukung: PDF, DOCX, JPG, PNG.</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <a href="{{ route('file.index') }}" class="btn btn-secondary">Batal</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
