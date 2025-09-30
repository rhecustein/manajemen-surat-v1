@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title dan Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Arsip Surat</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item active">Arsip</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Jenis Surat</label>
                    <select name="jenis" class="form-select">
                        <option value="">Semua</option>
                        <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cari Perihal / Pengirim / Tujuan</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Arsip --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Surat Terarsip</h5>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Nomor Surat</th>
                            <th>Pengirim / Tujuan</th>
                            <th>Perihal</th>
                            <th>Tanggal Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($arsips as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <span class="badge bg-{{ $item['jenis'] == 'Masuk' ? 'info' : 'secondary' }}">{{ $item['jenis'] }}</span>
                                </td>
                                <td>{{ $item['nomor_surat'] }}</td>
                                <td>{{ $item['asal'] }}</td>
                                <td>{{ $item['perihal'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ $item['link'] }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                                    <form action="{{ route('surat.arsip.restore', [$item['jenis_slug'], $item['id']]) }}" method="POST" onsubmit="return confirm('Kembalikan surat ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success">Kembalikan</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada surat dalam arsip.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $arsips instanceof \Illuminate\Pagination\LengthAwarePaginator ? $arsips->links('pagination::bootstrap-5') : '' }}
            </div>
        </div>
    </div>
</div>
@endsection
