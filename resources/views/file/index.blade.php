@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Manajemen File</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen File</a></li>
                        <li class="breadcrumb-item active">Daftar File</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Upload dan Pencarian --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('file.index') }}">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama file...">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('file.create') }}" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload File Baru
            </a>
        </div>
    </div>

    {{-- Tabel File --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Daftar File</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Tipe</th>
                                    <th>Ukuran</th>
                                    <th>Link File</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($files as $index => $file)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $file->nama_file }}</td>
                                        <td>
                                            {{ $file->tipe }}</td>
                                        </td>
                                        <td>
                                            @if ($file->ukuran)
                                                {{ number_format($file->ukuran / 1024 / 1024, 2) }} MB
                                            @else
                                                <span class="badge bg-danger">File Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('file.destroy', basename($file)) }}" method="POST" onsubmit="return confirm('Yakin mau hapus file ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada file yang diupload.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Optional: Pagination --}}
                    {{-- {{ $files->links() }} --}}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
