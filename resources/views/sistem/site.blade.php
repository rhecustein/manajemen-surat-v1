@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Pengaturan Website</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                        <li class="breadcrumb-item active">Website</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Setting --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sistem.site.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h5 class="mb-4">Informasi Umum</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Website</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $setting->nama ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slogan</label>
                                <input type="text" name="slogan" class="form-control" value="{{ old('slogan', $setting->slogan ?? '') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Deskripsi Website</label>
                                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $setting->deskripsi ?? '') }}</textarea>
                            </div>
                        </div>

                        <h5 class="mb-4 mt-5">Logo & Favicon</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Logo Website</label>
                                <input type="file" name="logo" class="form-control">
                                @if(isset($setting->logo))
                                    <img src="{{ asset('storage/' . $setting->logo) }}" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Favicon</label>
                                <input type="file" name="favicon" class="form-control">
                                @if(isset($setting->favicon))
                                    <img src="{{ asset('storage/' . $setting->favicon) }}" class="img-thumbnail mt-2" width="64">
                                @endif
                            </div>
                        </div>

                        <h5 class="mb-4 mt-5">SMTP Email Setting</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Host</label>
                                <input type="text" name="smtp_host" class="form-control" value="{{ old('smtp_host', $setting->smtp_host ?? '') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">SMTP Port</label>
                                <input type="number" name="smtp_port" class="form-control" value="{{ old('smtp_port', $setting->smtp_port ?? '') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Security</label>
                                <select name="smtp_security" class="form-select">
                                    <option value="" {{ (old('smtp_security', $setting->smtp_security ?? '') == '') ? 'selected' : '' }}>None</option>
                                    <option value="ssl" {{ (old('smtp_security', $setting->smtp_security ?? '') == 'ssl') ? 'selected' : '' }}>SSL</option>
                                    <option value="tls" {{ (old('smtp_security', $setting->smtp_security ?? '') == 'tls') ? 'selected' : '' }}>TLS</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Username</label>
                                <input type="text" name="smtp_username" class="form-control" value="{{ old('smtp_username', $setting->smtp_username ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Password</label>
                                <input type="password" name="smtp_password" class="form-control" value="{{ old('smtp_password', $setting->smtp_password ?? '') }}">
                            </div>
                        </div>

                        <h5 class="mb-4 mt-5">Maintenance Mode</h5>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" {{ old('maintenance_mode', $setting->maintenance_mode ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="maintenance_mode">Aktifkan Mode Maintenance</label>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
