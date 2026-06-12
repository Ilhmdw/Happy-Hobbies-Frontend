@extends('layouts.customer')
@section('title','Ganti Password')

@section('content')
<div class="bg-brand-dark py-5 px-4">
    <div class="max-w-5xl mx-auto">
        <h1 class="font-heading font-extrabold text-xl text-white">Ganti Password</h1>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Sidebar --}}
        <div class="hidden md:block">
            <div class="card overflow-hidden">
                @foreach([
                    ['route'=>'account.index',    'icon'=>'fa-user',        'label'=>'Profil Saya'],
                    ['route'=>'account.addresses','icon'=>'fa-map-pin',     'label'=>'Alamat'],
                    ['route'=>'account.orders',   'icon'=>'fa-bag-shopping','label'=>'Pesanan Saya'],
                    ['route'=>'account.password', 'icon'=>'fa-lock',        'label'=>'Ganti Password','active'=>true],
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
        <div class="md:col-span-3">
            <div class="card p-6 max-w-md" x-data="{ showOld:false, showNew:false, showConfirm:false }">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-lock text-brand-orange"></i>
                    </div>
                    <div>
                        <h2 class="font-heading font-bold text-sm">Ubah Password</h2>
                        <p class="text-xs text-gray-500">Gunakan password yang kuat dan unik</p>
                    </div>
                </div>

                <form method="POST" action="#" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="form-label">Password Saat Ini <span class="text-brand-orange">*</span></label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input :type="showOld ? 'text' : 'password'" name="current_password"
                                placeholder="Password lama kamu"
                                class="form-input pl-9 pr-9" required/>
                            <button type="button" @click="showOld=!showOld"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i :class="showOld ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="fa text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Password Baru <span class="text-brand-orange">*</span></label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input :type="showNew ? 'text' : 'password'" name="password"
                                placeholder="Minimal 8 karakter"
                                class="form-input pl-9 pr-9" required/>
                            <button type="button" @click="showNew=!showNew"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i :class="showNew ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="fa text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Konfirmasi Password Baru <span class="text-brand-orange">*</span></label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                                placeholder="Ulangi password baru"
                                class="form-input pl-9 pr-9" required/>
                            <button type="button" @click="showConfirm=!showConfirm"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i :class="showConfirm ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="fa text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-xs text-blue-700 space-y-1">
                        <p class="font-semibold mb-1.5"><i class="fa-solid fa-circle-info mr-1"></i>Tips password aman:</p>
                        <p>• Minimal 8 karakter</p>
                        <p>• Kombinasi huruf besar, huruf kecil, angka</p>
                        <p>• Jangan gunakan informasi pribadi</p>
                    </div>

                    <div class="flex gap-2 pt-1">
                        <a href="{{ route('account.index') }}" class="btn-outline text-sm py-2 flex-1 text-center">Batal</a>
                        <button type="submit" class="btn-primary text-sm py-2 flex-1">
                            <i class="fa-solid fa-shield-check mr-1.5"></i>Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
