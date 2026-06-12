@extends('layouts.admin')
@section('title','Pengaturan Toko')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="font-heading font-extrabold text-xl text-gray-900">Pengaturan Toko</h1>
        <p class="text-xs text-gray-500 mt-0.5">Konfigurasi toko, API, dan sistem</p>
    </div>
    <button class="btn-primary text-xs py-1.5 px-3 flex items-center gap-1.5">
        <i class="fa-regular fa-floppy-disk"></i> Simpan Semua Perubahan
    </button>
</div>

<div class="space-y-4 max-w-3xl">

    {{-- Informasi Toko --}}
    <div class="card p-5">
        <h3 class="font-heading font-bold text-sm mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fa-solid fa-store text-brand-orange"></i> Informasi Toko
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Nama Toko</label>
                <input type="text" class="form-input" value="Happy Hobbies"/>
            </div>
            <div>
                <label class="form-label">Tagline</label>
                <input type="text" class="form-input" value="Indonesia's TCG Store #1"/>
            </div>
            <div>
                <label class="form-label">Email Toko</label>
                <input type="email" class="form-input" value="admin@happyhobbies.id"/>
            </div>
            <div>
                <label class="form-label">WhatsApp</label>
                <input type="tel" class="form-input" value="+6281234567890"/>
            </div>
            <div class="col-span-2">
                <label class="form-label">Deskripsi Toko</label>
                <textarea class="form-input resize-none" rows="2">Toko kartu TCG terpercaya di Indonesia. Original, bergaransi, pengiriman ke seluruh Indonesia.</textarea>
            </div>
        </div>
    </div>

    {{-- RajaOngkir --}}
    <div class="card p-5">
        <h3 class="font-heading font-bold text-sm mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fa-solid fa-truck text-brand-orange"></i> Pengiriman &amp; RajaOngkir API
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Kota Asal Pengiriman</label>
                <input type="text" class="form-input" value="Surabaya"/>
                <p class="text-[10px] text-gray-400 mt-1">Kota asal perhitungan ongkir via RajaOngkir API</p>
            </div>
            <div>
                <label class="form-label">Berat Default per Produk (gram)</label>
                <input type="number" class="form-input" value="50"/>
                <p class="text-[10px] text-gray-400 mt-1">Berat default jika tidak diisi per produk</p>
            </div>
            <div class="col-span-2">
                <label class="form-label">RajaOngkir API Key</label>
                <div class="relative" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" class="form-input pr-10"
                        value="rajaongkir-api-key-here" placeholder="Masukkan API Key RajaOngkir (Starter)"/>
                    <button type="button" @click="show=!show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="fa text-sm"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <label class="form-label">Ekspedisi Aktif</label>
            <div class="grid grid-cols-2 gap-2 mt-2">
                @foreach([
                    ['name'=>'JNE','detail'=>'REG, JTR, YES'],
                    ['name'=>'J&T Express','detail'=>'Express, Cargo'],
                    ['name'=>'SiCepat','detail'=>'REG, GOKIL'],
                    ['name'=>'AnterAja','detail'=>'REG, Anter'],
                ] as $exp)
                <label class="flex items-center gap-2.5 p-3 border border-gray-200 rounded-xl cursor-pointer hover:border-brand-orange/50 transition"
                    x-data="{ checked: true }">
                    <input type="checkbox" x-model="checked" class="accent-brand-orange"/>
                    <div>
                        <p class="text-xs font-semibold">{{ $exp['name'] }}</p>
                        <p class="text-[10px] text-gray-400">{{ $exp['detail'] }}</p>
                    </div>
                    <span x-show="checked" class="ml-auto badge-active text-[9px]">Aktif</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Midtrans --}}
    <div class="card p-5">
        <h3 class="font-heading font-bold text-sm mb-1 flex items-center gap-2">
            <i class="fa-solid fa-credit-card text-brand-orange"></i> Midtrans Payment
        </h3>
        <p class="text-xs text-gray-500 mb-4">Konfigurasi payment gateway Midtrans Snap</p>

        <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4 flex items-center gap-2 text-xs text-amber-700">
            <i class="fa-solid fa-circle-info flex-shrink-0"></i>
            Mode aktif: <strong class="ml-1">Sandbox</strong> (pengembangan).
            Ganti ke Production key saat deploy ke server live.
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Server Key</label>
                <div class="relative" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" class="form-input pr-10"
                        value="SB-Mid-server-xxxxxxxxxxxxxxxx"/>
                    <button type="button" @click="show=!show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="fa text-sm"></i>
                    </button>
                </div>
            </div>
            <div>
                <label class="form-label">Client Key</label>
                <div class="relative" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" class="form-input pr-10"
                        value="SB-Mid-client-xxxxxxxxxxxxxxxx"/>
                    <button type="button" @click="show=!show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="fa text-sm"></i>
                    </button>
                </div>
            </div>
            <div>
                <label class="form-label">Mode</label>
                <select class="form-input">
                    <option value="sandbox" selected>Sandbox (Development)</option>
                    <option value="production">Production (Live)</option>
                </select>
            </div>
            <div>
                <label class="form-label">Webhook URL</label>
                <div class="relative">
                    <input type="text" class="form-input pr-8 bg-gray-50 text-gray-500 text-xs" readonly
                        value="{{ url('/webhook/midtrans') }}"/>
                    <button type="button" onclick="navigator.clipboard.writeText(this.previousElementSibling.value)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-orange transition">
                        <i class="fa-regular fa-copy text-sm"></i>
                    </button>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">Daftarkan URL ini di dashboard Midtrans</p>
            </div>
        </div>
    </div>

    {{-- Media Sosial --}}
    <div class="card p-5">
        <h3 class="font-heading font-bold text-sm mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fa-solid fa-share-nodes text-brand-orange"></i> Media Sosial
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Instagram</label>
                <div class="relative">
                    <i class="fa-brands fa-instagram absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" class="form-input pl-9" value="@happyhobbies.id"/>
                </div>
            </div>
            <div>
                <label class="form-label">TikTok</label>
                <div class="relative">
                    <i class="fa-brands fa-tiktok absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" class="form-input pl-9" value="@happyhobbies.id"/>
                </div>
            </div>
        </div>
    </div>

    {{-- Target PIC --}}
    <div class="card p-5">
        <h3 class="font-heading font-bold text-sm mb-1 flex items-center gap-2">
            <i class="fa-solid fa-bullseye text-brand-orange"></i> Target Input PIC
        </h3>
        <p class="text-xs text-gray-500 mb-4">Target jumlah produk yang harus diinput per PIC per hari</p>
        <div class="flex items-center gap-3">
            <label class="text-sm text-gray-600">Target produk per PIC per hari:</label>
            <input type="number" class="form-input w-24" value="175" min="1"/>
            <span class="text-sm text-gray-500">SKU / hari</span>
        </div>
    </div>

    {{-- Order Expiry --}}
    <div class="card p-5">
        <h3 class="font-heading font-bold text-sm mb-1 flex items-center gap-2">
            <i class="fa-regular fa-clock text-brand-orange"></i> Kadaluarsa Pesanan
        </h3>
        <p class="text-xs text-gray-500 mb-4">Pesanan yang belum dibayar akan otomatis dibatalkan setelah durasi ini</p>
        <div class="flex items-center gap-3">
            <label class="text-sm text-gray-600">Durasi kadaluarsa:</label>
            <input type="number" class="form-input w-20" value="24" min="1"/>
            <span class="text-sm text-gray-500">jam</span>
        </div>
        <p class="text-[11px] text-gray-400 mt-2">
            <i class="fa-solid fa-circle-info mr-1"></i>
            Dijalankan oleh Laravel Scheduler (cron job). Stok dikembalikan otomatis saat pesanan expired.
        </p>
    </div>

</div>

@endsection
