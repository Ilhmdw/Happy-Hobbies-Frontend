@extends('layouts.customer')
@section('title', 'Katalog Produk')

@section('content')

@php
$categories = [
    ['name'=>'Pokémon TCG',  'emoji'=>'⚡','subs'=>['Single Card','Sealed Box','Booster Pack','Promo']],
    ['name'=>'One Piece TCG','emoji'=>'⚓','subs'=>['Single Card','Booster Pack','Sealed Box']],
    ['name'=>'Digimon TCG',  'emoji'=>'🐉','subs'=>['Single Card','Booster Pack']],
    ['name'=>'Yu-Gi-Oh!',    'emoji'=>'🎴','subs'=>['Single Card','Sealed Box']],
    ['name'=>'Magic: TG',    'emoji'=>'♦️','subs'=>['Single Card','Art Card']],
    ['name'=>'Ultraman TCG', 'emoji'=>'⚡','subs'=>['Single Card']],
    ['name'=>'Shadowverse',  'emoji'=>'🃏','subs'=>['Single Card','Sealed Box']],
    ['name'=>'Aksesoris',    'emoji'=>'🎪','subs'=>['Sleeve','Binder','Playmat']],
];

$products = [
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Charizard ex SAR – Obsidian Flames SV3','price'=>'Rp 1.990.000','badge'=>'PSA 10','badge_type'=>'psa','in_stock'=>true, 'bg'=>'bg-blue-100'],
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Mewtwo ex SAR – Pokémon 151',           'price'=>'Rp 1.350.000','badge'=>'NM',    'badge_type'=>'condition','in_stock'=>true, 'bg'=>'bg-green-50'],
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Umbreon VMAX Alt Art – Evolving Skies',  'price'=>'Rp 490.000', 'badge'=>'LP',    'badge_type'=>'condition','in_stock'=>false,'bg'=>'bg-orange-50'],
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Gardevoir ex SAR – Paldea Evolved SV2',  'price'=>'Rp 1.150.000','badge'=>'NM',   'badge_type'=>'condition','in_stock'=>true, 'bg'=>'bg-purple-50'],
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Miraidon ex SAR – Scarlet & Violet SV1', 'price'=>'Rp 1.250.000','badge'=>'PSA 9','badge_type'=>'psa','in_stock'=>true, 'bg'=>'bg-red-50'],
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Iono Full Art SAR – Paldea Evolved SV2', 'price'=>'Rp 2.100.000','badge'=>'NM',   'badge_type'=>'condition','in_stock'=>true, 'bg'=>'bg-pink-50'],
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Koraidon ex SAR – Scarlet & Violet SV1', 'price'=>'Rp 980.000', 'badge'=>'NM',   'badge_type'=>'condition','in_stock'=>true, 'bg'=>'bg-amber-50'],
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Pikachu ex SAR – 151 SV2a',              'price'=>'Rp 3.200.000','badge'=>'PSA 10','badge_type'=>'psa','in_stock'=>true, 'bg'=>'bg-yellow-50'],
    ['emoji'=>'🎴','game'=>'Pokémon TCG','name'=>'Mew ex SAR – 151 SV2a',                  'price'=>'Rp 890.000', 'badge'=>'NM',   'badge_type'=>'condition','in_stock'=>true, 'bg'=>'bg-blue-50'],
];

$activeCategory = request('category', 'semua');
$activeSub      = request('sub', '');
$sortBy         = request('sort', 'terbaru');
@endphp

{{-- Hero breadcrumb --}}
<div class="bg-brand-dark py-5 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center gap-1.5 text-xs text-white/40 mb-2">
            <a href="{{ route('home') }}" class="hover:text-white/70 transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="text-white/80">Koleksi</span>
        </div>
        <h1 class="font-heading font-extrabold text-xl text-white">Semua Produk</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex gap-6">

        {{-- ── SIDEBAR FILTER ── --}}
        <aside class="w-44 flex-shrink-0 hidden md:block">
            <div class="card p-4 sticky top-20">
                <div class="font-heading font-bold text-xs text-gray-800 pb-2 mb-2 border-b border-gray-100">
                    COLLECTION
                </div>
                {{-- All --}}
                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-1.5 px-2 py-1.5 rounded-lg text-xs mb-0.5 transition
                           {{ $activeCategory === 'semua' ? 'bg-orange-50 text-brand-orange font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                    🗂️ Semua
                </a>
                @foreach($categories as $cat)
                @php $catSlug = strtolower(str_replace([' ',':','!'],'-',$cat['name'])); @endphp
                <div x-data="{ open: '{{ $activeCategory }}' === '{{ $catSlug }}' }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-2 py-1.5 rounded-lg text-xs mb-0.5 transition
                               {{ $activeCategory === $catSlug ? 'text-brand-orange font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span>{{ $cat['emoji'] }} {{ $cat['name'] }}</span>
                        <i :class="open ? 'fa-chevron-down' : 'fa-chevron-right'" class="fa-solid text-[8px] text-gray-400"></i>
                    </button>
                    <div x-show="open" class="pl-4 space-y-0.5 mb-1">
                        @foreach($cat['subs'] as $sub)
                        <a href="{{ route('products.index', ['category'=>$catSlug,'sub'=>strtolower($sub)]) }}"
                            class="block px-2 py-1 rounded-lg text-[11px] transition
                                   {{ $activeSub === strtolower($sub) ? 'bg-orange-50 text-brand-orange font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
                            {{ $sub }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </aside>

        {{-- ── PRODUCT GRID ── --}}
        <div class="flex-1 min-w-0">
            {{-- Toolbar --}}
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">
                    Menampilkan <strong class="text-gray-800">{{ count($products) }}</strong> produk
                    @if($activeCategory !== 'semua')
                    dalam <strong class="text-brand-orange">{{ ucwords(str_replace('-',' ',$activeCategory)) }}</strong>
                    @endif
                </p>
                <select name="sort" onchange="window.location = '?sort=' + this.value"
                    class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 outline-none focus:border-brand-orange bg-white">
                    <option value="terbaru"  {{ $sortBy === 'terbaru'  ? 'selected' : '' }}>Terbaru</option>
                    <option value="murah"    {{ $sortBy === 'murah'    ? 'selected' : '' }}>Harga: Termurah</option>
                    <option value="mahal"    {{ $sortBy === 'mahal'    ? 'selected' : '' }}>Harga: Termahal</option>
                    <option value="populer"  {{ $sortBy === 'populer'  ? 'selected' : '' }}>Terpopuler</option>
                </select>
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($products as $p)
                <a href="{{ route('products.show', 'slug') }}"
                    class="group bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-200">
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
                    <div class="p-3">
                        <p class="text-[9px] text-gray-400 font-medium uppercase tracking-wide mb-1">{{ $p['game'] }}</p>
                        <p class="font-heading font-bold text-xs leading-snug line-clamp-2 mb-2 text-gray-800">{{ $p['name'] }}</p>
                        <p class="font-bold text-sm {{ $p['in_stock'] ? 'text-brand-orange' : 'text-gray-300' }}">{{ $p['price'] }}</p>
                        @if($p['in_stock'])
                        <button onclick="event.preventDefault()"
                            class="btn-dark w-full mt-2 text-[10px] py-1.5">+ Keranjang</button>
                        @else
                        <button disabled class="w-full mt-2 text-[10px] py-1.5 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                            Stok Habis
                        </button>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center gap-1.5 mt-8">
                @foreach([1,2,3,'…',12] as $pg)
                <button class="w-8 h-8 rounded-lg text-xs font-semibold border transition
                    {{ $pg === 1 ? 'bg-brand-orange text-white border-brand-orange' : 'bg-white text-gray-600 border-gray-200 hover:border-brand-orange hover:text-brand-orange' }}">
                    {{ $pg }}
                </button>
                @endforeach
                <button class="w-8 h-8 rounded-lg text-xs border border-gray-200 bg-white text-gray-600 hover:border-brand-orange hover:text-brand-orange transition">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
