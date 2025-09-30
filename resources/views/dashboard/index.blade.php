@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Title and Breadcrumb --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Dashboard</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Manajemen Surat</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row justify-content-center mt-3">
        <div class="col-md-3">
            <div class="card bg-corner-img">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1 fs-13">Surat Masuk</p>
                        <h4 class="mb-0">{{ $totalSuratMasuk ?? 0 }}</h4>
                    </div>
                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center">
                        <i class="iconoir-mail fs-20 text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-corner-img">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1 fs-13">Surat Keluar</p>
                        <h4 class="mb-0">{{ $totalSuratKeluar ?? 0 }}</h4>
                    </div>
                    <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="iconoir-send-mail fs-20 text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-corner-img">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1 fs-13">Surat Belum Dibaca</p>
                        <h4 class="mb-0">{{ $totalSuratBelumDibaca ?? 0 }}</h4>
                    </div>
                    <div class="avatar-sm bg-warning rounded-circle d-flex align-items-center justify-content-center">
                        <i class="iconoir-bookmark fs-20 text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-corner-img">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1 fs-13">Total Kontak</p>
                        <h4 class="mb-0">{{ $totalKontak ?? 0 }}</h4>
                    </div>
                    <div class="avatar-sm bg-info rounded-circle d-flex align-items-center justify-content-center">
                        <i class="iconoir-user fs-20 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Surat Masuk & Keluar --}}
    <div class="row mt-4">
        {{-- Grafik Bar --}}
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Grafik Surat Masuk & Keluar (Tahun Ini)</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="chartSurat" style="height:300px; width:100%;"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Donut --}}
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Status Surat Masuk</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="donutStatusSurat" style="height:300px; width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart Surat Masuk & Keluar
    const ctxBar = document.getElementById('chartSurat').getContext('2d');
    const chartSurat = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulan ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!},
            datasets: [
                {
                    label: 'Surat Masuk',
                    data: {!! json_encode($dataSuratMasuk ?? []) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                },
                {
                    label: 'Surat Keluar',
                    data: {!! json_encode($dataSuratKeluar ?? []) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Donut Chart Status Surat Masuk
    document.addEventListener('DOMContentLoaded', function () {
        const ctxDonut = document.getElementById('donutStatusSurat').getContext('2d');

        const donutStatus = new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Baru', 'Diproses', 'Selesai'],
                datasets: [{
                    data: {!! json_encode($statusSuratData ?? [0,0,0]) !!},
                    backgroundColor: [
                        '#0d6efd', // Biru
                        '#ffc107', // Kuning
                        '#198754'  // Hijau
                    ],
                    hoverOffset: 4,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#6c757d', // text warna abu-abu
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
