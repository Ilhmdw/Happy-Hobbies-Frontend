@extends('layouts.customer')
@section('title', 'Detail Produk')

@section('content')

@php
$product = [
    'name'        => 'Blossoming Calm MH2 Art Card 1/81 MTG Singles',
    'game'        => 'Magic: The Gathering',
    'sub'         => 'Art Card',
    'sku'         => 'HH-MTG-BLO-001',
    'description' => 'Blossoming Calm MH2 Art Card 1/81 MTG Singles. Tersedia dalam dua versi bahasa: English (EN) dan Japanese (JP). Kartu dalam kondisi Near Mint, langsung dari sealed pack.',
    'has_variant' => true,
    'price'       => 33830,
    'stock'       => 1,
    'images'      => ['🌿','🌿'],
    'variants'    => [
        ['id'=>1,'label'=>'NORMAL EN','price'=>33830,'stock'=>0,'flag'=>'EN'],
        ['id'=>2,'label'=>'NORMAL JP','price'=>33830,'stock'=>1,'flag'=>'JP'],
    ],
];

$related = [
    ['emoji'=>'♦️','game'=>'Magic: TG','name'=>'Chatterfang, Squirrel General MH2','price'=>'Rp 45.000','badge'=>'NM','in_stock'=>true,'bg'=>'bg-green-50'],
    ['emoji'=>'♦️','game'=>'Magic: TG','name'=>'Ragavan Nimble Pilferer MH2','price'=>'Rp 1.200.000','badge'=>'NM','in_stock'=>true,'bg'=>'bg-orange-50'],
    ['emoji'=>'♦️','game'=>'Magic: TG','name'=>'Solitude MH2','price'=>'Rp 280.000','badge'=>'NM','in_stock'=>true,'bg'=>'bg-blue-50'],
    ['emoji'=>'♦️','game'=>'Magic: TG','name'=>'Dragon\'s Rage Channeler MH2','price'=>'Rp 65.000','badge'=>'NM','in_stock'=>false,'bg'=>'bg-red-50'],
];
@endphp

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-100 py-3 px-4">
    <div class="max-w-7xl mx-auto flex items-center gap-1.5 text-xs text-gray-500">
        <a href="{{ route('home') }}" class="text-brand-orange hover:underline">Beranda</a>
        <i class="fa-solid fa-chevron-right text-[8px]"></i>
        <a href="{{ route('products.index') }}" class="text-brand-orange hover:underline">Koleksi</a>
        <i class="fa-solid fa-chevron-right text-[8px]"></i>
        <span class="truncate max-w-xs">{{ $product['name'] }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8"
    x-data="{ selectedVariant: 2, qty: 1 }">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- LEFT: Images --}}
        <div>
            <div class="bg-green-50 rounded-2xl aspect-square flex items-center justify-center mb-3 border border-gray-100">
                <span class="text-8xl opacity-20">🌿</span>
            </div>
            <div class="flex gap-2">
                @foreach($product['variants'] as $v)
                <button @click="selectedVariant = {{ $v['id'] }}"
                    :class="selectedVariant === {{ $v['id'] }}
                        ? 'border-brand-orange ring-1 opacity-100'
                        : 'border-gray-200 opacity-50 hover:opacity-75'"
                    class="w-14 h-14 rounded-xl bg-green-50 border-2 flex items-center justify-center text-sm font-bold transition-all">
                    {{ $v['flag'] }}
                </button>
                @endforeach
            </div>
        </div>

        {{-- RIGHT: Info --}}
        <div>
            <span class="inline-block px-2.5 py-1 bg-orange-50 text-brand-orange text-xs font-bold rounded-full mb-3">
                {{ $product['game'] }}
            </span>

            <h1 class="font-heading font-extrabold text-2xl text-gray-900 leading-tight mb-4">
                {{ $product['name'] }}
            </h1>

            <div class="flex items-center gap-3 mb-5">
                <span class="font-heading font-extrabold text-3xl text-brand-orange">
                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                </span>
                @if($product['stock'] > 0)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                    <i class="fa-solid fa-circle text-[6px]"></i> In Stock
                </span>
                @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-100 text-red-600 text-xs font-semibold rounded-full">
                    Stok Habis
                </span>
                @endif
            </div>

            {{-- Variant Selector --}}
            @if($product['has_variant'])
            <div class="mb-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih JENIS:</p>
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach($product['variants'] as $v)
                    @php
                        $isAvailable  = $v['stock'] > 0;
                        $activeClass  = 'border-brand-orange bg-orange-50 text-brand-orange';
                        $soldClass    = 'border-gray-200 opacity-50 cursor-not-allowed line-through';
                        $normalClass  = 'border-gray-200 hover:border-brand-orange';
                        $inactiveClass = $isAvailable ? $normalClass : $soldClass;
                        $stockInfo    = $isAvailable
                            ? $v['stock'].' unit · Rp '.number_format($v['price'],0,',','.')
                            : 'Stok habis';
                    @endphp
                    <button
                        @click="{{ $isAvailable ? 'selectedVariant = '.$v['id'] : '' }}"
                        :class="selectedVariant === {{ $v['id'] }} ? '{{ $activeClass }}' : '{{ $inactiveClass }}'"
                        class="px-4 py-2 border-2 rounded-xl text-xs font-semibold transition-all"
                        @if(!$isAvailable) disabled title="Stok habis" @endif>
                        {{ $v['flag'] }} {{ $v['label'] }}
                        <span class="block text-[10px] font-normal mt-0.5 opacity-70">
                            {{ $stockInfo }}
                        </span>
                    </button>
                    @endforeach
                </div>

                {{-- Alert stok habis --}}
                @foreach($product['variants'] as $v)
                @if($v['stock'] === 0)
                <div class="bg-amber-50 border border-amber-200 text-amber-800 text-xs px-3 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-circle-info flex-shrink-0"></i>
                    Varian <strong>{{ $v['label'] }}</strong> sedang habis. Pilih varian lain.
                </div>
                @endif
                @endforeach
            </div>
            @endif

            {{-- Meta info --}}
            <div class="space-y-1.5 mb-5 text-xs">
                <div class="flex gap-3">
                    <span class="text-gray-400 w-20 flex-shrink-0">SKU</span>
                    <span class="font-mono text-gray-600">{{ $product['sku'] }}</span>
                </div>
                <div class="flex gap-3">
                    <span class="text-gray-400 w-20 flex-shrink-0">Kategori</span>
                    <a href="{{ route('products.index', ['category'=>'magic-tg']) }}"
                        class="text-brand-orange hover:underline">{{ $product['sub'] }}</a>
                </div>
            </div>

            {{-- Description --}}
            <div class="bg-gray-50 rounded-xl p-4 text-xs text-gray-600 leading-relaxed mb-5 border border-gray-100">
                {{ $product['description'] }}
            </div>

            {{-- Qty + Add to cart --}}
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                    <button @click="qty = Math.max(1, qty - 1)"
                        class="w-9 h-10 flex items-center justify-center hover:bg-gray-50 text-gray-500 transition text-lg">−</button>
                    <input type="number" x-model="qty" min="1"
                        class="w-12 text-center text-sm font-bold border-0 outline-none bg-transparent"/>
                    <button @click="qty++"
                        class="w-9 h-10 flex items-center justify-center hover:bg-gray-50 text-gray-500 transition text-lg">+</button>
                </div>
                <button class="flex-1 btn-dark py-2.5 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>

            {{-- Guarantees --}}
            <div class="flex flex-wrap gap-3 text-[11px] text-gray-500">
                <span class="flex items-center gap-1"><i class="fa-solid fa-shield-check text-brand-orange"></i> 100% Original</span>
                <span class="flex items-center gap-1"><i class="fa-solid fa-box text-brand-orange"></i> Packaging aman</span>
                <span class="flex items-center gap-1"><i class="fa-solid fa-rotate-left text-brand-orange"></i> Retur 7 hari</span>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    <div class="mt-14">
        <h2 class="font-heading font-extrabold text-xl text-gray-900 mb-5">Produk Terkait</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($related as $r)
            <a href="{{ route('products.show','slug') }}"
                class="group bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="{{ $r['bg'] }} h-36 flex items-center justify-center relative">
                    <span class="text-4xl opacity-20">{{ $r['emoji'] }}</span>
                    <div class="absolute top-2 left-2 flex flex-col gap-1">
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-brand-orange text-white">{{ $r['badge'] }}</span>
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-[9px] text-gray-400 font-medium uppercase tracking-wide mb-1">{{ $r['game'] }}</p>
                    <p class="font-heading font-bold text-xs leading-snug line-clamp-2 mb-2">{{ $r['name'] }}</p>
                    <p class="font-bold text-sm {{ $r['in_stock'] ? 'text-brand-orange' : 'text-gray-300' }}">{{ $r['price'] }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

@endsection
