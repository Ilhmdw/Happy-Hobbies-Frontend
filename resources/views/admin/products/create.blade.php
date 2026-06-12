@extends('layouts.admin')
@section('title','Tambah Produk')

@section('content')
@php
$categories = ['Pokémon TCG','Yu-Gi-Oh!','One Piece TCG','Digimon TCG','Magic: The Gathering','Ultraman TCG','Shadowverse Evolved','Aksesoris'];
$subCategories = ['Single Card','Sealed Box','Booster Pack','Art Card','Promo','Special Set'];
@endphp

<div x-data="{
    mode: 'manual',
    variants: [{ label:'', price:'', stock:'', image:'' }],
    addVariant() { this.variants.push({ label:'', price:'', stock:'', image:'' }) },
    removeVariant(i) { this.variants.splice(i, 1) }
}">

{{-- Header --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-1">
            <a href="{{ route('admin.products.index') }}" class="text-brand-orange hover:underline">Kelola Produk</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span>Tambah Produk</span>
        </div>
        <h1 class="font-heading font-extrabold text-xl text-gray-900">Tambah Produk</h1>
    </div>
</div>

{{-- Mode selector --}}
<div class="grid grid-cols-2 gap-3 mb-5">
    <button @click="mode='manual'"
        :class="mode==='manual' ? 'border-brand-orange bg-orange-50/40' : 'border-gray-200 hover:border-gray-300'"
        class="card p-4 text-left transition border-2">
        <div class="w-8 h-8 rounded-xl bg-orange-100 flex items-center justify-center mb-2.5">
            <i class="fa-solid fa-plus text-brand-orange text-sm"></i>
        </div>
        <p class="font-heading font-bold text-sm text-gray-800">Tambah 1 Produk</p>
        <p class="text-xs text-gray-500 mt-1">Input manual satu produk secara detail.</p>
        <span class="inline-block mt-2 text-[10px] font-semibold px-2 py-0.5 bg-orange-100 text-brand-orange rounded-full">
            Manual · Satu per satu
        </span>
    </button>
    <button @click="mode='bulk'"
        :class="mode==='bulk' ? 'border-green-500 bg-green-50/40' : 'border-gray-200 hover:border-gray-300'"
        class="card p-4 text-left transition border-2">
        <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center mb-2.5">
            <i class="fa-solid fa-file-excel text-green-600 text-sm"></i>
        </div>
        <p class="font-heading font-bold text-sm text-gray-800">Unggah Sekaligus <span class="text-green-600">(Bulk)</span></p>
        <p class="text-xs text-gray-500 mt-1">Import ribuan SKU via file Excel.</p>
        <span class="inline-block mt-2 text-[10px] font-semibold px-2 py-0.5 bg-green-100 text-green-700 rounded-full">
            Excel .xlsx · Ribuan SKU
        </span>
    </button>
</div>

{{-- ── MANUAL FORM ── --}}
<div x-show="mode==='manual'" class="space-y-4">

    {{-- Gambar Produk --}}
    <div class="card p-5">
        <h3 class="font-heading font-bold text-sm mb-4 pb-3 border-b border-gray-100">
            <i class="fa-regular fa-image text-brand-orange mr-1.5"></i>Gambar Produk
        </h3>
        <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center bg-gray-50 hover:border-brand-orange/50 transition cursor-pointer">
            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 mb-2 block"></i>
            <p class="text-xs text-gray-500">Klik untuk upload atau paste URL gambar</p>
            <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, WebP · Maks. 5MB per file</p>
        </div>
        <div class="grid grid-cols-4 gap-2 mt-3">
            @for($i = 0; $i < 4; $i++)
            <div class="aspect-square rounded-xl border-2 {{ $i === 0 ? 'border-gray-200 bg-gray-100' : 'border-dashed border-gray-200 bg-gray-50' }} flex flex-col items-center justify-center gap-1 cursor-pointer hover:border-brand-orange/50 transition">
                @if($i === 0)
                    <i class="fa-regular fa-image text-lg text-gray-300"></i>
                    <span class="text-[9px] text-gray-400">Gambar Utama</span>
                @else
                    <span class="text-lg text-gray-300">+</span>
                @endif
            </div>
            @endfor
        </div>
        <div class="flex gap-2 mt-3">
            <input type="text" placeholder="Atau tempel URL gambar (postimages.org, imgur, dll)…"
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
                <input type="text" class="form-input" placeholder="Contoh: Blossoming Calm MH2 Art Card 1/81 MTG Singles" required/>
            </div>
            <div>
                <label class="form-label">Game / Franchise <span class="text-brand-orange">*</span></label>
                <select class="form-input" required>
                    <option value="">— Pilih Game —</option>
                    @foreach($categories as $cat)
                    <option>{{ $cat }}</option>
                    @endforeach
                    <option>➕ Tambah Kategori Baru…</option>
                </select>
            </div>
            <div>
                <label class="form-label">Sub-Kategori <span class="text-brand-orange">*</span></label>
                <select class="form-input" required>
                    <option value="">— Pilih Sub-Kategori —</option>
                    @foreach($subCategories as $sub)
                    <option>{{ $sub }}</option>
                    @endforeach
                    <option>➕ Tambah Sub-Kategori Baru…</option>
                </select>
            </div>
            <div>
                <label class="form-label">Harga Jual (Rp) <span class="text-brand-orange">*</span></label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-semibold">Rp</span>
                    <input type="number" class="form-input pl-8" placeholder="33830" required/>
                </div>
            </div>
            <div>
                <label class="form-label">Stok Tersedia <span class="text-brand-orange">*</span></label>
                <input type="number" class="form-input" placeholder="Contoh: 5" min="0" required/>
            </div>
            <div class="col-span-2">
                <label class="form-label flex items-center gap-1.5">
                    SKU Internal
                    <span class="text-[9px] text-gray-400 normal-case font-normal">
                        (Auto-generate jika kosong, contoh: HH-MTG-BLO-001)
                    </span>
                </label>
                <input type="text" class="form-input" placeholder="Kosongkan untuk auto-generate…"/>
            </div>
            <div class="col-span-2">
                <label class="form-label">Deskripsi Produk</label>
                <textarea class="form-input resize-none" rows="3"
                    placeholder="Jelaskan detail produk: kondisi, bahasa, edisi, catatan khusus… (Opsional)"></textarea>
            </div>
        </div>
    </div>

    {{-- Varian --}}
    <div class="card p-5">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <h3 class="font-heading font-bold text-sm">
                <i class="fa-solid fa-layer-group text-brand-orange mr-1.5"></i>Varian
                <span class="text-xs text-gray-400 font-normal ml-1">(Opsional)</span>
            </h3>
        </div>
        <p class="text-xs text-gray-500 mb-3">Tambah varian jika produk punya versi berbeda (misal: EN/JP, NM/LP). Tiap varian bisa punya gambar sendiri.</p>
        <div class="mb-3">
            <label class="form-label">Nama Tema Varian
                <span class="text-[10px] text-gray-400 normal-case font-normal ml-1">(misal: JENIS, Grade, Bahasa)</span>
            </label>
            <input type="text" class="form-input max-w-xs" placeholder="Contoh: JENIS"/>
        </div>

        {{-- Header row --}}
        <div class="grid grid-cols-[1fr_100px_70px_60px_32px] gap-2 mb-2 px-1">
            @foreach(['Nilai Varian','Harga (Rp)','Stok','Gambar',''] as $h)
            <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">{{ $h }}</span>
            @endforeach
        </div>

        {{-- Variant rows --}}
        <template x-for="(v, i) in variants" :key="i">
            <div class="grid grid-cols-[1fr_100px_70px_60px_32px] gap-2 items-center bg-gray-50 rounded-xl p-2.5 mb-2">
                <input type="text" x-model="v.label" placeholder="Contoh: NORMAL JP"
                    class="form-input text-xs py-1.5"/>
                <input type="number" x-model="v.price" placeholder="33830"
                    class="form-input text-xs py-1.5"/>
                <input type="number" x-model="v.stock" placeholder="0"
                    class="form-input text-xs py-1.5"/>
                <div class="w-11 h-11 rounded-xl border-2 border-dashed border-gray-300 bg-white flex flex-col items-center justify-center gap-0.5 cursor-pointer hover:border-brand-orange/50 transition text-gray-400">
                    <i class="fa-regular fa-image text-sm"></i>
                    <span class="text-[8px]">Upload</span>
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

        <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-xl text-[11px] text-blue-700">
            <i class="fa-solid fa-circle-info mr-1"></i>
            <strong>Bulk Excel:</strong> 1 baris per varian, nama produk sama persis.
            Kolom yang dibutuhkan: <code class="bg-blue-100 px-1 rounded">nama_varian</code> · <code class="bg-blue-100 px-1 rounded">nilai_varian</code> · <code class="bg-blue-100 px-1 rounded">gambar_varian</code>
        </div>
    </div>

    {{-- Action buttons --}}
    <div class="flex items-center justify-end gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn-outline text-sm py-2 px-4">Batal</a>
        <button type="button" class="btn-outline text-sm py-2 px-4 flex items-center gap-1.5">
            <i class="fa-regular fa-floppy-disk"></i> Simpan Draf
        </button>
        <button type="submit" class="btn-primary text-sm py-2 px-4 flex items-center gap-1.5">
            <i class="fa-solid fa-check"></i> Simpan Produk
        </button>
    </div>
</div>

{{-- ── BULK FORM ── --}}
<div x-show="mode==='bulk'" x-cloak class="card p-6 max-w-2xl">
    <h3 class="font-heading font-bold text-sm mb-4 pb-3 border-b border-gray-100">
        <i class="fa-solid fa-file-excel text-green-600 mr-1.5"></i>Bulk Upload via Excel
    </h3>
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-5 text-xs text-blue-700 space-y-1.5">
        <p class="font-semibold">Format kolom Excel (13 kolom wajib):</p>
        <div class="flex flex-wrap gap-1.5 mt-2">
            @foreach(['nama_produk','game','sub_kategori','harga','stok','sku','deskripsi','gambar_url','nama_varian','nilai_varian','harga_varian','stok_varian','gambar_varian'] as $col)
            <code class="bg-blue-100 border border-blue-300 px-1.5 py-0.5 rounded text-[10px]">{{ $col }}</code>
            @endforeach
        </div>
        <p class="text-[10px] text-blue-500 mt-2">Kategori baru otomatis dibuat dengan status Nonaktif. SKU dikosongkan → auto-generate.</p>
    </div>
    <div class="border-2 border-dashed border-gray-200 rounded-xl p-10 text-center bg-gray-50 hover:border-green-400 transition cursor-pointer">
        <i class="fa-solid fa-file-excel text-4xl text-gray-300 mb-3 block"></i>
        <p class="text-sm font-semibold text-gray-600 mb-1">Klik untuk pilih file atau drag & drop</p>
        <p class="text-xs text-gray-400">Format: .xlsx · Maks. 5MB · Ribuan baris</p>
    </div>
    <div class="flex justify-between items-center mt-4 gap-3">
        <a href="#" class="text-xs text-brand-orange font-semibold hover:underline flex items-center gap-1">
            <i class="fa-solid fa-download text-[10px]"></i> Download Template Excel
        </a>
        <button class="btn-primary text-sm py-2 px-4 flex items-center gap-1.5">
            <i class="fa-solid fa-upload"></i> Upload & Proses
        </button>
    </div>
</div>

</div>
@endsection
