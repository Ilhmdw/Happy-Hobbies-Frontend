<!DOCTYPE html>
<html lang="id" x-data="{ cartOpen: false }">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'HappyHobbies') — TCG Marketplace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-gray-50 font-sans">

{{-- FLASH MESSAGE --}}
@if(session('success'))
<div id="flash-message" class="fixed top-4 right-4 z-50 bg-green-600 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 transition-all duration-500">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div id="flash-message" class="fixed top-4 right-4 z-50 bg-red-600 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 transition-all duration-500">
    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
</div>
@endif

{{-- NAVBAR --}}
<nav class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center h-14 gap-3">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                <img src="{{ asset('images/happyHobbiesLOGO.png') }}"
                     alt="Happy Hobbies Logo"
                     class="h-8 w-8 object-cover rounded-full">
                <span class="font-heading font-extrabold text-brand-dark text-base">
                    <span class="text-brand-orange">Happy</span>Hobbies
                </span>
            </a>

            {{-- Search --}}
            <form action="{{ route('products.index') }}" method="GET" class="flex-1 max-w-md relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari kartu, set, atau rarity…"
                    class="w-full pl-8 pr-3 py-2 bg-gray-100 rounded-lg text-sm outline-none focus:bg-white focus:ring-2 focus:ring-brand-orange/20 border border-transparent focus:border-brand-orange/30 transition"/>
            </form>

            {{-- Actions --}}
            <div class="flex items-center gap-2 ml-auto">
                {{-- Cart button --}}
                <button @click="cartOpen = !cartOpen"
                    class="relative w-9 h-9 flex items-center justify-center border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <i class="fa-solid fa-cart-shopping text-gray-500 text-sm"></i>
                    <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-brand-orange text-white text-[9px] font-bold rounded-full flex items-center justify-center border-2 border-white">3</span>
                </button>

                @if(session('demo_user'))
                {{-- Avatar --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-1.5 border border-gray-200 rounded-lg hover:bg-gray-50 transition text-sm font-semibold">
                        <div class="w-6 h-6 bg-brand-orange rounded-md flex items-center justify-center text-white text-xs font-black font-heading">
                            {{ strtoupper(substr(session('demo_user.name', 'User'), 0, 1)) }}
                        </div>
                        <span class="hidden sm:block">{{ session('demo_user.name', 'User') }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400"></i>
                    </button>
                    <div x-show="open" @click.outside="open = false"
                        class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                        <a href="{{ route('account.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-50">
                            <i class="fa-solid fa-user w-4 text-gray-400"></i> Akun Saya
                        </a>
                        <a href="{{ route('account.orders') }}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-50">
                            <i class="fa-solid fa-bag-shopping w-4 text-gray-400"></i> Pesanan Saya
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                <i class="fa-solid fa-right-from-bracket w-4"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn-outline text-sm py-1.5 px-3">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary text-sm py-1.5 px-3">Daftar</a>
                @endif
            </div>
        </div>
    </div>
</nav>

{{-- CART SIDEBAR --}}
<div x-show="cartOpen" class="fixed inset-0 z-50 flex" x-cloak>
    <div @click="cartOpen = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="ml-auto relative w-full max-w-sm bg-white h-full shadow-2xl flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b">
            <h2 class="font-heading font-bold text-lg">Keranjang <span class="text-brand-orange">(3)</span></h2>
            <button @click="cartOpen = false" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100">
                <i class="fa-solid fa-xmark text-gray-500"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-4 space-y-3">
            {{-- Dummy cart items --}}
            @foreach([
                ['img'=>'🎴','name'=>'Charizard ex SAR – SV3','variant'=>null,'price'=>'Rp 1.990.000','qty'=>1],
                ['img'=>'⚓','name'=>'One Piece Promo P-069 Koala','variant'=>null,'price'=>'Rp 29.700','qty'=>2],
            ] as $item)
            <div class="flex gap-3 p-3 bg-gray-50 rounded-xl">
                <div class="w-12 h-12 bg-brand-blue rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                    {{ $item['img'] }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold leading-snug line-clamp-2">{{ $item['name'] }}</p>
                    @if($item['variant'])
                    <p class="text-[10px] text-gray-500">{{ $item['variant'] }}</p>
                    @endif
                    <div class="flex items-center justify-between mt-1.5">
                        <span class="text-xs font-bold text-brand-orange">{{ $item['price'] }}</span>
                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                            <button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:bg-gray-100 text-xs">−</button>
                            <span class="w-7 text-center text-xs font-semibold">{{ $item['qty'] }}</span>
                            <button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:bg-gray-100 text-xs">+</button>
                        </div>
                    </div>
                </div>
                <button class="text-red-400 hover:text-red-600 flex-shrink-0 mt-1">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
            </div>
            @endforeach
        </div>
        <div class="p-4 border-t bg-white">
            <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-500">Subtotal</span>
                <span class="font-semibold">Rp 2.049.400</span>
            </div>
            <div class="flex justify-between font-bold text-base mb-3">
                <span>Total</span>
                <span class="text-brand-orange">Rp 2.049.400</span>
            </div>
            @if(session('demo_user'))
            <a href="{{ route('checkout.index') }}" class="btn-primary w-full text-center block py-2.5 text-sm">
                <i class="fa-solid fa-shield-check mr-1.5"></i> Lanjut Checkout
            </a>
            @else
            <a href="{{ route('login') }}" class="btn-primary w-full text-center block py-2.5 text-sm">
                Login untuk Checkout
            </a>
            @endif
        </div>
    </div>
</div>

{{-- CONTENT --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-brand-dark2 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="col-span-2 md:col-span-1">
            <div class="font-heading font-extrabold text-lg mb-2">
                <span class="text-brand-orange">Happy</span>Hobbies
            </div>
            <p class="text-gray-400 text-xs leading-relaxed mb-4">Toko kartu TCG terpercaya di Indonesia. Original, bergaransi, pengiriman ke seluruh Indonesia.</p>
            <div class="flex gap-2">
                @foreach(['instagram','tiktok','whatsapp'] as $soc)
                <a href="#" class="w-8 h-8 bg-white/5 hover:bg-white/10 rounded-lg flex items-center justify-center transition">
                    <i class="fa-brands fa-{{ $soc }} text-gray-400 text-sm"></i>
                </a>
                @endforeach
            </div>
        </div>
        <div>
            <h4 class="font-heading font-bold text-xs uppercase tracking-widest text-gray-400 mb-3">Koleksi</h4>
            <ul class="space-y-2">
                @foreach(['Pokémon TCG','Yu-Gi-Oh!','One Piece TCG','Digimon TCG'] as $cat)
                <li><a href="{{ route('products.index', ['category' => strtolower($cat)]) }}" class="text-xs text-gray-400 hover:text-white transition">{{ $cat }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="font-heading font-bold text-xs uppercase tracking-widest text-gray-400 mb-3">Bantuan</h4>
            <ul class="space-y-2">
                @foreach(['FAQ','Cara Pembelian','Kebijakan Pengiriman','Pengembalian Barang'] as $link)
                <li><a href="#" class="text-xs text-gray-400 hover:text-white transition">{{ $link }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="font-heading font-bold text-xs uppercase tracking-widest text-gray-400 mb-3">Ikuti Kami</h4>
            <ul class="space-y-2">
                @foreach(['@happyhobbies.id','TikTok Shop','Tokopedia'] as $link)
                <li><a href="#" class="text-xs text-gray-400 hover:text-white transition">{{ $link }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="border-t border-white/5 py-4 text-center text-[11px] text-gray-500">
        © {{ date('Y') }} Happy Hobbies. Dibuat untuk Tugas Akhir.
    </div>
</footer>

@stack('scripts')
</body>
</html>