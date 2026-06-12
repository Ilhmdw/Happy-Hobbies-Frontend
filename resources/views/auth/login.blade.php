@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<div x-data="{ tab: 'login' }">
    {{-- Tab Header --}}
    <div class="px-6 pt-5 pb-0 flex items-center gap-3">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 bg-brand-yellow rounded-md flex items-center justify-center">
                <span class="font-heading font-black text-brand-dark text-[9px]">HH</span>
            </div>
            <span class="font-heading font-extrabold text-brand-dark text-sm">
                <span class="text-brand-orange">Happy</span>Hobbies
            </span>
        </div>
    </div>

    <div class="flex border-b border-gray-100 px-6 mt-4">
        <button @click="tab='login'"
            :class="tab==='login' ? 'border-brand-orange text-brand-orange font-bold' : 'border-transparent text-gray-400'"
            class="pb-2.5 text-sm border-b-2 mr-5 transition-colors">Masuk</button>
        <button @click="tab='register'"
            :class="tab==='register' ? 'border-brand-orange text-brand-orange font-bold' : 'border-transparent text-gray-400'"
            class="pb-2.5 text-sm border-b-2 transition-colors">Daftar Akun</button>
    </div>

    {{-- LOGIN FORM --}}
    <div x-show="tab==='login'" class="p-6">
        <h1 class="font-heading font-extrabold text-xl text-gray-900 mb-1">Selamat Datang!</h1>
        <p class="text-xs text-gray-500 mb-5">Masuk ke akun HappyHobbies kamu</p>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 text-xs px-3 py-2.5 rounded-lg mb-4 flex items-start gap-2">
            <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0"></i>
            <div>{{ $errors->first() }}</div>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Email</label>
                <div class="relative">
                    <i class="fa-regular fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="email@kamu.com"
                        class="form-input pl-9"
                        required autofocus/>
                </div>
            </div>
            <div>
                <label class="form-label">Password</label>
                <div class="relative" x-data="{ show: false }">
                    <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input :type="show ? 'text' : 'password'" name="password"
                        placeholder="••••••••"
                        class="form-input pl-9 pr-9"
                        required/>
                    <button type="button" @click="show=!show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="fa text-xs"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-xs text-gray-500 cursor-pointer">
                    <input type="checkbox" name="remember" class="accent-brand-orange rounded"/>
                    Ingat sesi login
                </label>
                <a href="#" class="text-xs text-brand-orange hover:underline">Lupa password?</a>
            </div>
            <button type="submit" class="btn-primary w-full py-2.5 text-sm">
                Masuk ke Akun
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-4">
            Belum punya akun?
            <button @click="tab='register'" class="text-brand-orange font-semibold hover:underline">Daftar Gratis</button>
        </p>

        <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-100 text-[11px] text-gray-500 text-center leading-relaxed">
            Satu halaman login untuk semua role.<br/>
            Sistem akan redirect otomatis berdasarkan role.
        </div>
    </div>

    {{-- REGISTER FORM --}}
    <div x-show="tab==='register'" class="p-6" x-cloak>
        <h1 class="font-heading font-extrabold text-xl text-gray-900 mb-1">Buat Akun Baru</h1>
        <p class="text-xs text-gray-500 mb-5">Daftar gratis dan mulai belanja kartu TCG</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="form-label">Nama Depan <span class="text-brand-orange">*</span></label>
                    <input type="text" name="first_name" placeholder="Ilham" class="form-input" required/>
                </div>
                <div>
                    <label class="form-label">Nama Belakang</label>
                    <input type="text" name="last_name" placeholder="Dwitarama" class="form-input"/>
                </div>
            </div>
            <div>
                <label class="form-label">Email <span class="text-brand-orange">*</span></label>
                <div class="relative">
                    <i class="fa-regular fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="email" name="email" placeholder="email@kamu.com" class="form-input pl-9" required/>
                </div>
            </div>
            <div>
                <label class="form-label">No. Telepon</label>
                <div class="relative">
                    <i class="fa-solid fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="tel" name="phone" placeholder="+62812..." class="form-input pl-9"/>
                </div>
            </div>
            <div>
                <label class="form-label">Password <span class="text-brand-orange">*</span></label>
                <div class="relative" x-data="{ show: false }">
                    <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input :type="show ? 'text' : 'password'" name="password"
                        placeholder="Min. 8 karakter" class="form-input pl-9 pr-9" required/>
                    <button type="button" @click="show=!show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="fa text-xs"></i>
                    </button>
                </div>
            </div>
            <div>
                <label class="form-label">Konfirmasi Password <span class="text-brand-orange">*</span></label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="password" name="password_confirmation"
                        placeholder="Ulangi password" class="form-input pl-9" required/>
                </div>
            </div>
            <label class="flex items-start gap-2 text-xs text-gray-500 cursor-pointer">
                <input type="checkbox" required class="accent-brand-orange mt-0.5 flex-shrink-0"/>
                <span>Saya menyetujui <a href="#" class="text-brand-orange hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-brand-orange hover:underline">Kebijakan Privasi</a> HappyHobbies.</span>
            </label>
            <button type="submit" class="btn-primary w-full py-2.5 text-sm">
                Buat Akun Sekarang
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-4">
            Sudah punya akun?
            <button @click="tab='login'" class="text-brand-orange font-semibold hover:underline">Masuk</button>
        </p>
    </div>
</div>
@endsection
