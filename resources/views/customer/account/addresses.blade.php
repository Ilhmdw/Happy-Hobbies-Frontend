@extends('layouts.customer')
@section('title','Kelola Alamat')

@section('content')
@php
$addresses = [
    ['id'=>1,'label'=>'Rumah','icon'=>'fa-house','name'=>'Ilham Dwitarama','phone'=>'+6285179729956','address'=>'Gg. III No.44C, Kendangsari, Kec. Tenggilis Mejoyo, Surabaya, Jawa Timur 60292','is_default'=>true],
    ['id'=>2,'label'=>'Kantor','icon'=>'fa-building','name'=>'Ilham DW','phone'=>'+6285179729956','address'=>'Kampus EEPIS, Sukolilo, Surabaya, Jawa Timur 60111','is_default'=>false],
];
@endphp

<div class="bg-brand-dark py-5 px-4">
    <div class="max-w-5xl mx-auto">
        <h1 class="font-heading font-extrabold text-xl text-white">Kelola Alamat</h1>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Sidebar --}}
        <div class="hidden md:block">
            <div class="card overflow-hidden">
                @foreach([
                    ['route'=>'account.index',    'icon'=>'fa-user',        'label'=>'Profil Saya'],
                    ['route'=>'account.addresses','icon'=>'fa-map-pin',     'label'=>'Alamat','active'=>true],
                    ['route'=>'account.orders',   'icon'=>'fa-bag-shopping','label'=>'Pesanan Saya'],
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

        {{-- Content --}}
        <div class="md:col-span-3 space-y-3" x-data="{ showForm: false, editId: null }">
            {{-- Existing addresses --}}
            @foreach($addresses as $addr)
            <div class="card p-4 flex gap-3">
                <div class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center text-brand-orange flex-shrink-0">
                    <i class="fa-solid {{ $addr['icon'] }}"></i>
                </div>
                <div class="flex-1 min-w-0">
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
                    <div class="flex gap-3 mt-2.5">
                        <button @click="showForm = true; editId = {{ $addr['id'] }}"
                            class="text-xs text-brand-orange font-semibold hover:underline flex items-center gap-1">
                            <i class="fa-regular fa-pen-to-square text-[10px]"></i> Edit
                        </button>
                        @if(!$addr['is_default'])
                        <button class="text-xs text-gray-500 font-semibold hover:underline">
                            Jadikan Utama
                        </button>
                        <button class="text-xs text-red-500 font-semibold hover:underline">
                            Hapus
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Add / Edit Form --}}
            <div x-show="showForm" x-cloak class="card p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-heading font-bold text-sm" x-text="editId ? 'Edit Alamat' : 'Tambah Alamat Baru'"></h3>
                    <button @click="showForm = false; editId = null" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">Label</label>
                            <select class="form-input">
                                <option>Rumah</option>
                                <option>Kantor</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Nama Penerima <span class="text-brand-orange">*</span></label>
                            <input type="text" class="form-input" placeholder="Nama lengkap penerima" value="Ilham Dwitarama"/>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">No. Telepon <span class="text-brand-orange">*</span></label>
                        <input type="tel" class="form-input" placeholder="+62812..." value="+6285179729956"/>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">Provinsi <span class="text-brand-orange">*</span></label>
                            <select class="form-input"><option>Jawa Timur</option></select>
                        </div>
                        <div>
                            <label class="form-label">Kota / Kabupaten <span class="text-brand-orange">*</span></label>
                            <select class="form-input"><option>Surabaya</option></select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">Kecamatan <span class="text-brand-orange">*</span></label>
                            <input type="text" class="form-input" placeholder="Kecamatan" value="Tenggilis Mejoyo"/>
                        </div>
                        <div>
                            <label class="form-label">Kode Pos <span class="text-brand-orange">*</span></label>
                            <input type="text" class="form-input" placeholder="Kode pos" value="60292"/>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Alamat Lengkap <span class="text-brand-orange">*</span></label>
                        <textarea class="form-input resize-none" rows="2"
                            placeholder="Nama jalan, nomor rumah, RT/RW…">Gg. III No.44C, Kendangsari</textarea>
                    </div>
                    <div>
                        <label class="form-label">Catatan (opsional)</label>
                        <input type="text" class="form-input" placeholder="Patokan atau instruksi tambahan…"/>
                    </div>
                    <label class="flex items-center gap-2 text-xs text-gray-600 cursor-pointer">
                        <input type="checkbox" class="accent-brand-orange"/>
                        Jadikan alamat utama
                    </label>
                    <div class="flex gap-2 pt-1">
                        <button @click="showForm = false; editId = null" class="btn-outline text-sm py-2 flex-1">Batal</button>
                        <button class="btn-primary text-sm py-2 flex-1">Simpan Alamat</button>
                    </div>
                </div>
            </div>

            {{-- Add button (when form hidden) --}}
            <button x-show="!showForm" @click="showForm = true; editId = null"
                class="w-full py-3 border-2 border-dashed border-gray-200 rounded-xl text-sm text-gray-500 hover:border-brand-orange hover:text-brand-orange transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Alamat Baru
            </button>
        </div>
    </div>
</div>
@endsection
