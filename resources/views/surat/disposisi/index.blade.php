@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title dan Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Disposisi Surat Masuk</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item active">Disposisi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Disposisi --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Ditindaklanjuti</option>
                        <option value="ditindaklanjuti" {{ request('status') == 'ditindaklanjuti' ? 'selected' : '' }}>Sudah Ditindaklanjuti</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <label for="search" class="form-label">Cari Perihal / Tujuan</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('surat.disposisi.create') }}" class="btn btn-success w-100">+ Tambah</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Disposisi --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Disposisi</h5>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th>Tujuan</th>
                            <th>Tanggal Disposisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($disposisis as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->suratMasuk->nomor_surat }}</td>
                                <td>{{ $item->suratMasuk->pengirim }}</td>
                                <td>{{ $item->suratMasuk->perihal }}</td>
                                <td>{{ $item->kepada }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_disposisi)->format('d M Y') }}</td>
                                <td>
                                    @if ($item->status == 'belum')
                                        <span class="badge bg-warning">Belum Ditindaklanjuti</span>
                                    @elseif ($item->status == 'ditindaklanjuti')
                                        <span class="badge bg-primary">Ditindaklanjuti</span>
                                    @else
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('surat.disposisi.show', $item->id) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data disposisi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $disposisis->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

</div>
@endsection
