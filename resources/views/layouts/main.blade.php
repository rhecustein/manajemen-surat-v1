<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Dashboard | Sistem KP Manajemen Surat')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Sistem KP Manajemen Surat - PT RIFIA SEN TOSA" name="description" />
    <meta content="@bintangwijaye" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('dist/assets/images/favicon.ico') }}">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('css')
</head>

<body class="h-full bg-gray-50 antialiased" x-data="{ sidebarOpen: false, darkMode: false }" :class="{ 'dark': darkMode }">
    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
         @click="sidebarOpen = false">
    </div>

    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-slate-800 to-slate-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0"
         :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">
        
        <!-- Brand Logo -->
        <div class="flex items-center justify-center h-16 px-6 bg-slate-900 border-b border-slate-700">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-white hover:text-blue-200 transition-colors">
                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-white text-lg"></i>
                </div>
                <span class="font-semibold text-lg">Manajemen Surat</span>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <!-- Main Menu Label -->
            <div class="px-3 py-2">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</h3>
            </div>

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group
                      {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                Dashboard
            </a>

            <!-- Manajemen Surat -->
            <div x-data="{ open: {{ request()->routeIs('surat.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 group"
                        :class="{ 'bg-slate-700 text-white': open }">
                    <div class="flex items-center">
                        <i class="fas fa-envelope w-5 h-5 mr-3"></i>
                        Manajemen Surat
                    </div>
                    <i class="fas fa-chevron-down w-4 h-4 transition-transform duration-200" 
                       :class="{ 'rotate-180': open }"></i>
                </button>
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="mt-2 space-y-1 ml-6">
                    <a href="{{ route('surat.masuk.index') }}" 
                       class="flex items-center px-3 py-2 text-sm text-gray-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200
                              {{ request()->routeIs('surat.masuk.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-inbox w-4 h-4 mr-3"></i>
                        Surat Masuk
                    </a>
                    <a href="{{ route('surat.keluar.index') }}" 
                       class="flex items-center px-3 py-2 text-sm text-gray-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200
                              {{ request()->routeIs('surat.keluar.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-paper-plane w-4 h-4 mr-3"></i>
                        Surat Keluar
                    </a>
                    <a href="{{ route('surat.riwayat.index') }}" 
                       class="flex items-center px-3 py-2 text-sm text-gray-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200
                              {{ request()->routeIs('surat.riwayat.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-history w-4 h-4 mr-3"></i>
                        Riwayat Surat
                    </a>
                    <a href="{{ route('surat.disposisi.index') }}" 
                       class="flex items-center px-3 py-2 text-sm text-gray-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200
                              {{ request()->routeIs('surat.disposisi.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-route w-4 h-4 mr-3"></i>
                        Disposisi Surat
                    </a>
                    <a href="{{ route('surat.arsip.index') }}" 
                       class="flex items-center px-3 py-2 text-sm text-gray-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200
                              {{ request()->routeIs('surat.arsip.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-archive w-4 h-4 mr-3"></i>
                        Arsip Surat
                    </a>
                </div>
            </div>

            <!-- Klasifikasi Surat -->
            <a href="{{ route('klasifikasi.index') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group
                      {{ request()->routeIs('klasifikasi.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <i class="fas fa-tags w-5 h-5 mr-3"></i>
                Klasifikasi Surat
            </a>

            <!-- Daftar Kontak -->
            <a href="{{ route('kontak.index') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group
                      {{ request()->routeIs('kontak.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <i class="fas fa-address-book w-5 h-5 mr-3"></i>
                Daftar Kontak
            </a>

            <!-- Manajemen File -->
            <a href="{{ route('file.index') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group
                      {{ request()->routeIs('file.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <i class="fas fa-folder w-5 h-5 mr-3"></i>
                Manajemen File
            </a>

            <!-- Laporan Surat -->
            <a href="{{ route('laporan.index') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group
                      {{ request()->routeIs('laporan.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                Laporan Surat
            </a>

            <!-- Settings Menu Label -->
            <div class="px-3 py-2 mt-6">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengaturan</h3>
            </div>

            <!-- Pengaturan Sistem -->
            <div x-data="{ open: {{ request()->routeIs('sistem.*') || request()->routeIs('users.*') || request()->routeIs('log.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 group"
                        :class="{ 'bg-slate-700 text-white': open }">
                    <div class="flex items-center">
                        <i class="fas fa-cog w-5 h-5 mr-3"></i>
                        Pengaturan Sistem
                    </div>
                    <i class="fas fa-chevron-down w-4 h-4 transition-transform duration-200" 
                       :class="{ 'rotate-180': open }"></i>
                </button>
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="mt-2 space-y-1 ml-6">
                    <a href="{{ route('sistem.site') }}" 
                       class="flex items-center px-3 py-2 text-sm text-gray-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200
                              {{ request()->routeIs('sistem.site.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-globe w-4 h-4 mr-3"></i>
                        Pengaturan Website
                    </a>
                    <a href="{{ route('users.index') }}" 
                       class="flex items-center px-3 py-2 text-sm text-gray-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200
                              {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-users w-4 h-4 mr-3"></i>
                        Manajemen User
                    </a>
                    <a href="{{ route('log.index') }}" 
                       class="flex items-center px-3 py-2 text-sm text-gray-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200
                              {{ request()->routeIs('log.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-list-alt w-4 h-4 mr-3"></i>
                        Log Aktivitas
                    </a>
                </div>
            </div>

            <!-- Profil Saya -->
            <a href="{{ route('profil.index') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group
                      {{ request()->routeIs('profil.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <i class="fas fa-user w-5 h-5 mr-3"></i>
                Profil Saya
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center w-full px-3 py-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 group">
                    <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                    Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-bars w-5 h-5"></i>
                </button>

                <!-- Page Title for Mobile -->
                <div class="lg:hidden">
                    <h1 class="text-lg font-semibold text-gray-900">Dashboard</h1>
                </div>

                <!-- Search Bar -->
                <div class="hidden lg:flex flex-1 max-w-lg mx-4">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 w-5 h-5"></i>
                        </div>
                        <input type="search" 
                               placeholder="Cari surat, kontak, atau dokumen..." 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-sm">
                    </div>
                </div>

                <!-- Right Side Items -->
                <div class="flex items-center space-x-2 lg:space-x-4">
                    <!-- Search Button for Mobile -->
                    <button class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-search w-5 h-5"></i>
                    </button>

                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" 
                            class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-moon w-5 h-5" x-show="!darkMode"></i>
                        <i class="fas fa-sun w-5 h-5" x-show="darkMode" style="display: none;"></i>
                    </button>

                    <!-- Notifications -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                                class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-bell w-5 h-5"></i>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                             style="display: none;">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Notifikasi</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <a href="#" class="flex items-start p-4 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-envelope text-blue-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Surat masuk baru</p>
                                        <p class="text-sm text-gray-500">Dari PT ABC mengenai proposal kerjasama</p>
                                        <p class="text-xs text-gray-400 mt-1">2 menit lalu</p>
                                    </div>
                                </a>
                            </div>
                            <div class="p-4 border-t border-gray-200">
                                <a href="#" class="text-sm text-blue-600 hover:text-blue-500 font-medium">Lihat semua notifikasi</a>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 lg:space-x-3 p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <img src="{{ asset('dist/assets/images/users/avatar-1.jpg') }}" 
                                 alt="User Avatar" 
                                 class="w-8 h-8 rounded-full object-cover">
                            <div class="hidden lg:block text-left">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->role ?? 'User' }}</p>
                            </div>
                            <i class="fas fa-chevron-down w-4 h-4 text-gray-400 hidden lg:block"></i>
                        </button>

                        <!-- Profile Dropdown -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                             style="display: none;">
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset('dist/assets/images/users/avatar-1.jpg') }}" 
                                         alt="User Avatar" 
                                         class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profil.index') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <i class="fas fa-user w-4 h-4 mr-3"></i>
                                    Profil Saya
                                </a>
                                <a href="{{ route('profil.edit') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <i class="fas fa-edit w-4 h-4 mr-3"></i>
                                    Edit Profil
                                </a>
                                <div class="border-t border-gray-200 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Breadcrumb -->
            @if(View::hasSection('breadcrumb'))
                <div class="px-4 lg:px-6 py-3 bg-gray-50 border-t border-gray-200">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('dashboard') }}" 
                                   class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-home w-4 h-4 mr-2"></i>
                                    Dashboard
                                </a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            @endif
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 lg:p-6">
            <!-- Alert Messages -->
            @if(session('success'))
                <div x-data="{ show: true }" 
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-400 w-5 h-5 mr-3"></i>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600">
                            <i class="fas fa-times w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" 
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-400 w-5 h-5 mr-3"></i>
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600">
                            <i class="fas fa-times w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div x-data="{ show: true }" 
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-yellow-400 w-5 h-5 mr-3"></i>
                        <p class="text-sm font-medium text-yellow-800">{{ session('warning') }}</p>
                        <button @click="show = false" class="ml-auto text-yellow-400 hover:text-yellow-600">
                            <i class="fas fa-times w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div x-data="{ show: true }" 
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-400 w-5 h-5 mr-3"></i>
                        <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
                        <button @click="show = false" class="ml-auto text-blue-400 hover:text-blue-600">
                            <i class="fas fa-times w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 px-4 lg:px-6 py-4 mt-auto">
            <div class="flex flex-col sm:flex-row items-center justify-between text-center sm:text-left">
                <p class="text-sm text-gray-600">
                    © <span id="currentYear"></span> Sistem KP Manajemen Surat v1.0 - PT RIFIA SEN TOSA
                </p>
                <p class="text-sm text-gray-600 mt-2 sm:mt-0">
                    Dikembangkan untuk Kerja Praktek 
                    <i class="fas fa-heart text-red-500 mx-1"></i>
                    by Bintang Wijaya
                </p>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Set current year
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('currentYear').textContent = new Date().getFullYear();
        });

        // Form loading handler
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    // Add loading state if needed
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>