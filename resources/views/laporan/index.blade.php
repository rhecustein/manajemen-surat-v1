@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Laporan Surat</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-muted mb-1">Total Surat Masuk</p>
                    <h4>{{ $totalMasuk ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-muted mb-1">Total Surat Keluar</p>
                    <h4>{{ $totalKeluar ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>


    {{-- Tabel Laporan Surat --}}
    <div class="card-body">
    {{-- Header: Title & Export Buttons --}}
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h5>Data Surat</h5>
        <div>
            <a href="{{ route('laporan.export', 'excel') }}" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export Excel</a>
            <a href="{{ route('laporan.export', 'pdf') }}" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
        </div>
    </div>

    {{-- Search Form --}}
    <div class="card mb-4">
    <div class="card-body">
    <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
    <div class="row g-3 align-items-end">
        {{-- Cari Nomor Surat atau Perihal --}}
        <div class="col-md-3">
            <label class="form-label">Cari Surat</label>
            <input type="text" name="search" class="form-control" placeholder="Nomor surat atau perihal..." value="{{ request('search') }}">
        </div>

        {{-- Jenis Surat --}}
        <div class="col-md-2">
            <label class="form-label">Jenis Surat</label>
            <select name="jenis" class="form-select">
                <option value="">Semua</option>
                <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
        </div>

        {{-- Status Surat --}}
        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua</option>
                <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        {{-- Tanggal Awal --}}
        <div class="col-md-2">
            <label class="form-label">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
        </div>

        {{-- Tanggal Akhir --}}
        <div class="col-md-2">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
        </div>

        {{-- Tombol Search --}}
        <div class="col-md-1 d-grid">
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
        </div>
    </div>
</form>

    {{-- Tabel Data Surat --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Klasifikasi</th>
                    <th>Jenis Surat</th>
                    <th>Pengirim/Penerima</th>
                    <th>Perihal</th>
                    <th>Tanggal Surat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $index => $laporan)
                    <tr>
                        <td>{{ $laporans->firstItem() + $index }}</td>
                        <td>{{ $laporan->nomor_surat }}</td>
                        <td>{{ $laporan->klasifikasi->nama_klasifikasi ?? '-' }}</td>
                        <td>{{ $laporan->jenis_surat }}</td>
                        <td>{{ $laporan->pengirim_penerima }}</td>
                        <td>{{ $laporan->perihal }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal_surat)->format('d M Y') }}</td>
                        <td><span class="badge bg-primary">{{ ucfirst($laporan->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $laporans->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
    </div>
    </div>
</div>

</div>
@endsection
