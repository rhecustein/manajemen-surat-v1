@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-between align-items-center">
                <h4 class="page-title">Log Aktivitas</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Log Aktivitas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="row mb-3">
        <div class="col-12">
            <form method="GET" action="{{ route('log.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Cari User atau Aktivitas</label>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Ketik nama user atau aktivitas">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100" type="submit"><i class="fas fa-search me-1"></i> Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Log --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Aktivitas</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Aktivitas</th>
                                    <th>IP Address</th>
                                    <th>Browser</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $index => $log)
                                    <tr>
                                        <td>{{ ($logs->firstItem() ?? 0) + $index }}</td>
                                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}</td>
                                        <td>{{ $log->user->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge 
                                                @if(str_contains(strtolower($log->aktivitas), 'login')) bg-success 
                                                @elseif(str_contains(strtolower($log->aktivitas), 'logout')) bg-danger 
                                                @elseif(str_contains(strtolower($log->aktivitas), 'edit')) bg-info 
                                                @else bg-secondary @endif">
                                                {{ $log->aktivitas }}
                                            </span>
                                        </td>
                                        <td>{{ $log->ip_address }}</td>
                                        <td class="text-truncate" style="max-width: 180px;">{{ $log->user_agent }}</td>
                                        <td>
                                            @can('delete', $log)
                                            <form action="{{ route('log.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Yakin hapus log ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3">Tidak ada data aktivitas ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    {{ $logs->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
