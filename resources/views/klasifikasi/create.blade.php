@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title & Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Tambah Klasifikasi</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('klasifikasi.index') }}">Klasifikasi Surat</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Tambah Klasifikasi --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title mb-0">Form Tambah Klasifikasi</h4>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('klasifikasi.store') }}" method="POST" id="formKlasifikasi">
                        @csrf

                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode Klasifikasi</label>
                            <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror"
                                   value="{{ old('kode') }}" placeholder="Masukkan kode" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_klasifikasi" class="form-label">Nama Klasifikasi</label>
                            <input type="text" name="nama_klasifikasi" id="nama_klasifikasi" class="form-control @error('nama_klasifikasi') is-invalid @enderror"
                                   value="{{ old('nama_klasifikasi') }}" placeholder="Masukkan nama klasifikasi" required>
                            @error('nama_klasifikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('klasifikasi.index') }}" class="btn btn-secondary">Batal</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
