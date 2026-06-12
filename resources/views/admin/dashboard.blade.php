@extends('layouts.admin')
@section('title','Dashboard')

@section('content')
@php
$stats = [
    ['icon'=>'fa-bag-shopping',       'bg'=>'bg-orange-100','color'=>'text-brand-orange','value'=>'12',     'label'=>'Perlu Diproses'],
    ['icon'=>'fa-boxes-stacked',      'bg'=>'bg-green-100', 'color'=>'text-green-600',  'value'=>'2.147',  'label'=>'Produk Aktif'],
    ['icon'=>'fa-triangle-exclamation','bg'=>'bg-red-100',  'color'=>'text-red-500',    'value'=>'25',     'label'=>'Stok Habis'],
    ['icon'=>'fa-upload',             'bg'=>'bg-blue-100',  'color'=>'text-blue-600',   'value'=>'175 SKU','label'=>'Input Hari Ini'],
];

$recentOrders = [
    ['id'=>'#HH-001','emoji'=>'🎴','product'=>'Charizard ex SAR – SV3','buyer'=>'Andi P · Surabaya','total'=>'Rp 1.990.000','status'=>'pending','statusLabel'=>'Perlu Dikirim'],
    ['id'=>'#HH-002','emoji'=>'🎴','product'=>'Mewtwo ex SAR – 151',   'buyer'=>'Budi S · Jakarta', 'total'=>'Rp 2.700.000','status'=>'shipped','statusLabel'=>'Dikirim'],
    ['id'=>'#HH-003','emoji'=>'🎴','product'=>'Gardevoir ex SAR – SV2','buyer'=>'Citra R · Bandung','total'=>'Rp 1.150.000','status'=>'completed','statusLabel'=>'Selesai'],
];

$lowStocks = [
    ['emoji'=>'🎴','name'=>'Umbreon VMAX Alt Art – SWSH7','stock'=>0, 'status'=>'sold',  'statusLabel'=>'Stok Habis'],
    ['emoji'=>'🐉','name'=>'Digimon P-193 Promo',         'stock'=>1, 'status'=>'review','statusLabel'=>'Stok 1'],
    ['emoji'=>'⚓','name'=>'One Piece P-069 Koala',        'stock'=>2, 'status'=>'review','statusLabel'=>'Stok 2'],
];

$statusBadge = [
    'pending'   => 'badge-pending',
    'shipped'   => 'badge-shipped',
    'completed' => 'badge-done',
    'sold'      => 'badge-cancel',
    'review'    => 'badge-review',
];
@endphp

{{-- Page header --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="font-heading font-extrabold text-xl text-gray-900">Beranda</h1>
        <p class="text-xs text-gray-500 mt-0.5">Selamat datang kembali — {{ now()->isoFormat('dddd, D MMMM Y') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}"
        class="btn-primary text-xs px-3 py-1.5 flex items-center gap-1.5">
        <i class="fa-solid fa-bag-shopping"></i> Kelola Pesanan
    </a>
</div>

{{-- Stats grid --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach($stats as $s)
    <div class="card p-4 flex items-center gap-3">
        <div class="{{ $s['bg'] }} w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid {{ $s['icon'] }} {{ $s['color'] }} text-base"></i>
        </div>
        <div>
            <p class="font-heading font-extrabold text-xl leading-none {{ $s['color'] }}">{{ $s['value'] }}</p>
            <p class="text-[11px] text-gray-500 mt-0.5">{{ $s['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Tables row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

    {{-- Recent orders --}}
    <div class="card overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-heading font-bold text-sm">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-brand-orange font-semibold hover:underline">
                Lihat Semua <i class="fa-solid fa-arrow-right text-[10px] ml-0.5"></i>
            </a>
        </div>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    @foreach(['','Produk','Status','Total'] as $h)
                    <th class="px-4 py-2.5 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wide">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $o)
                <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50/50 transition">
                    <td class="px-4 py-3">
                        <div class="w-8 h-8 bg-brand-blue rounded-lg flex items-center justify-center text-base opacity-40">{{ $o['emoji'] }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-xs font-semibold line-clamp-1">{{ $o['product'] }}</p>
                        <p class="text-[10px] text-gray-400">{{ $o['buyer'] }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <span class="{{ $statusBadge[$o['status']] }} text-[10px]">{{ $o['statusLabel'] }}</span>
                    </td>
                    <td class="px-4 py-3 font-semibold text-xs text-brand-orange">{{ $o['total'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Low stock --}}
    <div class="card overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-heading font-bold text-sm">Stok Hampir Habis</h2>
            <a href="{{ route('admin.products.index') }}" class="text-xs text-brand-orange font-semibold hover:underline">
                Kelola <i class="fa-solid fa-arrow-right text-[10px] ml-0.5"></i>
            </a>
        </div>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    @foreach(['','Produk','Stok'] as $h)
                    <th class="px-4 py-2.5 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wide">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($lowStocks as $ls)
                <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50/50 transition">
                    <td class="px-4 py-3">
                        <div class="w-8 h-8 bg-brand-blue rounded-lg flex items-center justify-center text-base opacity-40">{{ $ls['emoji'] }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-xs font-semibold line-clamp-1">{{ $ls['name'] }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <span class="{{ $statusBadge[$ls['status']] }} text-[10px]">{{ $ls['statusLabel'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- PIC Progress --}}
<div class="card overflow-hidden mt-4">
    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-heading font-bold text-sm">Kinerja PIC Hari Ini</h2>
        <div class="flex items-center gap-1.5 text-[10px] text-green-600 font-semibold">
            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
            Live
        </div>
    </div>
    <div class="p-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @foreach([
                ['init'=>'AB','bg'=>'bg-brand-orange','name'=>'Admin Budi','count'=>150,'target'=>175,'sessions'=>3,'time'=>'09:31 WIB'],
                ['init'=>'AS','bg'=>'bg-purple-500',  'name'=>'Admin Siti','count'=>25, 'target'=>175,'sessions'=>1,'time'=>'08:57 WIB'],
                ['init'=>'AR','bg'=>'bg-gray-600',    'name'=>'Admin Reza','count'=>0,  'target'=>175,'sessions'=>0,'time'=>'—'],
            ] as $pic)
            @php $pct = round($pic['count'] / $pic['target'] * 100); @endphp
            <div class="bg-gray-50 rounded-xl p-3.5 border border-gray-100">
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="{{ $pic['bg'] }} w-8 h-8 rounded-lg flex items-center justify-center font-heading font-black text-xs text-white flex-shrink-0">
                        {{ $pic['init'] }}
                    </div>
                    <div>
                        <p class="text-xs font-semibold">{{ $pic['name'] }}</p>
                        <p class="text-[10px] text-gray-400">{{ $pic['sessions'] }} sesi · {{ $pic['time'] }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-end mb-1">
                    <span class="font-heading font-extrabold text-lg text-gray-800">{{ $pic['count'] }}</span>
                    <span class="text-[10px] text-gray-400">/ {{ $pic['target'] }} SKU</span>
                </div>
                <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $pct >= 100 ? 'bg-green-500' : ($pct >= 60 ? 'bg-brand-orange' : 'bg-gray-400') }} transition-all"
                        style="width: {{ min($pct, 100) }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1 text-right">{{ $pct }}%</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
