@extends('layouts.admin')

@section('title', 'Koleksi Artefak')
@section('page-title', 'Koleksi Artefak')
@section('page-subtitle', 'Jelajahi dan kelola benda-benda bersejarah koleksi museum')

@section('content')
{{-- Back Button --}}
<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-800 transition">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                <i class="fa-solid fa-cube text-amber-600 text-lg"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-brand-900">Koleksi Artefak</h1>
                <p class="text-brand-400 text-xs">{{ $artefak->total() }} artefak terdaftar</p>
            </div>
        </div>
    </div>
    <a href="{{ route('admin.artefak.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
        <i class="fa-solid fa-plus"></i> Tambah Artefak
    </a>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

{{-- Grid Kartu --}}
@if($artefak->isEmpty())
    <div class="text-center py-20 text-brand-300">
        <i class="fa-solid fa-cube text-6xl mb-4 block opacity-30"></i>
        <p class="font-semibold text-brand-400">Belum ada artefak terdaftar</p>
        <p class="text-sm mt-1 text-brand-300">Mulai tambahkan koleksi pertama museum ini</p>
        <a href="{{ route('admin.artefak.create') }}" class="btn-primary mt-4 inline-flex">Tambah Sekarang</a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($artefak as $item)
        <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group">
            {{-- Gambar --}}
            <div class="relative h-44 overflow-hidden bg-brand-50">
                <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_artefak }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                {{-- Badge Kondisi --}}
                <div class="absolute top-3 left-3">
                    <span class="flex items-center gap-1 bg-white/90 backdrop-blur-sm text-[10px] font-bold px-2 py-1 rounded-full border border-brand-100">
                        <span class="w-1.5 h-1.5 rounded-full {{ $item->health_color }}"></span>
                        {{ $item->persentase_keutuhan ?? 100 }}%
                    </span>
                </div>
                {{-- Badge Status Pinjam --}}
                <div class="absolute top-3 right-3">
                    @if($item->bisa_dipinjam)
                        <span class="bg-emerald-500 text-white text-[9px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">Tersedia</span>
                    @else
                        <span class="bg-gray-400 text-white text-[9px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">Koleksi Tetap</span>
                    @endif
                </div>
            </div>
            {{-- Konten --}}
            <div class="p-4">
                <p class="text-[10px] font-mono text-brand-400 mb-0.5">{{ $item->kode_registrasi }}</p>
                <h3 class="font-bold text-brand-900 text-base leading-tight mb-1">{{ $item->nama_artefak }}</h3>
                @if($item->nama_lokal)
                    <p class="text-xs text-brand-400 italic mb-2">"{{ $item->nama_lokal }}"</p>
                @endif

                <div class="flex items-center gap-2 mb-3">
                    @if($item->era_periodisasi)
                        <span class="text-[10px] bg-amber-50 text-amber-700 border border-amber-200 px-2 py-0.5 rounded-full font-semibold">
                            {{ $item->era_periodisasi }}
                        </span>
                    @endif
                    @if($item->kategori)
                        <span class="text-[10px] bg-brand-50 text-brand-600 border border-brand-200 px-2 py-0.5 rounded-full font-semibold">
                            {{ $item->kategori }}
                        </span>
                    @endif
                </div>

                @if($item->deskripsi)
                    <p class="text-xs text-brand-500 leading-relaxed line-clamp-3">{{ $item->deskripsi }}</p>
                @endif

                <div class="mt-3 pt-3 border-t border-brand-50 flex items-center justify-between text-[10px] text-brand-400">
                    <span><i class="fa-solid fa-map-pin mr-1"></i>{{ $item->asal_daerah ?? 'Tidak diketahui' }}</span>
                    <span><i class="fa-solid fa-gem mr-1"></i>{{ $item->bahan_utama ?? '-' }}</span>
                </div>
                <div class="mt-2 pt-2 border-t border-brand-50 flex items-center justify-end gap-2">
                    <a href="{{ route('admin.artefak.edit', $item->id) }}" class="text-brand-500 hover:text-brand-700" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('admin.artefak.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artefak ini?');">
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

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $artefak->links() }}
    </div>
@endif
@endsection
