@extends('layouts.admin')
@section('title','Kelola Pesanan')

@section('content')
@php
$activeTab = request('tab','semua');
$tabs = [
    ['key'=>'semua',   'label'=>'Semua',        'count'=>12],
    ['key'=>'pending', 'label'=>'Perlu Dikirim', 'count'=>3],
    ['key'=>'shipped', 'label'=>'Dikirim',       'count'=>6],
    ['key'=>'done',    'label'=>'Selesai',       'count'=>2],
    ['key'=>'cancel',  'label'=>'Dibatalkan',    'count'=>1],
];

$alerts = [
    ['label'=>'Harus dikirim',  'value'=>'3', 'color'=>'text-brand-orange'],
    ['label'=>'Pembatalan',     'value'=>'0', 'color'=>'text-gray-700'],
    ['label'=>'Kirim terlambat','value'=>'1', 'color'=>'text-red-500'],
    ['label'=>'Masalah logistik','value'=>'0','color'=>'text-gray-700'],
    ['label'=>'Pengembalian',   'value'=>'2', 'color'=>'text-gray-700'],
];

$orders = [
    ['id'=>'#HH-20260526-001','expedition'=>'J&T Express','emoji'=>'🎴','product'=>'Charizard ex SAR – SV3','qty'=>'×1','buyer'=>'Andi Prasetyo','city'=>'Surabaya','total'=>'Rp 1.990.000','status'=>'pending','statusLabel'=>'Perlu Dikirim','date'=>'26 Mei 2026<br/>09:42 WIB','can_process'=>true],
    ['id'=>'#HH-20260524-008','expedition'=>'JNE REG','emoji'=>'🐉','product'=>'Digimon BT15-097','qty'=>'×4','buyer'=>'Budi Santoso','city'=>'Jakarta Selatan','total'=>'Rp 30.200','status'=>'shipped','statusLabel'=>'Dikirim','date'=>'24 Mei 2026<br/>14:20 WIB','can_process'=>false],
    ['id'=>'#HH-20260510-003','expedition'=>'SiCepat REG','emoji'=>'⚓','product'=>'One Piece P-069','qty'=>'×2','buyer'=>'Citra Rahayu','city'=>'Bandung','total'=>'Rp 70.400','status'=>'done','statusLabel'=>'Selesai','date'=>'10 Mei 2026<br/>11:05 WIB','can_process'=>false],
    ['id'=>'#HH-20260501-011','expedition'=>'AnterAja','emoji'=>'🃏','product'=>'Shadowverse SD02-005','qty'=>'×3','buyer'=>'Doni Kurniawan','city'=>'Yogyakarta','total'=>'Rp 202.500','status'=>'cancel','statusLabel'=>'Dibatalkan','date'=>'1 Mei 2026<br/>08:33 WIB','can_process'=>false],
];

$statusBadge = [
    'pending' => 'badge-pending',
    'shipped' => 'badge-shipped',
    'done'    => 'badge-done',
    'cancel'  => 'badge-cancel',
];
@endphp

{{-- Header --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="font-heading font-extrabold text-xl text-gray-900">Kelola Pesanan</h1>
        <p class="text-xs text-gray-500 mt-0.5">Pantau dan proses semua pesanan masuk</p>
    </div>
    <button class="btn-outline text-xs py-1.5 px-3 flex items-center gap-1.5">
        <i class="fa-solid fa-file-export"></i> Ekspor CSV
    </button>
</div>

{{-- Alert banner --}}
<div class="card p-4 mb-5">
    <div class="flex items-center gap-2 mb-2">
        <i class="fa-solid fa-triangle-exclamation text-amber-500 text-sm"></i>
        <span class="text-xs font-semibold text-gray-700">Perlu Perhatian Hari Ini</span>
    </div>
    <div class="grid grid-cols-5 gap-4">
        @foreach($alerts as $al)
        <div class="text-center p-2 bg-gray-50 rounded-xl">
            <p class="font-heading font-extrabold text-xl {{ $al['color'] }}">{{ $al['value'] }}</p>
            <p class="text-[10px] text-gray-500 mt-0.5">{{ $al['label'] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    {{-- Tabs --}}
    <div class="flex border-b border-gray-100 overflow-x-auto">
        @foreach($tabs as $tab)
        <a href="{{ route('admin.orders.index', ['tab'=>$tab['key']]) }}"
            class="flex-shrink-0 px-4 py-3 text-xs border-b-2 transition flex items-center gap-1.5
                   {{ $activeTab === $tab['key']
                      ? 'border-brand-orange text-brand-orange font-semibold'
                      : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            {{ $tab['label'] }}
            <span class="text-[10px] px-1.5 py-0.5 rounded-full
                {{ $activeTab === $tab['key'] ? 'bg-orange-50 text-brand-orange' : 'bg-gray-100 text-gray-400' }}">
                {{ $tab['count'] }}
            </span>
        </a>
        @endforeach
    </div>

    {{-- Toolbar --}}
    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-3 flex-wrap">
        <div class="relative flex-1 min-w-36">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]"></i>
            <input type="text" placeholder="No. pesanan, nama pembeli…"
                class="form-input pl-8 py-1.5 text-xs"/>
        </div>
        <select class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 outline-none focus:border-brand-orange bg-white">
            <option>Semua Ekspedisi</option>
            <option>JNE</option>
            <option>J&T Express</option>
            <option>SiCepat</option>
            <option>AnterAja</option>
        </select>
        <input type="date" class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 outline-none focus:border-brand-orange bg-white"/>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full min-w-[820px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="w-8 px-4 py-2.5">
                        <input type="checkbox" class="accent-brand-orange"/>
                    </th>
                    @foreach(['No. Pesanan','Produk','Pembeli','Total','Status','Tanggal','Aksi'] as $h)
                    <th class="px-4 py-2.5 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wide">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $o)
                <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50/50 transition">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="accent-brand-orange"/>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-[11px] font-bold font-mono text-brand-orange">{{ $o['id'] }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $o['expedition'] }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-brand-blue rounded-lg flex items-center justify-center text-sm opacity-40 flex-shrink-0">{{ $o['emoji'] }}</div>
                            <div>
                                <p class="text-xs font-semibold line-clamp-1 max-w-[160px]">{{ $o['product'] }}</p>
                                <p class="text-[10px] text-gray-400">{{ $o['qty'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-xs font-semibold">{{ $o['buyer'] }}</p>
                        <p class="text-[10px] text-gray-400">{{ $o['city'] }}</p>
                    </td>
                    <td class="px-4 py-3 text-xs font-semibold text-brand-orange">{{ $o['total'] }}</td>
                    <td class="px-4 py-3">
                        <span class="{{ $statusBadge[$o['status']] }} text-[10px]">{{ $o['statusLabel'] }}</span>
                    </td>
                    <td class="px-4 py-3 text-[10px] text-gray-500 leading-relaxed">{!! $o['date'] !!}</td>
                    <td class="px-4 py-3">
                        @if($o['can_process'])
                        <button class="btn-primary text-[10px] py-1.5 px-3">Proses</button>
                        @else
                        <button class="btn-outline text-[10px] py-1.5 px-3">Detail</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-4 py-3 border-t border-gray-100 flex items-center justify-between">
        <p class="text-[11px] text-gray-500">Menampilkan 4 dari 12 pesanan</p>
        <div class="flex gap-1">
            @foreach([1,2] as $pg)
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
