@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title dan Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Riwayat Surat</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item active">Riwayat</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="jenis" class="form-label">Jenis Surat</label>
                    <select name="jenis" id="jenis" class="form-select">
                        <option value="">Semua</option>
                        <option value="Masuk" {{ request('jenis') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="Keluar" {{ request('jenis') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="terkirim" {{ request('status') == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="arsip" {{ request('status') == 'arsip' ? 'selected' : '' }}>Arsip</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Perihal / Tujuan / Pengirim</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Riwayat Surat</h5>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Nomor Surat</th>
                            <th>Tujuan / Pengirim</th>
                            <th>Perihal</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><span class="badge bg-{{ $item['jenis'] == 'Masuk' ? 'info' : 'secondary' }}">{{ $item['jenis'] }}</span></td>
                                <td>{{ $item['nomor_surat'] }}</td>
                                <td>{{ $item['asal'] }}</td>
                                <td>{{ $item['perihal'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}</td>
                                <td>
                                    @if ($item['status'] === 'terkirim')
                                        <span class="badge bg-success">Terkirim</span>
                                    @elseif ($item['status'] === 'draft')
                                        <span class="badge bg-warning">Draft</span>
                                    @else
                                        <span class="badge bg-secondary">Arsip</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ $item['link'] }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada riwayat ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
