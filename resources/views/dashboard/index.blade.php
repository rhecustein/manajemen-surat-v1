@extends('layouts.main')

@section('title', 'Dashboard - Sistem KP Manajemen Surat')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 w-4 h-4 mx-1"></i>
            <span class="ml-1 text-sm font-medium text-gray-500">Dashboard</span>
        </div>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg text-white p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Selamat datang, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100 mb-1">Anda berada di dashboard sistem manajemen surat PT RIFIA SEN TOSA</p>
                <small class="text-blue-200">Kerja Praktek - Program Studi Informatika UBHARA</small>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chart-line text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Surat Masuk -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Surat Masuk</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalSuratMasuk ?? 0) }}</h3>
                    <div class="flex items-center text-sm text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>Data tersedia</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Surat Keluar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Surat Keluar</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalSuratKeluar ?? 0) }}</h3>
                    <div class="flex items-center text-sm text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>Data tersedia</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-paper-plane text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Surat Belum Dibaca -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Surat Belum Dibaca</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalSuratBelumDibaca ?? 0) }}</h3>
                    @if(($totalSuratBelumDibaca ?? 0) > 0)
                        <div class="flex items-center text-sm text-yellow-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <span>Perlu Perhatian</span>
                        </div>
                    @else
                        <div class="flex items-center text-sm text-green-600">
                            <i class="fas fa-check mr-1"></i>
                            <span>Semua Terbaca</span>
                        </div>
                    @endif
                </div>
                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-eye-slash text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Kontak -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Total Kontak</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalKontak ?? 0) }}</h3>
                    <div class="flex items-center text-sm text-blue-600">
                        <i class="fas fa-user mr-1"></i>
                        <span>Terdaftar</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Bar Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Grafik Surat Masuk & Keluar ({{ $currentYear ?? date('Y') }})
                    </h2>
                    <div class="flex items-center space-x-2">
                        <button onclick="refreshChart()" 
                                class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <select id="yearSelector" onchange="updateChart()" 
                                class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}" {{ $i == ($currentYear ?? date('Y')) ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="relative" style="height: 300px;">
                    <canvas id="chartSurat"></canvas>
                </div>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Status Surat Masuk</h2>
            </div>
            <div class="p-6">
                <div class="relative" style="height: 250px;">
                    <canvas id="donutStatusSurat"></canvas>
                </div>
            </div>
            <!-- Status Legend -->
            <div class="p-6 border-t border-gray-200">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="text-2xl font-bold text-blue-600">{{ $totalSuratBelumDibaca ?? 0 }}</div>
                        <div class="text-xs text-gray-500">Baru</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="text-2xl font-bold text-yellow-600">{{ $totalSuratDiproses ?? 0 }}</div>
                        <div class="text-xs text-gray-500">Diproses</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="text-2xl font-bold text-green-600">{{ $totalSuratSelesai ?? 0 }}</div>
                        <div class="text-xs text-gray-500">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h2>
                    <a href="{{ route('surat.masuk.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-500 font-medium flex items-center">
                        Lihat Semua 
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if(isset($aktivitasTerbaru) && $aktivitasTerbaru->count() > 0)
                    <div class="space-y-4">
                        @foreach($aktivitasTerbaru as $aktivitas)
                            <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="{{ $aktivitas->icon ?? 'fas fa-envelope' }} text-blue-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">
                                        {{ $aktivitas->title ?? 'Aktivitas Surat' }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-2">
                                        {{ Str::limit($aktivitas->description ?? 'Deskripsi aktivitas', 80) }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-400 flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ isset($aktivitas->time) ? $aktivitas->time->diffForHumans() : 'Baru saja' }}
                                        </span>
                                        <a href="{{ $aktivitas->url ?? '#' }}" 
                                           class="text-xs text-blue-600 hover:text-blue-500 font-medium">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada aktivitas terbaru</h3>
                        <p class="text-sm text-gray-500 mb-6">Aktivitas akan muncul setelah ada surat masuk atau keluar</p>
                        <a href="{{ route('surat.masuk.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Surat Masuk
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Aksi Cepat</h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="{{ route('surat.masuk.create') }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Surat Masuk
                    </a>
                    <a href="{{ route('surat.keluar.create') }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Buat Surat Keluar
                    </a>
                    <a href="{{ route('kontak.create') }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>
                        Tambah Kontak
                    </a>
                    <a href="{{ route('laporan.index') }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-yellow-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-600 transition-colors">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Lihat Laporan
                    </a>
                </div>
            </div>
            
            <!-- System Info -->
            <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    Informasi Sistem
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Versi:</span>
                        <span class="font-medium text-gray-900">v1.0.0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Update:</span>
                        <span class="font-medium text-gray-900">{{ now()->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status:</span>
                        <span class="font-medium text-green-600 flex items-center">
                            <i class="fas fa-circle text-xs mr-1"></i>
                            Online
                        </span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200 text-center">
                    <span class="text-xs text-gray-500">Kerja Praktek UBHARA 2024</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartSurat;
        let donutStatus;
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        function initializeCharts() {
            // Bar Chart Surat Masuk & Keluar
            const ctxBar = document.getElementById('chartSurat');
            if (ctxBar) {
                chartSurat = new Chart(ctxBar.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($bulanLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!},
                        datasets: [
                            {
                                label: 'Surat Masuk',
                                data: {!! json_encode($dataSuratMasuk ?? array_fill(0, 12, 0)) !!},
                                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1,
                                borderRadius: 6,
                                borderSkipped: false,
                            },
                            {
                                label: 'Surat Keluar',
                                data: {!! json_encode($dataSuratKeluar ?? array_fill(0, 12, 0)) !!},
                                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                                borderColor: 'rgba(34, 197, 94, 1)',
                                borderWidth: 1,
                                borderRadius: 6,
                                borderSkipped: false,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                titleColor: 'white',
                                bodyColor: 'white',
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            }

            // Donut Chart Status Surat Masuk
            const ctxDonut = document.getElementById('donutStatusSurat');
            if (ctxDonut) {
                donutStatus = new Chart(ctxDonut.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Baru', 'Diproses', 'Selesai'],
                        datasets: [{
                            data: {!! json_encode($statusSuratData ?? [0,0,0]) !!},
                            backgroundColor: [
                                '#3b82f6', // Blue
                                '#eab308', // Yellow
                                '#22c55e'  // Green
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                titleColor: 'white',
                                bodyColor: 'white',
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                                        return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        },
                        cutout: '60%',
                        animation: {
                            duration: 1500,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            }
        }

        function updateChart() {
            const year = document.getElementById('yearSelector').value;
            
            fetch(`/dashboard/chart-data?year=${year}`)
                .then(response => response.json())
                .then(data => {
                    if (chartSurat) {
                        chartSurat.data.datasets[0].data = data.surat_masuk;
                        chartSurat.data.datasets[1].data = data.surat_keluar;
                        chartSurat.update();
                    }
                })
                .catch(error => {
                    console.error('Error updating chart:', error);
                });
        }

        function refreshChart() {
            if (chartSurat) chartSurat.update();
            if (donutStatus) donutStatus.update();
        }
    </script>
@endpush
@endsection