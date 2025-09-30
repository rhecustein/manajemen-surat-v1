@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Surat Masuk</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item active">Surat Masuk</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{-- NOTIFIKASI FLOATING --}}
    @if (session('success') || session('deleted') || session('arsip'))
        <div class="alert 
            @if (session('success')) alert-success 
            @elseif (session('deleted')) alert-danger 
            @elseif (session('arsip')) alert-warning 
            @endif 
            d-flex align-items-center shadow-lg top-3 end-3 mt-3 me-3 p-3 rounded-3 animate__animated animate__fadeInDown" 
            style="z-index: 1050; min-width: 300px;" 
            role="alert">

            <div class="flex-shrink-0 me-2">
                <div class="
                    d-flex justify-content-center align-items-center rounded-circle
                    @if (session('success')) bg-success 
                    @elseif (session('deleted')) bg-danger 
                    @elseif (session('arsip')) bg-warning 
                    @endif" 
                    style="width: 36px; height: 36px;">
                    <i class="
                        @if (session('success')) fas fa-check 
                        @elseif (session('deleted')) fas fa-trash 
                        @elseif (session('arsip')) fas fa-archive 
                        @endif 
                        text-white"></i>
                </div>
            </div>

            <div class="flex-grow-1">
                <h6 class="mb-1 fw-semibold">
                    @if (session('success')) Berhasil! 
                    @elseif (session('deleted')) Dihapus! 
                    @elseif (session('arsip')) Diarsipkan! 
                    @endif
                </h6>
                <p class="mb-0 small">
                    {{ session('success') ?? session('deleted') ?? session('arsip') }}
                </p>
            </div>

            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- Summary Cards --}}
    <div class="row justify-content-center mt-3">
        <div class="col-md-4">
            <div class="card bg-corner-img">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase mb-1 fs-13">Semua Surat Masuk</p>
                            <h4 class="mb-0">{{ $totalSuratMasuk ?? 0 }}</h4>
                        </div>
                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center">
                            <i class="iconoir-mail fs-20 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-corner-img">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase mb-1 fs-13">Belum Dibaca</p>
                            <h4 class="mb-0">{{ $totalSuratBelumDibaca ?? 0 }}</h4>
                        </div>
                        <div class="avatar-sm bg-warning rounded-circle d-flex align-items-center justify-content-center">
                            <i class="iconoir-eye-off fs-20 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah Surat --}}
    <div class="row justify-content-end mb-3">
        <div class="col-auto">
            <a href="{{ route('surat.masuk.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Masuk
            </a>
        </div>
    </div>

    {{-- Tabel Surat Masuk --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Surat Masuk</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Surat</th>
                                    <th>Pengirim</th>
                                    <th>Perihal</th>
                                    <th>Tanggal Surat</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suratMasuk as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td>{{ $item->pengirim }}</td>
                                        <td>{{ $item->perihal }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>
                                        <td>
                                            @if($item->file)
                                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn-sm btn-info">
                                                    Lihat File
                                                </a>
                                            @else
                                                <span class="badge bg-secondary">Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status_baca == 'belum')
                                                <span class="badge bg-warning">Belum Dibaca</span>
                                            @else
                                                <span class="badge bg-success">Sudah Dibaca</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('surat.masuk.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                            <form action="{{ route('surat.masuk.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin hapus surat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>

                                            <form action="{{ route('surat.masuk.arsip', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin arsipkan surat ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-secondary">Arsip</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="alert alert-danger shadow-sm border-theme-white-2 text-center" role="alert">
                                                <div class="d-inline-flex justify-content-center align-items-center thumb-xs bg-danger rounded-circle mx-auto me-1">
                                                    <i class="fas fa-xmark align-self-center mb-0 text-white"></i>
                                                </div>
                                                <strong>Oops!</strong> Belum ada surat masuk yang tersedia.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>    
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $suratMasuk->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
