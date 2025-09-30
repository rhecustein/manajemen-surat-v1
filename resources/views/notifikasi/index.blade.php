@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="page-title">🔔 Pengaturan Sistem Notifikasi</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                    <li class="breadcrumb-item active">Notifikasi</li>
                </ol>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">

                    @if($setting)
                    <form action="{{ route('notification-settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-4">Metode Notifikasi</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="email" class="form-check-input" id="email" {{ $setting->email ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="web_push" class="form-check-input" id="web_push" {{ $setting->web_push ? 'checked' : '' }}>
                                    <label class="form-check-label" for="web_push">Web Push Notification</label>
                                </div>
                            </div>
                        </div>

                        <h5 class="mb-4">Trigger Notifikasi</h5>
                        <div class="row mb-3">
                            @php
                                $triggers = [
                                    'surat_masuk' => 'Saat surat masuk baru diterima',
                                    'disposisi' => 'Saat disposisi dibuat',
                                    'status_berubah' => 'Saat status surat berubah',
                                    'user_baru' => 'Saat user baru ditambahkan',
                                ];
                            @endphp
                            @foreach($triggers as $key => $label)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="triggers[]" value="{{ $key }}" class="form-check-input"
                                               id="trigger_{{ $key }}" {{ in_array($key, $setting->triggers ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="trigger_{{ $key }}">{{ $label }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <h5 class="mb-4">Kontak & Webhook</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email_default" class="form-label">Email Default Penerima</label>
                                <input type="email" id="email_default" name="email_default" class="form-control" value="{{ $setting->email_default }}">
                            </div>
                            <div class="col-md-6">
                                <label for="webhook_url" class="form-label">Webhook Push Notification</label>
                                <input type="url" id="webhook_url" name="webhook_url" class="form-control" value="{{ $setting->webhook_url }}">
                            </div>
                        </div>

                        <h5 class="mb-4">Frekuensi Notifikasi</h5>
                        <div class="row mb-4">
                            @foreach(['realtime' => 'Real-time', 'daily' => 'Harian', 'weekly' => 'Mingguan'] as $key => $label)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="radio" name="frequency" value="{{ $key }}" class="form-check-input"
                                               id="freq_{{ $key }}" {{ $setting->frequency === $key ? 'checked' : '' }}>
                                        <label class="form-check-label" for="freq_{{ $key }}">{{ $label }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                📂 Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                    @else
                        <div class="text-danger">⚠️ Data pengaturan tidak ditemukan.</div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
