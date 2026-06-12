@extends('layouts.customer')
@section('title', 'Beranda')

@section('content')

@php
$categories = [
    ['emoji'=>'⚡','name'=>'Pokémon TCG',   'sub'=>'Scarlet & Violet', 'count'=>'850+ SKU','color'=>'bg-yellow-300'],
    ['emoji'=>'🎴','name'=>'Yu-Gi-Oh!',    'sub'=>'OCG · Master Duel','count'=>'420+ SKU','color'=>'bg-purple-400'],
    ['emoji'=>'⚓','name'=>'One Piece TCG', 'sub'=>'OP-01 s/d OP-09',  'count'=>'310+ SKU','color'=>'bg-red-400'],
    ['emoji'=>'🐉','name'=>'Digimon TCG',   'sub'=>'BT · EX Series',   'count'=>'180+ SKU','color'=>'bg-blue-400'],
    ['emoji'=>'♦️','name'=>'Magic: TG',     'sub'=>'Standard · Cmdr',  'count'=>'200+ SKU','color'=>'bg-gray-700'],
    ['emoji'=>'⚡','name'=>'Ultraman TCG',  'sub'=>'BP01·BP02·BP03',   'count'=>'95+ SKU', 'color'=>'bg-blue-700'],
    ['emoji'=>'🃏','name'=>'Shadowverse',   'sub'=>'SD02 · BP Series',  'count'=>'120+ SKU','color'=>'bg-purple-700'],
    ['emoji'=>'🎪','name'=>'Aksesoris',     'sub'=>'Sleeve · Binder',  'count'=>'80+ SKU', 'color'=>'bg-orange-400'],
];

$products = [
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Charizard ex SAR – Obsidian Flames SV3','price'=>'Rp 1.990.000','badge'=>'PSA 10','badge_type'=>'psa','in_stock'=>true,'bg'=>'bg-blue-100'],
    ['emoji'=>'⚓','game'=>'One Piece TCG','name'=>'Luffy OP-09 Secret Rare Alt Art','price'=>'Rp 850.000','badge'=>'NM','badge_type'=>'condition','in_stock'=>true,'bg'=>'bg-orange-50'],
    ['emoji'=>'🎴','game'=>'Yu-Gi-Oh!','name'=>'Dark Magician LOB-001 Holo PSA 9','price'=>'Rp 3.500.000','badge'=>'PSA 9','badge_type'=>'psa','in_stock'=>false,'bg'=>'bg-purple-100'],
    ['emoji'=>'🐉','game'=>'Digimon TCG','name'=>'Omegamon Alter-S BT12-112 SR','price'=>'Rp 420.000','badge'=>'NM','badge_type'=>'condition','in_stock'=>true,'bg'=>'bg-blue-50'],
    ['emoji'=>'♦️','game'=>'Magic: TG','name'=>'Blossoming Calm MH2 Art Card 1/81','price'=>'Rp 33.830','badge'=>'NM','badge_type'=>'condition','in_stock'=>true,'bg'=>'bg-green-50'],
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Iono Full Art SAR – Paldea Evolved SV2','price'=>'Rp 2.100.000','badge'=>'NM','badge_type'=>'condition','in_stock'=>true,'bg'=>'bg-pink-50'],
];
@endphp

{{-- ── HERO ── --}}
<section class="bg-brand-dark relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-16 -right-16 w-72 h-72 bg-brand-orange/6 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 w-48 h-48 bg-brand-yellow/4 rounded-full blur-2xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-16 relative">
        <div class="max-w-xl">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-yellow/12 border border-brand-yellow/25 rounded-full text-brand-yellow text-[10px] font-semibold uppercase tracking-wider mb-4">
                🔥 Indonesia's TCG Store #1
            </div>
            <h1 class="font-heading font-extrabold text-4xl md:text-5xl text-white leading-tight mb-3">
                Semua Kartu TCG<br/>
                <span class="text-brand-orange">Ada Di Sini.</span>
            </h1>
            <p class="text-white/50 text-sm leading-relaxed mb-6 max-w-sm">
                Pokémon, Yu-Gi-Oh!, One Piece, MTG dan 8+ game lainnya. Original, bergaransi, pengiriman ke seluruh Indonesia.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('products.index') }}" class="btn-primary flex items-center gap-2 px-5 py-2.5 text-sm">
                    <i class="fa-solid fa-store"></i> Lihat Semua Produk
                </a>
                <a href="{{ route('register') }}" class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-white/8 border border-white/15 rounded-lg hover:bg-white/12 transition">
                    <i class="fa-regular fa-user"></i> Daftar Gratis
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── KATEGORI TCG ── --}}
<section class="bg-white py-10">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-7">
            <h2 class="font-heading font-extrabold text-2xl text-gray-900 mb-1">What Are You Looking For?</h2>
            <p class="text-gray-500 text-sm">Pilih game TCG favoritmu</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => strtolower($cat['name'])]) }}"
                class="group border border-gray-100 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-orange hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <div class="w-11 h-11 {{ $cat['color'] }} rounded-xl flex items-center justify-center text-xl shadow-sm">
                    {{ $cat['emoji'] }}
                </div>
                <div class="font-heading font-bold text-xs text-center text-gray-800">{{ $cat['name'] }}</div>
                <div class="text-[10px] text-gray-400 text-center">{{ $cat['sub'] }}</div>
                <div class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 group-hover:bg-orange-50 group-hover:text-brand-orange transition">
                    {{ $cat['count'] }}
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ── PRODUK TERBARU ── --}}
<section class="bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="font-heading font-extrabold text-2xl text-gray-900 mb-1">Produk Terbaru</h2>
                <p class="text-gray-500 text-sm">Koleksi terbaru yang baru masuk ke toko</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-brand-orange text-sm font-semibold hover:underline hidden sm:block">
                Lihat Semua <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($products as $p)
            <a href="{{ route('products.show', 'slug') }}"
                class="group bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                {{-- Image --}}
                <div class="relative {{ $p['bg'] }} h-40 flex items-center justify-center">
                    <span class="text-5xl opacity-20">{{ $p['emoji'] }}</span>
                    <div class="absolute top-2 left-2 flex flex-col gap-1">
                        @if($p['badge_type'] === 'psa')
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-brand-yellow text-brand-dark">{{ $p['badge'] }}</span>
                        @else
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-brand-orange text-white">{{ $p['badge'] }}</span>
                        @endif
                        @if($p['in_stock'])
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-green-100 text-green-700">In Stock</span>
                        @else
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-red-100 text-red-600">Habis</span>
                        @endif
                    </div>
                </div>
                {{-- Body --}}
                <div class="p-3">
                    <p class="text-[9px] text-gray-400 font-medium uppercase tracking-wide mb-1">{{ $p['game'] }}</p>
                    <p class="font-heading font-bold text-xs leading-snug line-clamp-2 mb-2 text-gray-800">{{ $p['name'] }}</p>
                    <p class="font-bold text-sm {{ $p['in_stock'] ? 'text-brand-orange' : 'text-gray-300' }}">{{ $p['price'] }}</p>
                    @if($p['in_stock'])
                    <button class="btn-dark w-full mt-2 text-[10px] py-1.5 group-hover:opacity-90">
                        + Keranjang
                    </button>
                    @else
                    <button disabled class="w-full mt-2 text-[10px] py-1.5 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                        Stok Habis
                    </button>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-6 sm:hidden">
            <a href="{{ route('products.index') }}" class="btn-outline text-sm px-6">
                Lihat Semua Produk <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ── VALUE PROPS ── --}}
<section class="bg-brand-dark py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="font-heading font-extrabold text-2xl text-white">Kenapa Happy Hobbies?</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach([
                ['icon'=>'fa-shield-check','title'=>'100% Original','desc'=>'Semua kartu bergaransi keaslian. Tersedia kartu bergrade PSA yang terverifikasi.'],
                ['icon'=>'fa-box','title'=>'Pengiriman Aman','desc'=>'Dikemas dengan pelindung kartu premium. Tracking real-time ke seluruh Indonesia.'],
                ['icon'=>'fa-headset','title'=>'CS Responsif','desc'=>'Tim kami siap 7 hari seminggu via WhatsApp, Instagram, dan live chat.'],
            ] as $vp)
            <div class="bg-white/6 border border-white/10 rounded-xl p-5">
                <div class="w-10 h-10 bg-brand-orange/20 rounded-xl flex items-center justify-center text-brand-orange mb-3">
                    <i class="fa-solid {{ $vp['icon'] }} text-base"></i>
                </div>
                <h3 class="font-heading font-bold text-white text-sm mb-1.5">{{ $vp['title'] }}</h3>
                <p class="text-white/40 text-xs leading-relaxed">{{ $vp['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
