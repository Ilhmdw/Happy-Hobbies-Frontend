@extends('layouts.admin')
@section('title','Edit Produk')

@section('content')
@php
$product = [
    'id'       => 1,
    'name'     => 'Blossoming Calm MH2 Art Card 1/81 MTG Singles',
    'game'     => 'Magic: The Gathering',
    'sub'      => 'Single Card',
    'sku'      => 'HH-MTG-BLO-001',
    'price'    => 33830,
    'stock'    => 1,
    'status'   => 'active',
    'desc'     => 'Blossoming Calm MH2 Art Card 1/81 MTG Singles. Tersedia versi EN dan JP. Near Mint dari pack.',
    'updated'  => '4 Apr 2026',
    'variants' => [
        ['id'=>1,'label'=>'NORMAL EN','price'=>33830,'stock'=>0,'flag'=>'🇬🇧'],
        ['id'=>2,'label'=>'NORMAL JP','price'=>33830,'stock'=>1,'flag'=>'🇯🇵'],
    ],
];
@endphp

<div x-data="{
    variants: {{ json_encode($product['variants']) }},
    addVariant() { this.variants.push({ id: Date.now(), label:'', price:'', stock:0, flag:'' }) },
    removeVariant(i) { this.variants.splice(i, 1) }
}">

{{-- Header --}}
<div class="flex items-start justify-between mb-5">
    <div>
        <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-1">
            <a href="{{ route('admin.products.index') }}" class="text-brand-orange hover:underline">Kelola Produk</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span>Edit Produk</span>
        </div>
        <h1 class="font-heading font-extrabold text-lg text-gray-900 leading-snug max-w-2xl">
            Edit: {{ $product['name'] }}
        </h1>
        <div class="flex items-center gap-2 mt-1.5">
            <span class="badge-active text-[10px]">Aktif</span>
            <span class="text-[11px] text-gray-400 font-mono">SKU: {{ $product['sku'] }}</span>
            <span class="text-[11px] text-gray-400">·</span>
            <span class="text-[11px] text-gray-400">Terakhir diupdate: {{ $product['updated'] }}</span>
        </div>
    </div>
    <div class="flex items-center gap-2 flex-shrink-0 ml-4">
        <select class="text-xs border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-brand-orange bg-white font-semibold">
            <option value="active"   {{ $product['status']==='active'   ? 'selected':'' }}>● Aktif</option>
            <option value="inactive" {{ $product['status']==='inactive' ? 'selected':'' }}>○ Nonaktif</option>
            <option value="draft"    {{ $product['status']==='draft'    ? 'selected':'' }}>◎ Draf</option>
        </select>
        <a href="{{ route('admin.products.index') }}" class="btn-outline text-xs py-2 px-3">Batal</a>
        <button class="btn-primary text-xs py-2 px-3 flex items-center gap-1.5">
            <i class="fa-solid fa-check"></i> Simpan Perubahan
        </button>
    </div>
</div>

<div class="space-y-4">

    {{-- Gambar --}}
    <div class="card p-5">
        <h3 class="font-heading font-bold text-sm mb-3 pb-3 border-b border-gray-100">
            <i class="fa-regular fa-image text-brand-orange mr-1.5"></i>Gambar Produk
        </h3>
        <p class="text-xs text-gray-500 mb-3">Klik gambar untuk hapus. Gambar pertama = gambar utama katalog.</p>
        <div class="flex gap-2 flex-wrap">
            {{-- Existing images --}}
            <div class="relative w-14 h-14 rounded-xl bg-green-100 border-2 border-brand-orange flex items-center justify-center text-2xl cursor-pointer group">
                ♦️
                <span class="absolute -top-2 -left-2 bg-brand-orange text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full">Utama</span>
                <button class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white rounded-full text-[9px] hidden group-hover:flex items-center justify-center">
                    ✕
                </button>
            </div>
            <div class="relative w-14 h-14 rounded-xl bg-green-50 border-2 border-gray-200 flex items-center justify-center text-2xl cursor-pointer group">
                ♦️
                <button class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white rounded-full text-[9px] hidden group-hover:flex items-center justify-center">
                    ✕
                </button>
            </div>
            <div class="w-14 h-14 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center gap-0.5 cursor-pointer hover:border-brand-orange/50 transition text-gray-400">
                <i class="fa-solid fa-plus text-sm"></i>
                <span class="text-[8px]">Tambah</span>
            </div>
        </div>
        <div class="flex gap-2 mt-3">
            <input type="text" placeholder="Atau masukkan URL gambar baru…"
                class="form-input text-xs flex-1"/>
            <button class="btn-dark text-xs px-3 py-1.5 flex-shrink-0 flex items-center gap-1.5">
                <i class="fa-solid fa-link text-[10px]"></i> Tambah URL
            </button>
        </div>
    </div>

    {{-- Informasi Dasar --}}
    <div class="card p-5">
        <h3 class="font-heading font-bold text-sm mb-4 pb-3 border-b border-gray-100">
            <i class="fa-solid fa-info-circle text-brand-orange mr-1.5"></i>Informasi Dasar
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="form-label">Nama Produk <span class="text-brand-orange">*</span></label>
                <input type="text" class="form-input" value="{{ $product['name'] }}" required/>
            </div>
            <div>
                <label class="form-label">Game / Franchise <span class="text-brand-orange">*</span></label>
                <select class="form-input" required>
                    @foreach(['Pokémon TCG','Yu-Gi-Oh!','One Piece TCG','Digimon TCG','Magic: The Gathering','Ultraman TCG','Shadowverse Evolved','Aksesoris'] as $cat)
                    <option {{ $product['game']===$cat ? 'selected':'' }}>{{ $cat }}</option>
                    @endforeach
                    <option>➕ Tambah Kategori Baru…</option>
                </select>
            </div>
            <div>
                <label class="form-label">Sub-Kategori <span class="text-brand-orange">*</span></label>
                <select class="form-input" required>
                    @foreach(['Single Card','Sealed Box','Booster Pack','Art Card','Promo','Special Set'] as $sub)
                    <option {{ $product['sub']===$sub ? 'selected':'' }}>{{ $sub }}</option>
                    @endforeach
                    <option>➕ Tambah Sub-Kategori Baru…</option>
                </select>
            </div>
            <div>
                <label class="form-label">Harga Jual (Rp) <span class="text-brand-orange">*</span></label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-semibold">Rp</span>
                    <input type="number" class="form-input pl-8" value="{{ $product['price'] }}" required/>
                </div>
            </div>
            <div>
                <label class="form-label">Stok Tersedia <span class="text-brand-orange">*</span></label>
                <input type="number" class="form-input" value="{{ $product['stock'] }}" min="0" required/>
            </div>
            <div class="col-span-2">
                <label class="form-label">SKU Internal</label>
                <input type="text" class="form-input" value="{{ $product['sku'] }}"/>
            </div>
            <div class="col-span-2">
                <label class="form-label">Deskripsi Produk</label>
                <textarea class="form-input resize-none" rows="3">{{ $product['desc'] }}</textarea>
            </div>
        </div>
    </div>

    {{-- Varian --}}
    <div class="card p-5">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <h3 class="font-heading font-bold text-sm">
                <i class="fa-solid fa-layer-group text-brand-orange mr-1.5"></i>Varian
                <span class="text-xs text-gray-400 font-normal ml-1">({{ count($product['variants']) }} varian aktif)</span>
            </h3>
        </div>
        <p class="text-xs text-gray-500 mb-3">Tema: <strong>JENIS</strong></p>

        <div class="grid grid-cols-[1fr_100px_70px_60px_32px] gap-2 mb-2 px-1">
            @foreach(['Nilai Varian','Harga (Rp)','Stok','Gambar',''] as $h)
            <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">{{ $h }}</span>
            @endforeach
        </div>

        <template x-for="(v, i) in variants" :key="v.id">
            <div class="grid grid-cols-[1fr_100px_70px_60px_32px] gap-2 items-center bg-gray-50 rounded-xl p-2.5 mb-2">
                <input type="text" x-model="v.label" class="form-input text-xs py-1.5"/>
                <input type="number" x-model="v.price" class="form-input text-xs py-1.5"/>
                <input type="number" x-model="v.stock" class="form-input text-xs py-1.5"/>
                <div class="w-11 h-11 rounded-xl border-2 border-brand-orange bg-green-50 flex items-center justify-center text-lg relative cursor-pointer group">
                    <span x-text="v.flag || '🖼'"></span>
                    <div class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-brand-orange rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-pen text-white text-[7px]"></i>
                    </div>
                </div>
                <button @click="removeVariant(i)"
                    class="w-7 h-7 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition">
                    <i class="fa-solid fa-trash text-[10px]"></i>
                </button>
            </div>
        </template>

        <button @click="addVariant()"
            class="flex items-center gap-1.5 text-xs text-brand-orange font-semibold hover:underline mt-1">
            <i class="fa-solid fa-plus text-[10px]"></i> Tambah Varian
        </button>
    </div>

    {{-- Danger Zone --}}
    <div class="border border-red-200 bg-red-50/50 rounded-xl p-4">
        <h3 class="font-heading font-bold text-sm text-red-700 mb-3">
            <i class="fa-solid fa-triangle-exclamation mr-1.5"></i>Zona Bahaya
        </h3>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-800">Hapus Produk Ini</p>
                <p class="text-[11px] text-gray-500 mt-0.5">Tindakan ini tidak bisa dikembalikan. Pesanan yang sudah ada tetap tercatat.</p>
            </div>
            <button class="text-xs font-semibold text-red-500 border border-red-300 bg-white hover:bg-red-50 px-3 py-2 rounded-lg transition flex items-center gap-1.5">
                <i class="fa-solid fa-trash text-[10px]"></i> Hapus Produk
            </button>
        </div>
    </div>

    {{-- Action buttons --}}
    <div class="flex items-center justify-end gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn-outline text-sm py-2 px-4">Batal</a>
        <button class="btn-primary text-sm py-2 px-4 flex items-center gap-1.5">
            <i class="fa-solid fa-check"></i> Simpan Perubahan
        </button>
    </div>

</div>
</div>
@endsection
