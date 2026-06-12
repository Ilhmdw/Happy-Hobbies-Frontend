@extends('layouts.customer')
@section('title','Akun Saya')

@section('content')
@php
$user = ['name'=>'Ilham Dwitarama','email'=>'mieindo340@gmail.com','phone'=>'+6285179729956','gender'=>'—','dob'=>'08 Juni 2005'];
$addresses = [
    ['id'=>1,'label'=>'Rumah','name'=>'Ilham Dwitarama','phone'=>'+6285179729956','address'=>'Gg. III No.44C, Kendangsari, Kec. Tenggilis Mejoyo, Surabaya 60292','is_default'=>true],
    ['id'=>2,'label'=>'Kantor','name'=>'Ilham DW','phone'=>'+6285179729956','address'=>'Kampus EEPIS, Sukolilo, Surabaya 60111','is_default'=>false],
];
@endphp

<div class="bg-brand-dark py-5 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center gap-1.5 text-xs text-white/40 mb-2">
            <a href="{{ route('home') }}" class="hover:text-white/70">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="text-white/80">Akun Saya</span>
        </div>
        <h1 class="font-heading font-extrabold text-xl text-white">Akun Saya</h1>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Sidebar --}}
        <div class="space-y-3">
            <div class="card p-4 flex flex-col items-center text-center">
                <div class="w-14 h-14 bg-brand-orange rounded-full flex items-center justify-center font-heading font-black text-2xl text-white mb-2">
                    {{ strtoupper(substr($user['name'],0,1)) }}
                </div>
                <p class="font-heading font-bold text-sm">{{ $user['name'] }}</p>
                <p class="text-[11px] text-gray-500 mt-0.5">{{ $user['email'] }}</p>
            </div>
            <div class="card overflow-hidden">
                @foreach([
                    ['route'=>'account.index',     'icon'=>'fa-user',               'label'=>'Profil Saya',    'active'=>true],
                    ['route'=>'account.addresses', 'icon'=>'fa-map-pin',            'label'=>'Alamat'],
                    ['route'=>'account.orders',    'icon'=>'fa-bag-shopping',        'label'=>'Pesanan Saya'],
                    ['route'=>'account.password',  'icon'=>'fa-lock',               'label'=>'Ganti Password'],
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

        {{-- Content --}}
        <div class="md:col-span-3 space-y-4">
            {{-- Informasi Pribadi --}}
            <div class="card">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-heading font-bold text-sm">Informasi Pribadi</h2>
                    <button class="text-xs text-brand-orange font-semibold hover:underline flex items-center gap-1">
                        <i class="fa-regular fa-pen-to-square text-[10px]"></i> Edit
                    </button>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                        @foreach([
                            ['label'=>'Nama Depan','value'=>'Ilham'],
                            ['label'=>'Nama Belakang','value'=>'Dwitarama'],
                            ['label'=>'Email','value'=>$user['email']],
                            ['label'=>'No. Telepon','value'=>$user['phone']],
                            ['label'=>'Jenis Kelamin','value'=>$user['gender']],
                            ['label'=>'Tanggal Lahir','value'=>$user['dob']],
                        ] as $field)
                        <div>
                            <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-0.5">{{ $field['label'] }}</p>
                            <p class="text-sm font-medium text-gray-800">{{ $field['value'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="card">
                <div class="px-5 py-3.5 border-b border-gray-100">
                    <h2 class="font-heading font-bold text-sm">Alamat Pengiriman</h2>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($addresses as $addr)
                    <div class="border border-gray-200 rounded-xl p-4 flex gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-brand-orange flex-shrink-0">
                            <i class="fa-solid {{ $addr['label']==='Rumah' ? 'fa-house' : 'fa-building' }} text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full font-semibold">
                                    {{ $addr['label']==='Rumah' ? '🏠' : '🏢' }} {{ $addr['label'] }}
                                </span>
                                @if($addr['is_default'])
                                <span class="text-[10px] px-2 py-0.5 bg-brand-yellow text-brand-dark rounded-full font-bold">Utama</span>
                                @endif
                            </div>
                            <p class="text-sm font-semibold text-gray-800">{{ $addr['name'] }} · {{ $addr['phone'] }}</p>
                            <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $addr['address'] }}</p>
                        </div>
                        <div class="flex flex-col gap-1 flex-shrink-0">
                            <button class="text-xs text-brand-orange font-semibold hover:underline">Edit</button>
                            @if(!$addr['is_default'])
                            <button class="text-xs text-red-500 font-semibold hover:underline">Hapus</button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    <button class="w-full py-2.5 border-2 border-dashed border-gray-200 rounded-xl text-sm text-gray-500 hover:border-brand-orange hover:text-brand-orange transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus text-xs"></i> Tambah Alamat Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
