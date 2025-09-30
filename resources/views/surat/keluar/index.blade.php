@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Surat Keluar</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item active">Surat Keluar</li>
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
                            <p class="text-muted text-uppercase mb-1 fs-13">Semua Surat Keluar</p>
                            <h4 class="mb-0">{{ $totalSuratKeluar ?? 0 }}</h4>
                        </div>
                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center">
                            <i class="iconoir-send-mail fs-20 text-white"></i>
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
                            <p class="text-muted text-uppercase mb-1 fs-13">Belum Dikirim</p>
                            <h4 class="mb-0">{{ $totalSuratBelumDikirim ?? 0 }}</h4>
                        </div>
                        <div class="avatar-sm bg-warning rounded-circle d-flex align-items-center justify-content-center">
                            <i class="iconoir-timer fs-20 text-white"></i>
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
                            <p class="text-muted text-uppercase mb-1 fs-13">Sudah Dikirim</p>
                            <h4 class="mb-0">{{ $totalSuratTerkirim ?? 0 }}</h4>
                        </div>
                        <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center">
                            <i class="iconoir-fast-arrow-right fs-20 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah Surat --}}
    <div class="row justify-content-end mb-3">
        <div class="col-auto">
            <a href="{{ route('surat.keluar.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Keluar
            </a>
        </div>
    </div>

    {{-- Tabel Surat Keluar --}}
    <div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Surat Keluar</h5>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Tujuan</th>
                                <th>Perihal</th>
                                <th>Tanggal Surat</th>
                                <th>Status</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suratKeluar as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nomor_surat }}</td>
                                    <td>{{ $item->tujuan }}</td>
                                    <td>{{ $item->perihal }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>
                                    <td>
                                        @if($item->status_kirim == 'terkirim')
                                            <span class="badge bg-success">Terkirim</span>
                                        @else
                                            <span class="badge bg-warning">Belum Dikirim</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->file)
                                            <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn-sm btn-info">
                                                Lihat
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td class="d-flex gap-1 flex-wrap">

                                        {{-- Edit --}}
                                        <a href="{{ route('surat.keluar.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                        {{-- Delete --}}
                                        <form action="{{ route('surat.keluar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>

                                        {{-- Arsip (gunakan PUT jika route-nya mendukung itu) --}}
                                        <form action="{{ route('surat.keluar.arsip', $item->id) }}" method="POST" onsubmit="return confirm('Arsipkan surat ini?')">
                                            @csrf
                                            @method('PUT') {{-- penting, ubah dari POST menjadi PUT --}}
                                            <button type="submit" class="btn btn-sm btn-secondary">Arsip</button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada surat keluar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $suratKeluar->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
