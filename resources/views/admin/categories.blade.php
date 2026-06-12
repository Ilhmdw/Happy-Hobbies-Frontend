@extends('layouts.admin')
@section('title','Kelola Kategori')

@section('content')
@php
$categories = [
    ['id'=>1,'emoji'=>'⚡','name'=>'Pokémon TCG',   'subs'=>['Single Card','Sealed Box','Booster Pack','Promo'],'count'=>850,'active'=>true, 'new'=>false],
    ['id'=>2,'emoji'=>'♦️','name'=>'Magic: The Gathering','subs'=>['Single Card','Art Card'],'count'=>200,'active'=>true,'new'=>false],
    ['id'=>3,'emoji'=>'🐉','name'=>'Dragon Ball TCG','subs'=>['Single Card'],                'count'=>24, 'active'=>false,'new'=>true],
    ['id'=>4,'emoji'=>'🐉','name'=>'Digimon TCG',   'subs'=>['Single Card','Booster Pack','Promo'],'count'=>180,'active'=>true,'new'=>false],
    ['id'=>5,'emoji'=>'⚓','name'=>'One Piece TCG',  'subs'=>['Single Card','Booster Pack','Sealed Box'],'count'=>310,'active'=>true,'new'=>false],
    ['id'=>6,'emoji'=>'🎴','name'=>'Yu-Gi-Oh!',     'subs'=>['Single Card','Sealed Box'],   'count'=>420,'active'=>true,'new'=>false],
    ['id'=>7,'emoji'=>'🃏','name'=>'Shadowverse Evolved','subs'=>['Single Card','Sealed Box'],'count'=>120,'active'=>true,'new'=>false],
    ['id'=>8,'emoji'=>'🎪','name'=>'Aksesoris',     'subs'=>['Sleeve','Binder','Playmat'],  'count'=>80, 'active'=>true,'new'=>false],
];
@endphp

{{-- Header --}}
<div class="flex items-start justify-between mb-5">
    <div>
        <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-1">
            <span class="text-brand-orange">Pengaturan Toko</span>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span>Kelola Kategori</span>
        </div>
        <h1 class="font-heading font-extrabold text-xl text-gray-900">Kelola Kategori</h1>
        <p class="text-xs text-gray-500 mt-0.5">Aktifkan / nonaktifkan kategori yang muncul di katalog customer</p>
    </div>
    <button class="btn-primary text-xs py-1.5 px-3 flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </button>
</div>

{{-- Info banner --}}
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4 flex items-start gap-3 text-xs text-blue-700">
    <i class="fa-solid fa-circle-info mt-0.5 flex-shrink-0"></i>
    <div>
        <strong>Kategori Nonaktif</strong> tidak tampil di halaman browsing katalog, namun produknya tetap bisa ditemukan
        via <strong>Search</strong>. Aktifkan di sini setelah produknya siap ditampilkan.
    </div>
</div>

{{-- Alert kategori baru dari Excel --}}
@if(collect($categories)->where('new', true)->count() > 0)
<div class="bg-amber-50 border border-amber-300 rounded-xl p-4 mb-4 flex items-center gap-3 text-xs text-amber-800">
    <i class="fa-solid fa-triangle-exclamation flex-shrink-0"></i>
    <div class="flex-1">
        <strong>{{ collect($categories)->where('new', true)->count() }} kategori baru</strong> dari bulk upload Excel
        menunggu aktivasi:
        @foreach($categories as $cat)
            @if($cat['new'])<strong>{{ $cat['emoji'] }} {{ $cat['name'] }}</strong> ({{ $cat['count'] }} produk)@endif
        @endforeach
    </div>
    <button class="btn-outline text-[11px] py-1 px-3 border-amber-400 text-amber-800 hover:bg-amber-100">
        Tinjau
    </button>
</div>
@endif

{{-- Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[700px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="w-8 px-4 py-2.5">
                        <input type="checkbox" class="accent-brand-orange"/>
                    </th>
                    @foreach(['Kategori & Sub-Kategori','Jumlah Produk','Status di Katalog','Aksi'] as $h)
                    <th class="px-4 py-2.5 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wide">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50/50 transition {{ $cat['new'] ? 'bg-amber-50/30' : '' }}"
                    x-data="{ active: {{ $cat['active'] ? 'true' : 'false' }} }">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="accent-brand-orange"/>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-start gap-2 mb-1.5">
                            <span class="font-heading font-bold text-sm">{{ $cat['emoji'] }} {{ $cat['name'] }}</span>
                            @if($cat['new'])
                            <span class="text-[9px] font-bold px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full border border-amber-300 flex-shrink-0">
                                Baru dari Excel
                            </span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-1.5 mb-1">
                            @foreach($cat['subs'] as $sub)
                            <span class="text-[10px] px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full">{{ $sub }}</span>
                            @endforeach
                            <button class="text-[10px] text-brand-orange font-semibold hover:underline">+ sub</button>
                        </div>
                        @if($cat['new'])
                        <p class="text-[10px] text-amber-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-info"></i>
                            Bisa dicari via search · belum muncul di browsing katalog
                        </p>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-heading font-extrabold text-base text-gray-800">{{ number_format($cat['count']) }}</span>
                        <span class="text-xs text-gray-400 ml-1">produk</span>
                    </td>
                    <td class="px-4 py-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            {{-- Toggle --}}
                            <button @click="active = !active"
                                :class="active ? 'bg-brand-orange' : 'bg-gray-300'"
                                class="relative w-9 h-5 rounded-full transition-colors duration-200 flex-shrink-0">
                                <span :class="active ? 'translate-x-4' : 'translate-x-0.5'"
                                    class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow-sm transition-transform duration-200 block"></span>
                            </button>
                            <span :class="active ? 'text-brand-orange font-semibold' : 'text-gray-400'"
                                class="text-xs transition-colors" x-text="active ? 'Aktif' : 'Nonaktif'"></span>
                        </label>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-1.5">
                            <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-gray-500 hover:border-brand-orange hover:text-brand-orange transition">
                                <i class="fa-regular fa-pen-to-square text-[10px]"></i>
                            </button>
                            <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-red-400 hover:border-red-300 hover:bg-red-50 transition">
                                <i class="fa-solid fa-trash text-[10px]"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100 flex items-center justify-between">
        <p class="text-[11px] text-gray-500">Menampilkan {{ count($categories) }} dari {{ count($categories) }} kategori</p>
        <p class="text-[11px] text-gray-400">Total: {{ number_format(array_sum(array_column($categories, 'count'))) }} produk</p>
    </div>
</div>

@endsection
