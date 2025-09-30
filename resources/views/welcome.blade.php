<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Surat</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <style>
        body {
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
        }
        .cloud {
            position: absolute;
            top: 50px;
            background: url('https://www.transparenttextures.com/patterns/clouds.png') repeat-x;
            width: 300%;
            height: 300px;
            opacity: 0.2;
            animation: cloudAnimation 120s linear infinite;
        }

        @keyframes cloudAnimation {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-6 text-center relative">

    {{-- Background Cloud --}}
    <div class="cloud"></div>

    {{-- Content --}}
    <main class="z-10 flex flex-col items-center">
        {{-- Animation --}}
        <lottie-player 
            src="https://assets9.lottiefiles.com/packages/lf20_x62chJ.json"  
            background="transparent"  
            speed="1"  
            style="width: 300px; height: 300px;"  
            loop  
            autoplay>
        </lottie-player>

        {{-- Title --}}
        <h1 class="mt-6 text-2xl font-semibold text-[#1b1b18]">
            Selamat Datang di Aplikasi Manajemen Surat
        </h1>

        {{-- Subtitle --}}
        <p class="mt-2 text-gray-600">
            Kelola surat masuk dan surat keluar secara mudah dan efisien.
        </p>

        {{-- Button --}}
        @if (Route::has('login'))
        <div class="mt-6">
            <a href="{{ route('login') }}"
            class="inline-flex items-center px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-lg shadow-md transition duration-200">
                Masuk Sekarang
            </a>
        </div>
        @endif
    </main>

</body>
</html>
