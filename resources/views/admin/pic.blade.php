@extends('layouts.admin')
@section('title','Manajemen PIC')

@section('content')
@php
$pics = [
    ['init'=>'AB','bg'=>'bg-brand-orange','name'=>'Admin Budi','email'=>'budi@happyhobbies.id','count'=>150,'target'=>175,'sessions'=>3,'time'=>'09:31 WIB','status'=>'active'],
    ['init'=>'AS','bg'=>'bg-purple-500',  'name'=>'Admin Siti','email'=>'siti@happyhobbies.id','count'=>25, 'target'=>175,'sessions'=>1,'time'=>'08:57 WIB','status'=>'active'],
    ['init'=>'AR','bg'=>'bg-gray-500',    'name'=>'Admin Reza','email'=>'reza@happyhobbies.id','count'=>0,  'target'=>175,'sessions'=>0,'time'=>'—',        'status'=>'inactive'],
];

$logs = [
    ['ok'=>true, 'file'=>'pokemon_sv4_batch3.xlsx','detail'=>'Admin Budi · 75 produk berhasil','time'=>'09:31 WIB'],
    ['ok'=>true, 'file'=>'onepiece_op06_all.xlsx',  'detail'=>'Admin Siti · 25 produk berhasil','time'=>'08:57 WIB'],
    ['ok'=>true, 'file'=>'pokemon_sv3_batch2.xlsx', 'detail'=>'Admin Budi · 50 produk berhasil','time'=>'09:05 WIB'],
    ['ok'=>false,'file'=>'pokemon_promo_batch1.xlsx','detail'=>'Admin Budi · 3 baris error: kolom harga kosong','time'=>'08:15 WIB'],
];
@endphp

{{-- Header --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="font-heading font-extrabold text-xl text-gray-900">Manajemen PIC</h1>
        <p class="text-xs text-gray-500 mt-0.5">Kelola akun PIC dan pantau kinerja harian</p>
    </div>
    <div class="flex gap-2">
        <button class="btn-outline text-xs py-1.5 px-3 flex items-center gap-1.5">
            <i class="fa-solid fa-file-export"></i> Export CSV
        </button>
        <button class="btn-primary text-xs py-1.5 px-3 flex items-center gap-1.5">
            <i class="fa-solid fa-user-plus"></i> Tambah PIC
        </button>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-3 gap-4 mb-5">
    @foreach([
        ['icon'=>'fa-users',      'bg'=>'bg-green-100','color'=>'text-green-600','value'=>count(array_filter($pics,fn($p)=>$p['status']==='active')),'label'=>'Total PIC Aktif'],
        ['icon'=>'fa-upload',     'bg'=>'bg-orange-100','color'=>'text-brand-orange','value'=>'175 SKU','label'=>'Total Input Hari Ini'],
        ['icon'=>'fa-cloud-arrow-up','bg'=>'bg-blue-100','color'=>'text-blue-600','value'=>count($logs),'label'=>'Sesi Upload Hari Ini'],
    ] as $s)
    <div class="card p-4 flex items-center gap-3">
        <div class="{{ $s['bg'] }} w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid {{ $s['icon'] }} {{ $s['color'] }} text-base"></i>
        </div>
        <div>
            <p class="font-heading font-extrabold text-xl leading-none {{ $s['color'] }}">{{ $s['value'] }}</p>
            <p class="text-[11px] text-gray-500 mt-0.5">{{ $s['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Kinerja harian --}}
<div class="card overflow-hidden mb-4">
    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-heading font-bold text-sm">Laporan Kinerja PIC Hari Ini</h2>
        <div class="flex items-center gap-1.5 text-[10px] text-green-600 font-semibold">
            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Live
        </div>
    </div>
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                @foreach(['PIC','Produk Diinput','Progress Hari Ini','Waktu Terakhir','Status','Aksi'] as $h)
                <th class="px-4 py-2.5 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wide">{{ $h }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($pics as $pic)
            @php $pct = $pic['target'] > 0 ? round($pic['count'] / $pic['target'] * 100) : 0; @endphp
            <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50/50 transition">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2.5">
                        <div class="{{ $pic['bg'] }} w-8 h-8 rounded-lg flex items-center justify-center font-heading font-black text-xs text-white flex-shrink-0">
                            {{ $pic['init'] }}
                        </div>
                        <div>
                            <p class="text-xs font-semibold">{{ $pic['name'] }}</p>
                            <p class="text-[10px] text-gray-400">{{ $pic['email'] }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <span class="font-heading font-extrabold text-lg text-gray-800">{{ $pic['count'] }}</span>
                    <span class="text-xs text-gray-400 ml-1">produk</span>
                    <p class="text-[10px] text-gray-400">Target: {{ $pic['target'] }}/hari</p>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden w-24">
                            <div class="h-full rounded-full transition-all
                                {{ $pct >= 100 ? 'bg-green-500' : ($pct >= 60 ? 'bg-brand-orange' : ($pct > 0 ? 'bg-amber-400' : 'bg-gray-300')) }}"
                                style="width: {{ min($pct, 100) }}%"></div>
                        </div>
                        <span class="text-[10px] font-semibold text-gray-600">{{ $pct }}%</span>
                    </div>
                    <p class="text-[10px] text-gray-400">{{ $pic['sessions'] }} sesi upload</p>
                </td>
                <td class="px-4 py-3 text-xs font-semibold text-gray-700">{{ $pic['time'] }}</td>
                <td class="px-4 py-3">
                    @if($pic['status'] === 'active')
                    <span class="badge-active text-[10px]">Aktif</span>
                    @else
                    <span class="badge-inactive text-[10px]">Offline</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-1.5">
                        <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-gray-500 hover:border-brand-orange hover:text-brand-orange transition text-[10px]">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-red-400 hover:border-red-300 hover:bg-red-50 transition text-[10px]">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-2.5 bg-gray-50 border-t border-gray-100 flex justify-between text-[11px] text-gray-500">
        <span><i class="fa-solid fa-rotate mr-1.5"></i>Diperbarui otomatis setiap upload selesai</span>
        <span>Total hari ini: <strong class="text-gray-700">175 produk</strong></span>
    </div>
</div>

{{-- Upload log --}}
<div class="card overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-100">
        <h2 class="font-heading font-bold text-sm">Riwayat Upload Hari Ini</h2>
    </div>
    @foreach($logs as $log)
    <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-50/50 transition">
        <div class="w-8 h-8 rounded-full {{ $log['ok'] ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center flex-shrink-0">
            <i class="fa-solid {{ $log['ok'] ? 'fa-check text-green-600' : 'fa-xmark text-red-500' }} text-xs"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold font-mono">{{ $log['file'] }}</p>
            <p class="text-[11px] text-gray-500">{{ $log['detail'] }}</p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <span class="text-[10px] text-gray-400">{{ $log['time'] }}</span>
            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full {{ $log['ok'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                {{ $log['ok'] ? 'Sukses' : 'Error' }}
            </span>
        </div>
    </div>
    @endforeach
</div>

@endsection
