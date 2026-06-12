<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Seller Center') — HappyHobbies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-gray-100 font-sans" x-data="{ sidebarOpen: true }">

<div class="flex h-screen overflow-hidden">

    {{-- ── SIDEBAR ── --}}
    <aside class="w-48 bg-brand-dark2 flex flex-col flex-shrink-0 overflow-y-auto">
        {{-- Logo --}}
        <div class="px-4 py-3.5 border-b border-white/8">
            <div class="font-heading font-extrabold text-sm text-white">
                <span class="text-brand-orange">Happy</span>Hobbies
            </div>
            <div class="text-[10px] text-white/25 mt-0.5">Seller Center</div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-2">
            @php
            $active = Route::currentRouteName();
            $navItems = [
                ['section' => 'MENU UTAMA'],
                ['route' => 'admin.dashboard',       'icon' => 'fa-chart-line',     'label' => 'Beranda'],
                ['route' => 'admin.orders.index',    'icon' => 'fa-bag-shopping',   'label' => 'Pesanan',        'badge' => '12'],
                ['section' => 'PRODUK'],
                ['route' => 'admin.products.index',  'icon' => 'fa-list',           'label' => 'Kelola Produk'],
                ['route' => 'admin.products.create', 'icon' => 'fa-plus',           'label' => 'Tambah Produk',  'sub' => true],
                ['section' => 'TOKO'],
                ['route' => 'admin.categories',      'icon' => 'fa-tags',           'label' => 'Kelola Kategori'],
                ['section' => 'PENGATURAN'],
                ['route' => 'admin.pic',             'icon' => 'fa-users',          'label' => 'Manajemen PIC'],
                ['route' => 'admin.settings',        'icon' => 'fa-gear',           'label' => 'Pengaturan Toko'],
            ];
            @endphp

            @foreach($navItems as $item)
                @if(isset($item['section']))
                    <div class="px-3 pt-4 pb-1 text-[9px] font-bold text-white/22 uppercase tracking-widest">
                        {{ $item['section'] }}
                    </div>
                @else
                    @php
                        $isActive = str_starts_with($active, $item['route']);
                        $isSub    = $item['sub'] ?? false;
                    @endphp
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-2 mx-1.5 px-2.5 py-2 rounded-lg text-[11px] transition-colors relative
                               {{ $isActive
                                  ? 'bg-brand-orange/18 text-brand-orange font-semibold'
                                  : 'text-white/55 hover:text-white/85 hover:bg-white/5' }}
                               {{ $isSub ? 'pl-7' : '' }}">
                        <i class="fa-solid {{ $item['icon'] }} w-3.5 text-center text-xs flex-shrink-0"></i>
                        <span>{{ $item['label'] }}</span>
                        @if(isset($item['badge']))
                        <span class="ml-auto bg-brand-orange text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full">
                            {{ $item['badge'] }}
                        </span>
                        @endif
                    </a>
                @endif
            @endforeach
        </nav>

        {{-- View store link --}}
        <a href="{{ route('home') }}" target="_blank"
            class="mx-2 mb-3 px-3 py-2 bg-white/4 border border-white/7 rounded-lg flex items-center gap-2 text-[10px] text-white/30 hover:text-white/50 transition">
            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
            Lihat Halaman Toko
        </a>
    </aside>

    {{-- ── MAIN ── --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-100 px-5 h-12 flex items-center justify-between flex-shrink-0 sticky top-0 z-30">
            {{-- Search --}}
            <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-3 py-1.5 flex-1 max-w-xs">
                <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                <input type="text" placeholder="Cari di Seller Center…"
                    class="bg-transparent text-sm outline-none flex-1 text-gray-600"/>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-2">
                {{-- Notif --}}
                <button class="relative w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <i class="fa-regular fa-bell text-gray-500 text-sm"></i>
                    <span class="absolute top-1 right-1 w-1.5 h-1.5 bg-brand-orange rounded-full border border-white"></span>
                </button>

                {{-- User chip --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-2 px-2.5 py-1.5 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="w-5 h-5 bg-brand-orange rounded-md flex items-center justify-center text-white text-[9px] font-black font-heading">
                            @auth {{ strtoupper(substr(session('demo_user.name', 'Admin'),0,1)) }} @else A @endauth
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-xs font-semibold leading-none">@auth {{ session('demo_user.name', 'Admin') }} @else Admin @endauth</div>
                            <div class="text-[10px] text-gray-400 leading-none mt-0.5">@auth {{ session('demo_user.email', 'admin@happyhobbies.id') }} @else admin@happyhobbies.id @endauth</div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[9px] text-gray-400"></i>
                    </button>
                    <div x-show="open" @click.outside="open=false"
                        class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                <i class="fa-solid fa-right-from-bracket w-4"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash --}}
        @if(session('success'))
        <div id="flash-message" class="mx-5 mt-3 bg-green-50 border border-green-200 text-green-700 px-4 py-2.5 rounded-lg flex items-center gap-2 text-sm transition-all">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div id="flash-message" class="mx-5 mt-3 bg-red-50 border border-red-200 text-red-700 px-4 py-2.5 rounded-lg flex items-center gap-2 text-sm transition-all">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-5">
            @yield('content')
        </main>

    </div>
</div>

@stack('scripts')
</body>
</html>
