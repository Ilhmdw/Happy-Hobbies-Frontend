@extends('layouts.customer')
@section('title','Pesanan Saya')

@section('content')
@php
$activeTab = request('status','semua');
$orders = [
    ['id'=>'HH-20260526-001','date'=>'26 Mei 2025, 14:32 WIB','emoji'=>'🎴','product'=>'Charizard ex SAR – Obsidian Flames SV3','sub'=>'x1 · JNE REG','total'=>2004000,'status'=>'pending_payment','expire'=>'20 Mei 2025, 16:32 WIB (sisa 23:12)'],
    ['id'=>'HH-20260518-003','date'=>'18 Mei 2025, 10:15 WIB','emoji'=>'♦️','product'=>'Blossoming Calm MH2 Art Card 1/81 · NORMAL JP','sub'=>'x2 · JNE REG · Resi: JNE1234567890','total'=>81660,'status'=>'shipped','resi'=>'JNE1234567890'],
    ['id'=>'HH-20260510-005','date'=>'10 Mei 2025, 09:00 WIB','emoji'=>'🐉','product'=>'Digimon BT15-097 Ultimate Slicer Common','sub'=>'x4 · SiCepat REG','total'=>30200,'status'=>'completed'],
    ['id'=>'HH-20260501-011','date'=>'1 Mei 2025, 08:15 WIB','emoji'=>'🃏','product'=>'Shadowverse SD02-005 Moonlight Assassin S','sub'=>'x3 · Dibatalkan oleh pembeli','total'=>202500,'status'=>'cancelled'],
];

$tabs = [
    ['key'=>'semua',           'label'=>'Semua'],
    ['key'=>'pending_payment', 'label'=>'Menunggu Bayar'],
    ['key'=>'processing',      'label'=>'Diproses'],
    ['key'=>'shipped',         'label'=>'Dikirim'],
    ['key'=>'completed',       'label'=>'Selesai'],
    ['key'=>'cancelled',       'label'=>'Dibatalkan'],
];

$statusConfig = [
    'pending_payment' => ['label'=>'Menunggu Pembayaran','class'=>'badge-pending'],
    'processing'      => ['label'=>'Diproses',           'class'=>'badge-review'],
    'shipped'         => ['label'=>'Dikirim',            'class'=>'badge-shipped'],
    'completed'       => ['label'=>'Selesai',            'class'=>'badge-done'],
    'cancelled'       => ['label'=>'Dibatalkan',         'class'=>'badge-cancel'],
];

$filtered = $activeTab === 'semua' ? $orders : array_filter($orders, fn($o) => $o['status'] === $activeTab);
@endphp

<div class="bg-brand-dark py-5 px-4">
    <div class="max-w-5xl mx-auto">
        <h1 class="font-heading font-extrabold text-xl text-white">Pesanan Saya</h1>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Sidebar (same as account) --}}
        <div class="hidden md:block space-y-3">
            <div class="card overflow-hidden">
                @foreach([
                    ['route'=>'account.index',    'icon'=>'fa-user',        'label'=>'Profil Saya'],
                    ['route'=>'account.addresses','icon'=>'fa-map-pin',     'label'=>'Alamat'],
                    ['route'=>'account.orders',   'icon'=>'fa-bag-shopping','label'=>'Pesanan Saya','active'=>true],
                    ['route'=>'account.password', 'icon'=>'fa-lock',        'label'=>'Ganti Password'],
                ] as $nav)
                <a href="{{ route($nav['route']) }}"
                    class="flex items-center gap-2.5 px-4 py-2.5 text-sm border-b border-gray-100 last:border-b-0 transition
                           {{ isset($nav['active']) ? 'bg-orange-50 text-brand-orange font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid {{ $nav['icon'] }} w-4 text-center text-xs {{ isset($nav['active']) ? 'text-brand-orange' : 'text-gray-400' }}"></i>
                    {{ $nav['label'] }}
                </a>
                @endforeach
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center text-xs"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        {{-- Orders Content --}}
        <div class="md:col-span-3">
            {{-- Tabs --}}
            <div class="flex overflow-x-auto border-b border-gray-200 mb-4 gap-0 scrollbar-hide">
                @foreach($tabs as $tab)
                <a href="{{ route('account.orders', ['status'=>$tab['key']]) }}"
                    class="flex-shrink-0 pb-2.5 px-3 text-xs border-b-2 transition whitespace-nowrap
                           {{ $activeTab === $tab['key']
                              ? 'border-brand-orange text-brand-orange font-semibold'
                              : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    {{ $tab['label'] }}
                </a>
                @endforeach
            </div>

            {{-- Order list --}}
            @if(count($filtered) === 0)
            <div class="text-center py-16">
                <div class="text-5xl mb-4 opacity-30">📦</div>
                <p class="font-heading font-bold text-gray-500">Belum ada pesanan</p>
                <p class="text-xs text-gray-400 mt-1 mb-4">Yuk mulai belanja kartu TCG favoritmu!</p>
                <a href="{{ route('products.index') }}" class="btn-primary text-sm px-5">
                    Lihat Produk
                </a>
            </div>
            @else
            <div class="space-y-3">
                @foreach($filtered as $order)
                @php
                    $sc = $statusConfig[$order['status']];
                    $isCancelled = $order['status'] === 'cancelled';
                @endphp
                <div class="card {{ $isCancelled ? 'bg-red-50/30 border-red-100' : '' }}">
                    {{-- Order header --}}
                    <div class="px-4 py-3 border-b border-gray-100 flex items-start justify-between">
                        <div>
                            <span class="text-xs font-bold font-mono {{ $isCancelled ? 'text-red-500' : 'text-brand-orange' }}">
                                #{{ $order['id'] }}
                            </span>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $order['date'] }}</p>
                        </div>
                        <span class="{{ $sc['class'] }} text-[10px]">{{ $sc['label'] }}</span>
                    </div>

                    {{-- Product --}}
                    <div class="px-4 py-3">
                        <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3 mb-3">
                            <div class="w-11 h-11 bg-brand-blue rounded-lg flex items-center justify-center text-xl flex-shrink-0 opacity-60">
                                {{ $order['emoji'] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold leading-snug line-clamp-2">{{ $order['product'] }}</p>
                                <p class="text-[10px] text-gray-500 mt-0.5">{{ $order['sub'] }}</p>
                                @if($order['status'] === 'pending_payment' && isset($order['expire']))
                                <p class="text-[10px] text-red-500 mt-0.5">
                                    <i class="fa-regular fa-clock mr-0.5"></i>
                                    Bayar sebelum: {{ $order['expire'] }}
                                </p>
                                @endif
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] text-gray-500">Total Pembayaran</p>
                                <p class="text-sm font-bold {{ $isCancelled ? 'text-red-500' : 'text-brand-orange' }}">
                                    Rp {{ number_format($order['total'],0,',','.') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($order['status'] === 'pending_payment')
                                <button class="btn-outline text-xs py-1.5 px-3 border-red-200 text-red-500 hover:bg-red-50">
                                    Batalkan
                                </button>
                                <button class="btn-primary text-xs py-1.5 px-3 flex items-center gap-1">
                                    <i class="fa-solid fa-credit-card text-[10px]"></i> Bayar Sekarang
                                </button>
                                @elseif($order['status'] === 'shipped')
                                <button class="btn-outline text-xs py-1.5 px-3 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-[10px]"></i> Lacak Paket
                                </button>
                                <button class="btn-dark text-xs py-1.5 px-3">
                                    Konfirmasi Terima
                                </button>
                                @elseif($order['status'] === 'completed')
                                <button class="btn-outline text-xs py-1.5 px-3">
                                    Lihat Detail
                                </button>
                                @elseif($order['status'] === 'cancelled')
                                <span class="text-[10px] text-gray-400 italic">Stok dikembalikan ke sistem</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
