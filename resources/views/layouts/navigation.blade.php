{{-- Navigation Component untuk sistem yang sudah ada sudah terintegrasi di main layout --}}
{{-- File ini bisa digunakan jika ada kebutuhan navigation terpisah --}}

{{-- Komponen Sidebar Navigation --}}
@php
    $menuItems = [
        [
            'title' => 'Dashboard',
            'icon' => 'fas fa-chart-line',
            'route' => 'dashboard',
            'active' => 'dashboard'
        ],
        [
            'title' => 'Manajemen Surat',
            'icon' => 'fas fa-envelope',
            'type' => 'dropdown',
            'active' => 'surat.*',
            'children' => [
                ['title' => 'Surat Masuk', 'icon' => 'fas fa-inbox', 'route' => 'surat.masuk.index'],
                ['title' => 'Surat Keluar', 'icon' => 'fas fa-paper-plane', 'route' => 'surat.keluar.index'],
                ['title' => 'Riwayat Surat', 'icon' => 'fas fa-history', 'route' => 'surat.riwayat.index'],
                ['title' => 'Disposisi Surat', 'icon' => 'fas fa-route', 'route' => 'surat.disposisi.index'],
                ['title' => 'Arsip Surat', 'icon' => 'fas fa-archive', 'route' => 'surat.arsip.index'],
            ]
        ],
        [
            'title' => 'Klasifikasi Surat',
            'icon' => 'fas fa-tags',
            'route' => 'klasifikasi.index',
            'active' => 'klasifikasi.*'
        ],
        [
            'title' => 'Daftar Kontak',
            'icon' => 'fas fa-address-book',
            'route' => 'kontak.index',
            'active' => 'kontak.*'
        ],
        [
            'title' => 'Manajemen File',
            'icon' => 'fas fa-folder',
            'route' => 'file.index',
            'active' => 'file.*'
        ],
        [
            'title' => 'Laporan Surat',
            'icon' => 'fas fa-chart-bar',
            'route' => 'laporan.index',
            'active' => 'laporan.*'
        ]
    ];

    $settingsMenu = [
        [
            'title' => 'Pengaturan Sistem',
            'icon' => 'fas fa-cog',
            'type' => 'dropdown',
            'active' => 'sistem.*',
            'children' => [
                ['title' => 'Pengaturan Website', 'icon' => 'fas fa-globe', 'route' => 'sistem.site'],
                ['title' => 'Manajemen User', 'icon' => 'fas fa-users', 'route' => 'users.index'],
                ['title' => 'Log Aktivitas', 'icon' => 'fas fa-list-alt', 'route' => 'log.index'],
            ]
        ]
    ];
@endphp

<div class="startbar-menu">
    <div class="d-flex align-items-start flex-column w-100">
        <ul class="navbar-nav mb-auto w-100">
            <!-- Main Menu Label -->
            <li class="menu-label">
                <span>Menu Utama</span>
            </li>

            @foreach($menuItems as $item)
                @if(isset($item['type']) && $item['type'] === 'dropdown')
                    <!-- Dropdown Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($item['active']) ? 'active' : '' }}" 
                           href="#sidebar{{ Str::camel($item['title']) }}" 
                           data-bs-toggle="collapse" 
                           role="button"
                           aria-expanded="{{ request()->routeIs($item['active']) ? 'true' : 'false' }}" 
                           aria-controls="sidebar{{ Str::camel($item['title']) }}">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['title'] }}</span>
                            @if(isset($item['badge']))
                                <span class="badge bg-{{ $item['badge']['color'] }} ms-auto">{{ $item['badge']['text'] }}</span>
                            @endif
                        </a>
                        <div class="collapse {{ request()->routeIs($item['active']) ? 'show' : '' }}" 
                             id="sidebar{{ Str::camel($item['title']) }}">
                            <ul class="nav flex-column">
                                @foreach($item['children'] as $child)
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs($child['route'].'.*') ? 'active' : '' }}" 
                                           href="{{ route($child['route']) }}">
                                            <i class="{{ $child['icon'] }}"></i> {{ $child['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <!-- Single Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($item['active']) ? 'active' : '' }}" 
                           href="{{ route($item['route']) }}">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['title'] }}</span>
                            @if(isset($item['badge']))
                                <span class="badge bg-{{ $item['badge']['color'] }} ms-auto">{{ $item['badge']['text'] }}</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endforeach

            <!-- Settings Menu Label -->
            <li class="menu-label">
                <span>Pengaturan</span>
            </li>

            @foreach($settingsMenu as $item)
                @if(isset($item['type']) && $item['type'] === 'dropdown')
                    <!-- Settings Dropdown Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($item['active']) ? 'active' : '' }}" 
                           href="#sidebar{{ Str::camel($item['title']) }}" 
                           data-bs-toggle="collapse" 
                           role="button"
                           aria-expanded="{{ request()->routeIs($item['active']) ? 'true' : 'false' }}" 
                           aria-controls="sidebar{{ Str::camel($item['title']) }}">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['title'] }}</span>
                        </a>
                        <div class="collapse {{ request()->routeIs($item['active']) ? 'show' : '' }}" 
                             id="sidebar{{ Str::camel($item['title']) }}">
                            <ul class="nav flex-column">
                                @foreach($item['children'] as $child)
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs($child['route'].'.*') ? 'active' : '' }}" 
                                           href="{{ route($child['route']) }}">
                                            <i class="{{ $child['icon'] }}"></i> {{ $child['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <!-- Single Settings Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($item['active']) ? 'active' : '' }}" 
                           href="{{ route($item['route']) }}">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['title'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>

{{-- Breadcrumb Component --}}
@if(View::hasSection('breadcrumb'))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            @yield('breadcrumb')
        </ol>
    </nav>
@endif

{{-- Quick Stats Component --}}
@push('scripts')
<script>
    // Navigation Helper Functions
    function setActiveMenu(routeName) {
        // Remove all active classes
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        
        // Add active class to current menu
        const activeLink = document.querySelector(`[href*="${routeName}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
            
            // If it's a child menu, also expand parent
            const parentCollapse = activeLink.closest('.collapse');
            if (parentCollapse) {
                parentCollapse.classList.add('show');
                const trigger = document.querySelector(`[href="#${parentCollapse.id}"]`);
                if (trigger) {
                    trigger.classList.add('active');
                    trigger.setAttribute('aria-expanded', 'true');
                }
            }
        }
    }

    // Initialize navigation on page load
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        setActiveMenu(currentPath);
    });
</script>
@endpush