@extends('layouts.customer')
@section('title', 'Checkout')

@section('content')

@php
$cartItems = [
    ['emoji'=>'🎴','name'=>'Charizard ex SAR – Obsidian Flames SV3','variant'=>null,'qty'=>1,'price'=>1990000],
    ['emoji'=>'⚓','name'=>'One Piece Promo P-069 Koala Single Card','variant'=>null,'qty'=>2,'price'=>29700],
];
$subtotal   = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cartItems));
$shipping   = 12000;
$insurance  = 2050;
$total      = $subtotal + $shipping + $insurance;

$addresses = [
    ['id'=>1,'label'=>'Rumah','name'=>'Ilham Dwitarama','phone'=>'+6285179729956','address'=>'Gg. III No.44C, Kendangsari, Kec. Tenggilis Mejoyo, Surabaya, Jawa Timur 60292','is_default'=>true],
    ['id'=>2,'label'=>'Kantor','name'=>'Ilham DW','phone'=>'+6285179729956','address'=>'Kampus EEPIS, Sukolilo, Surabaya, Jawa Timur 60111','is_default'=>false],
];

$shippingOptions = [
    ['code'=>'jne','logo'=>'JNE','color'=>'bg-red-600','name'=>'JNE REG','est'=>'1–2 hari kerja','price'=>14000],
    ['code'=>'jnt','logo'=>'J&T','color'=>'bg-blue-600','name'=>'J&T Express','est'=>'1–3 hari kerja','price'=>12000],
    ['code'=>'sicepat','logo'=>'SiCepat','color'=>'bg-orange-500','name'=>'SiCepat REG','est'=>'1–2 hari kerja','price'=>11000],
    ['code'=>'anteraja','logo'=>'AnterAja','color'=>'bg-yellow-500','name'=>'AnterAja REG','est'=>'2–3 hari kerja','price'=>10000],
];
@endphp

{{-- Checkout secure bar --}}
<div class="bg-white border-b border-gray-100 py-3 px-4">
    <div class="max-w-5xl mx-auto flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="w-6 h-6 bg-brand-yellow rounded-md flex items-center justify-center">
                <span class="font-heading font-black text-brand-dark text-[8px]">HH</span>
            </div>
            <span class="font-heading font-bold text-brand-dark text-sm">
                <span class="text-brand-orange">Happy</span>Hobbies
            </span>
        </a>
        <div class="flex items-center gap-1.5 text-xs text-gray-400">
            <i class="fa-solid fa-lock text-brand-orange text-xs"></i>
            Checkout Aman
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-6" x-data="{ step: 2, selectedAddr: 1, selectedShipping: 'jnt', discount: '' }">

    {{-- ── STEP INDICATOR ── --}}
    <div class="flex items-center mb-8">
        @foreach([['num'=>1,'label'=>'Informasi'],['num'=>2,'label'=>'Alamat'],['num'=>3,'label'=>'Pengiriman'],['num'=>4,'label'=>'Bayar']] as $s)
        @php $isLast = $s['num'] === 4; @endphp
        <div class="flex items-center {{ $isLast ? '' : 'flex-1' }}">
            <div class="flex items-center gap-2">
                <div :class="{
                    'bg-brand-orange text-white': step >= {{ $s['num'] }},
                    'bg-gray-100 text-gray-400': step < {{ $s['num'] }}
                }" class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold flex-shrink-0 transition-colors">
                    <template x-if="step > {{ $s['num'] }}">
                        <i class="fa-solid fa-check text-[9px]"></i>
                    </template>
                    <template x-if="step <= {{ $s['num'] }}">
                        <span>{{ $s['num'] }}</span>
                    </template>
                </div>
                <span :class="step === {{ $s['num'] }} ? 'text-gray-800 font-semibold' : 'text-gray-400'"
                    class="text-xs hidden sm:block transition-colors">{{ $s['label'] }}</span>
            </div>
            @if(!$isLast)
            <div :class="step > {{ $s['num'] }} ? 'bg-brand-orange' : 'bg-gray-200'"
                class="flex-1 h-px mx-2 transition-colors"></div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── LEFT: Form Steps ── --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- STEP 1: Info --}}
            <div class="card overflow-visible">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-heading font-bold text-sm">Informasi Umum</h3>
                    <span x-show="step > 1" class="badge-done text-[10px]"><i class="fa-solid fa-check mr-1"></i>Selesai</span>
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3">
                        <div class="w-8 h-8 bg-brand-orange rounded-lg flex items-center justify-center text-white font-heading font-black text-xs flex-shrink-0">I</div>
                        <div>
                            <p class="text-sm font-semibold">Ilham Dwitarama</p>
                            <p class="text-xs text-gray-500">mieindo340@gmail.com · +6285179729956</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 2: Alamat --}}
            <div class="card overflow-visible">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-heading font-bold text-sm">Pilih Alamat Pengiriman</h3>
                    <button class="text-xs text-brand-orange font-semibold hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-plus text-[10px]"></i> Tambah Alamat
                    </button>
                </div>
                <div class="p-4 space-y-2.5">
                    @foreach($addresses as $addr)
                    <label :class="selectedAddr === {{ $addr['id'] }} ? 'border-brand-orange bg-orange-50/50' : 'border-gray-200 hover:border-gray-300'"
                        class="block border-2 rounded-xl p-3.5 cursor-pointer transition-all relative">
                        <input type="radio" x-model="selectedAddr" value="{{ $addr['id'] }}" class="hidden"/>
                        <div :class="selectedAddr === {{ $addr['id'] }} ? 'border-brand-orange bg-brand-orange' : 'border-gray-300 bg-white'"
                            class="absolute top-3.5 right-3.5 w-4 h-4 rounded-full border-2 flex items-center justify-center transition">
                            <div x-show="selectedAddr === {{ $addr['id'] }}" class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-[10px] px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full font-semibold">
                                {{ $addr['label'] === 'Rumah' ? '🏠' : '🏢' }} {{ $addr['label'] }}
                            </span>
                            @if($addr['is_default'])
                            <span class="text-[10px] px-2 py-0.5 bg-brand-yellow text-brand-dark rounded-full font-bold">Utama</span>
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-800">{{ $addr['name'] }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $addr['phone'] }}</p>
                        <p class="text-xs text-gray-500 leading-relaxed mt-1">{{ $addr['address'] }}</p>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- STEP 3: Pengiriman --}}
            <div class="card overflow-visible">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-heading font-bold text-sm">
                        Metode Pengiriman
                        <span class="text-[10px] text-gray-400 font-normal ml-1">via RajaOngkir API</span>
                    </h3>
                </div>
                <div class="p-4 space-y-2">
                    @foreach($shippingOptions as $opt)
                    <label :class="selectedShipping === '{{ $opt['code'] }}' ? 'border-brand-orange bg-orange-50/50' : 'border-gray-200 hover:border-gray-300'"
                        class="flex items-center gap-3 border-2 rounded-xl p-3 cursor-pointer transition-all">
                        <input type="radio" x-model="selectedShipping" value="{{ $opt['code'] }}" class="hidden"/>
                        <div :class="selectedShipping === '{{ $opt['code'] }}' ? 'border-brand-orange bg-brand-orange' : 'border-gray-300 bg-white'"
                            class="w-4 h-4 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition">
                            <div x-show="selectedShipping === '{{ $opt['code'] }}'" class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                        <div class="{{ $opt['color'] }} text-white rounded px-2 py-1 text-[9px] font-bold w-12 text-center flex-shrink-0">
                            {{ $opt['logo'] }}
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-semibold">{{ $opt['name'] }}</p>
                            <p class="text-[10px] text-gray-500">Estimasi {{ $opt['est'] }}</p>
                        </div>
                        <span class="text-sm font-bold text-brand-orange flex-shrink-0">
                            Rp {{ number_format($opt['price'],0,',','.') }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ── RIGHT: Summary ── --}}
        <div class="space-y-4">
            <div class="card sticky top-20">
                <div class="px-4 py-3.5 border-b border-gray-100">
                    <h3 class="font-heading font-bold text-sm">Ringkasan Pesanan</h3>
                </div>
                <div class="p-4">
                    {{-- Items --}}
                    <div class="space-y-3 mb-4">
                        @foreach($cartItems as $item)
                        <div class="flex gap-3">
                            <div class="w-10 h-10 bg-brand-blue rounded-lg flex items-center justify-center text-lg flex-shrink-0 opacity-60">
                                {{ $item['emoji'] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] font-semibold leading-snug line-clamp-2">{{ $item['name'] }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">×{{ $item['qty'] }}</p>
                            </div>
                            <span class="text-xs font-bold text-brand-orange flex-shrink-0">
                                Rp {{ number_format($item['price'] * $item['qty'],0,',','.') }}
                            </span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-3 space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal produk</span>
                            <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Ongkir (J&T Express)</span>
                            <span>Rp {{ number_format($shipping,0,',','.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Asuransi pengiriman</span>
                            <span>Rp {{ number_format($insurance,0,',','.') }}</span>
                        </div>
                    </div>

                    {{-- Discount code --}}
                    <div class="flex gap-2 mt-3">
                        <input type="text" x-model="discount" placeholder="Kode diskon?"
                            class="flex-1 text-xs border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-brand-orange transition"/>
                        <button class="btn-dark text-[11px] px-3 py-2 flex-shrink-0">Pakai</button>
                    </div>

                    <div class="border-t border-gray-100 mt-3 pt-3 flex justify-between font-heading font-extrabold text-base">
                        <span>Total</span>
                        <span class="text-brand-orange">Rp {{ number_format($total,0,',','.') }}</span>
                    </div>

                    <button class="btn-primary w-full mt-4 py-3 flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-shield-check"></i>
                        Bayar via Midtrans
                    </button>
                    <p class="text-center text-[10px] text-gray-400 mt-2">
                        <i class="fa-solid fa-lock mr-1"></i>Transaksi aman · Powered by Midtrans Snap
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
