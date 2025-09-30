@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Kontak</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item active">Kontak</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Button Tambah --}}
    <div class="row mb-3">
        <div class="col-12 text-end">
            <a href="{{ route('kontak.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kontak
            </a>
        </div>
    </div>
    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('deleted'))
        <div class="alert alert-danger">{{ session('deleted') }}</div>
    @endif
    
    {{-- Table Kontak --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Instansi</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kontaks as $kontak)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kontak->nama }}</td>
                                    <td>{{ $kontak->email ?? '-' }}</td>
                                    <td>{{ $kontak->telepon ?? '-' }}</td>
                                    <td>{{ $kontak->instansi ?? '-' }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($kontak->tipe == 'client') bg-primary
                                            @elseif($kontak->tipe == 'rekanan') bg-success
                                            @else bg-warning
                                            @endif">
                                            {{ ucfirst($kontak->tipe) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('kontak.edit', $kontak->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('kontak.destroy', $kontak->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kontak ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data kontak.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $kontaks->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
