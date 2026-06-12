<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Masuk') — HappyHobbies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-brand-dark min-h-screen flex items-center justify-center p-4 font-sans">

{{-- Background decoration --}}
<div class="absolute top-0 right-0 w-96 h-96 bg-brand-orange/6 rounded-full blur-3xl pointer-events-none"></div>
<div class="absolute bottom-0 left-0 w-72 h-72 bg-brand-yellow/4 rounded-full blur-3xl pointer-events-none"></div>

<div class="relative w-full max-w-sm">
    {{-- Logo --}}
    <div class="text-center mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
            <div class="w-9 h-9 bg-brand-yellow rounded-xl flex items-center justify-center">
                <span class="font-heading font-black text-brand-dark text-sm">HH</span>
            </div>
            <span class="font-heading font-extrabold text-white text-xl">
                <span class="text-brand-orange">Happy</span>Hobbies
            </span>
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        @yield('content')
    </div>

    {{-- Back to home --}}
    <p class="text-center text-xs text-white/30 mt-4">
        <a href="{{ route('home') }}" class="hover:text-white/60 transition">
            <i class="fa-solid fa-arrow-left mr-1"></i>Kembali ke beranda
        </a>
    </p>
</div>

</body>
</html>
