@extends('layouts.admin')
@section('title','Kelola Produk')

@section('content')
@php
$activeTab = request('tab','semua');
$tabs = [
    ['key'=>'semua',   'label'=>'Semua',      'count'=>2147],
    ['key'=>'active',  'label'=>'Aktif',       'count'=>2110],
    ['key'=>'review',  'label'=>'Ditinjau',    'count'=>7],
    ['key'=>'sold',    'label'=>'Stok Habis',  'count'=>25],
    ['key'=>'inactive','label'=>'Nonaktif',    'count'=>5],
    ['key'=>'draft',   'label'=>'Draf',        'count'=>2],
];

$products = [
    ['emoji'=>'🎴','name'=>'Charizard ex SAR – Obsidian Flames SV3','sub'=>'Pokémon TCG','sku'=>'HH-SV3-228-NM','status'=>'active','statusLabel'=>'Aktif','stock'=>5,'price'=>'Rp 1.990.000'],
    ['emoji'=>'🎴','name'=>'Mewtwo ex SAR – Pokémon 151',           'sub'=>'Pokémon TCG','sku'=>'HH-151-205-NM','status'=>'active','statusLabel'=>'Aktif','stock'=>7,'price'=>'Rp 1.350.000'],
    ['emoji'=>'🎴','name'=>'Umbreon VMAX Alt Art – Evolving Skies',  'sub'=>'Pokémon TCG','sku'=>'HH-SWSH7-215-PL','status'=>'sold','statusLabel'=>'Stok Habis','stock'=>0,'price'=>'Rp 490.000'],
    ['emoji'=>'♦️','name'=>'Blossoming Calm MH2 Art Card 1/81',     'sub'=>'MTG Singles · 2 varian','sku'=>'HH-MTG-BLO-001','status'=>'review','statusLabel'=>'Ditinjau','stock'=>1,'price'=>'Rp 33.830'],
    ['emoji'=>'🎴','name'=>'Miraidon ex SAR – Scarlet & Violet SV1','sub'=>'Pokémon TCG','sku'=>'HH-SV1-253-NM','status'=>'active','statusLabel'=>'Aktif','stock'=>8,'price'=>'Rp 1.250.000'],
    ['emoji'=>'⚓','name'=>'Luffy OP-09 Secret Rare Alt Art',        'sub'=>'One Piece TCG','sku'=>'HH-OP09-LUF-SR','status'=>'active','statusLabel'=>'Aktif','stock'=>3,'price'=>'Rp 850.000'],
];

$statusBadge = [
    'active' =>'badge-active',
    'review' =>'badge-review',
    'sold'   =>'badge-cancel',
    'inactive'=>'badge-inactive',
    'draft'  =>'badge-inactive',
];
@endphp

{{-- Header --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="font-heading font-extrabold text-xl text-gray-900">Kelola Produk</h1>
        <p class="text-xs text-gray-500 mt-0.5">Semua produk yang tersedia di toko</p>
    </div>
    <div class="flex items-center gap-2">
        <button class="btn-outline text-xs py-1.5 px-3 flex items-center gap-1.5">
            <i class="fa-solid fa-file-export"></i> Ekspor
        </button>
        <a href="{{ route('admin.products.create') }}" class="btn-primary text-xs py-1.5 px-3 flex items-center gap-1.5">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>
</div>

{{-- Stats row --}}
<div class="grid grid-cols-4 gap-3 mb-5">
    @foreach([
        ['label'=>'Produk Aktif', 'value'=>'2.147','color'=>'text-green-600','bg'=>'bg-green-100','icon'=>'fa-check-circle'],
        ['label'=>'Ditinjau',     'value'=>'7',     'color'=>'text-amber-600','bg'=>'bg-amber-100','icon'=>'fa-clock'],
        ['label'=>'Stok Habis',   'value'=>'25',    'color'=>'text-red-500',  'bg'=>'bg-red-100',  'icon'=>'fa-triangle-exclamation'],
        ['label'=>'Input Hari Ini','value'=>'175',  'color'=>'text-blue-600', 'bg'=>'bg-blue-100', 'icon'=>'fa-upload'],
    ] as $s)
    <div class="card p-3 flex items-center gap-2.5">
        <div class="{{ $s['bg'] }} w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0">
            <i class="fa-solid {{ $s['icon'] }} {{ $s['color'] }} text-sm"></i>
        </div>
        <div>
            <p class="font-heading font-extrabold text-base leading-none {{ $s['color'] }}">{{ $s['value'] }}</p>
            <p class="text-[10px] text-gray-400 mt-0.5">{{ $s['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    {{-- Tabs --}}
    <div class="flex border-b border-gray-100 overflow-x-auto">
        @foreach($tabs as $tab)
        <a href="{{ route('admin.products.index', ['tab'=>$tab['key']]) }}"
            class="flex-shrink-0 px-4 py-3 text-xs border-b-2 transition flex items-center gap-1.5
                   {{ $activeTab === $tab['key']
                      ? 'border-brand-orange text-brand-orange font-semibold'
                      : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            {{ $tab['label'] }}
            <span class="text-[10px] px-1.5 py-0.5 rounded-full
                {{ $activeTab === $tab['key'] ? 'bg-orange-50 text-brand-orange' : 'bg-gray-100 text-gray-400' }}">
                {{ number_format($tab['count']) }}
            </span>
        </a>
        @endforeach
    </div>

    {{-- Toolbar --}}
    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-3 flex-wrap">
        <div class="relative flex-1 min-w-36">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]"></i>
            <input type="text" placeholder="Nama produk, ID, atau SKU…"
                class="form-input pl-8 py-1.5 text-xs"/>
        </div>
        <select class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 outline-none focus:border-brand-orange bg-white">
            <option>Semua Kategori</option>
            <option>Pokémon TCG</option>
            <option>Magic: The Gathering</option>
            <option>One Piece TCG</option>
        </select>
        <select class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 outline-none focus:border-brand-orange bg-white">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Stok Habis</option>
            <option>Nonaktif</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full min-w-[700px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="w-8 px-4 py-2.5">
                        <input type="checkbox" class="accent-brand-orange"/>
                    </th>
                    @foreach(['Info Produk','Status','Stok','Harga Jual','Tindakan'] as $h)
                    <th class="px-4 py-2.5 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wide">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($products as $i => $p)
                <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50/50 transition">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="accent-brand-orange"/>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-brand-blue rounded-lg flex items-center justify-center text-sm opacity-40 flex-shrink-0">
                                {{ $p['emoji'] }}
                            </div>
                            <div>
                                <p class="text-xs font-semibold line-clamp-1 max-w-[220px]">{{ $p['name'] }}</p>
                                <p class="text-[10px] text-gray-400">{{ $p['sub'] }}</p>
                                <p class="text-[9px] font-mono text-gray-400">{{ $p['sku'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="{{ $statusBadge[$p['status']] }} text-[10px]">{{ $p['statusLabel'] }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-xs font-semibold {{ $p['stock'] === 0 ? 'text-red-500' : 'text-gray-800' }}">
                            {{ $p['stock'] }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-xs font-semibold text-gray-800">{{ $p['price'] }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.products.edit', $i + 1) }}"
                                class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-gray-500 hover:border-brand-orange hover:text-brand-orange transition">
                                <i class="fa-regular fa-pen-to-square text-[10px]"></i>
                            </a>
                            <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-gray-500 hover:border-gray-300 transition">
                                <i class="fa-solid fa-ellipsis text-[10px]"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-4 py-3 border-t border-gray-100 flex items-center justify-between">
        <p class="text-[11px] text-gray-500">Menampilkan 6 dari 2.147 produk</p>
        <div class="flex gap-1">
            @foreach([1,2,3,'…',50] as $pg)
            <button class="w-7 h-7 rounded-lg text-[11px] font-semibold border transition
                {{ $pg === 1 ? 'bg-brand-orange text-white border-brand-orange' : 'bg-white text-gray-600 border-gray-200 hover:border-brand-orange hover:text-brand-orange' }}">
                {{ $pg }}
            </button>
            @endforeach
            <button class="w-7 h-7 rounded-lg text-[11px] border border-gray-200 bg-white text-gray-600 hover:border-brand-orange hover:text-brand-orange transition">
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
            </button>
        </div>
    </div>
</div>

@endsection
