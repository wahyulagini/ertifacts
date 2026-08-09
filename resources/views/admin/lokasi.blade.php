@extends('layouts.admin')

@section('title', 'Lokasi Geografis')
@section('page-title', 'Lokasi Geografis')
@section('page-subtitle', 'Peta situs dan lokasi bersejarah di wilayah Lhokseumawe')

@section('content')
{{-- Back Button --}}
<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-800 transition">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center">
            <i class="fa-solid fa-map-location-dot text-rose-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-brand-900">Lokasi Geografis</h1>
            <p class="text-brand-400 text-xs">{{ $lokasi->total() }} lokasi terdaftar</p>
        </div>
    </div>
    <a href="{{ route('admin.lokasi.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
        <i class="fa-solid fa-plus"></i> Tambah Lokasi
    </a>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

@if($lokasi->isEmpty())
    <div class="text-center py-20 text-brand-300">
        <i class="fa-solid fa-map-location-dot text-6xl mb-4 block opacity-30"></i>
        <p class="font-semibold text-brand-400">Belum ada lokasi terdaftar</p>
        <a href="{{ route('admin.lokasi.create') }}" class="btn-primary mt-4 inline-flex">Tambah Sekarang</a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
        @foreach($lokasi as $item)
        @php
            $statusColor = match($item->status_kelola) {
                'Aktif Dijaga'   => ['dot'=>'bg-emerald-500','label'=>'text-emerald-700','pill'=>'bg-emerald-50 border-emerald-200'],
                'Terbengkalai'   => ['dot'=>'bg-amber-500','label'=>'text-amber-700','pill'=>'bg-amber-50 border-amber-200'],
                'Renovasi'       => ['dot'=>'bg-blue-500','label'=>'text-blue-700','pill'=>'bg-blue-50 border-blue-200'],
                'Tertutup'       => ['dot'=>'bg-red-500','label'=>'text-red-700','pill'=>'bg-red-50 border-red-200'],
                default          => ['dot'=>'bg-gray-400','label'=>'text-gray-600','pill'=>'bg-gray-50 border-gray-200'],
            };
        @endphp
        <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group flex">
            {{-- Gambar Kiri (landscape) --}}
            <div class="w-36 shrink-0 overflow-hidden bg-brand-100 relative">
                <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_lokasi }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent to-black/5"></div>
            </div>
            {{-- Konten --}}
            <div class="p-4 flex flex-col justify-between flex-1 min-w-0">
                <div>
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <h3 class="font-bold text-brand-900 text-sm leading-snug">{{ $item->nama_lokasi }}</h3>
                        <span class="flex items-center gap-1 {{ $statusColor['pill'] }} border text-[9px] font-bold px-2 py-0.5 rounded-full shrink-0 {{ $statusColor['label'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusColor['dot'] }}"></span>
                            {{ $item->status_kelola }}
                        </span>
                    </div>

                    <span class="inline-block text-[10px] bg-rose-50 text-rose-700 border border-rose-200 px-2 py-0.5 rounded-full font-semibold mb-2">
                        {{ $item->jenis_lokasi }}
                    </span>

                    @if($item->deskripsi)
                        <p class="text-xs text-brand-500 leading-relaxed line-clamp-2">{{ $item->deskripsi }}</p>
                    @endif
                </div>

                <div class="mt-2 flex items-center justify-between">
                    <div class="text-[10px] text-brand-400">
                        <i class="fa-solid fa-map-pin mr-1"></i>{{ $item->alamat_lengkap ?: 'Lokasi tidak tersedia' }}
                    </div>
                    @if($item->hasCoordinates())
                        <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longitude }}"
                            target="_blank"
                            class="text-[10px] font-bold text-brand-600 hover:text-brand-900 flex items-center gap-1 shrink-0">
                            <i class="fa-solid fa-map-location-dot"></i> Maps
                        </a>
                    @endif
                </div>

                @if($item->jam_operasional)
                    <div class="mt-1 text-[10px] text-brand-400">
                        <i class="fa-regular fa-clock mr-1"></i>{{ $item->jam_operasional }}
                    </div>
                @endif
                <div class="mt-2 pt-2 border-t border-brand-50 flex items-center justify-end gap-2">
                    <a href="{{ route('admin.lokasi.edit', $item->id) }}" class="text-brand-500 hover:text-brand-700" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('admin.lokasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="flex justify-center">{{ $lokasi->links() }}</div>
@endif
@endsection
