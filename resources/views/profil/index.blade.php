@extends('layouts.main')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb & Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="page-title">Profil Saya</h4>
                <a href="{{ route('profil.edit') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    {{-- Profil Card --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . ($user->foto ?? 'default.png')) }}" alt="Avatar" class="rounded-circle img-thumbnail" width="120">
                    <h5 class="mt-3">{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                    <p class="text-muted">{{ $user->role }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="fas fa-phone"></i> {{ $user->telepon ?? '-' }}
                    </li>
                    <li class="list-group-item">
                        <i class="fas fa-calendar-alt"></i> {{ $user->tanggal_lahir ?? '-' }}
                    </li>
                </ul>
            </div>

            {{-- Preferensi Akun --}}
            <div class="card mt-3">
                <div class="card-header"><h6 class="mb-0">Preferensi</h6></div>
                <div class="card-body">
                    <p><strong>Notifikasi:</strong> Aktif</p>
                    <p><strong>Mode Tema:</strong> Default (Terang)</p>
                    <a href="#" class="btn btn-sm btn-secondary">Ubah Preferensi</a>
                </div>
            </div>
        </div>

        {{-- Detail dan Aktivitas --}}
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">Statistik Aktivitas</h6></div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <p><strong>Surat Masuk:</strong> {{ $totalSuratMasuk }}</p>
                        <p><strong>Surat Keluar:</strong> {{ $totalSuratKeluar }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Disposisi:</strong> {{ $totalDisposisi }}</p>
                        <p><strong>Login Terakhir:</strong> {{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Log Aktivitas --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Aktivitas Terakhir</h6>
                    <a href="#" class="btn btn-link btn-sm">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($logs as $log)
                            <li class="list-group-item">
                                <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small><br>
                                {{ $log->description }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Belum ada aktivitas.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
