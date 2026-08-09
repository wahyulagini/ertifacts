@extends('layouts.dashboard')

@section('title', 'Koleksi Artefak')
@section('page-title', 'Koleksi Artefak')
@section('page-subtitle', 'Jelajahi benda-benda bersejarah koleksi Museum E-RTIFACT Lhokseumawe')

@section('sidebar-nav')
<p class="nav-section">Menu Utama</p>
<a href="{{ route('pengunjung.dashboard') }}" class="nav-link {{ request()->routeIs('pengunjung.dashboard') ? 'active' : '' }}">
    <i class="fa-solid fa-house"></i> Beranda
</a>
<a href="{{ route('pengunjung.reservasi.create') }}" class="nav-link {{ request()->routeIs('pengunjung.reservasi.create') ? 'active' : '' }}">
    <i class="fa-solid fa-calendar-plus"></i> Buat Reservasi
</a>
<a href="{{ route('pengunjung.reservasi.index') }}" class="nav-link {{ request()->routeIs('pengunjung.reservasi.*') ? 'active' : '' }}">
    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Reservasi
</a>

<p class="nav-section">Koleksi Museum</p>
<a href="{{ route('pengunjung.koleksi.artefak') }}" class="nav-link {{ request()->routeIs('pengunjung.koleksi.artefak') ? 'active' : '' }}">
    <i class="fa-solid fa-cube"></i> Artefak
</a>
<a href="{{ route('pengunjung.koleksi.tokoh') }}" class="nav-link {{ request()->routeIs('pengunjung.koleksi.tokoh') ? 'active' : '' }}">
    <i class="fa-solid fa-person-chalkboard"></i> Tokoh Penting
</a>
<a href="{{ route('pengunjung.koleksi.arsip') }}" class="nav-link {{ request()->routeIs('pengunjung.koleksi.arsip') ? 'active' : '' }}">
    <i class="fa-solid fa-scroll"></i> Arsip Sejarah
</a>
<a href="{{ route('pengunjung.koleksi.lokasi') }}" class="nav-link {{ request()->routeIs('pengunjung.koleksi.lokasi') ? 'active' : '' }}">
    <i class="fa-solid fa-map-location-dot"></i> Peta Lokasi
</a>

<p class="nav-section">Akun</p>
<a href="{{ route('pengunjung.profil') }}" class="nav-link {{ request()->routeIs('pengunjung.profil') ? 'active' : '' }}">
    <i class="fa-solid fa-user-pen"></i> Edit Profil
</a>
@endsection

@section('content')
{{-- Back Button --}}
<div class="mb-4">
    <a href="{{ route('pengunjung.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-800 transition">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
{{-- Hero Banner --}}
<div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-brand-900 via-brand-800 to-amber-900 p-8 mb-8 text-white">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-4 right-8 text-8xl"><i class="fa-solid fa-cube"></i></div>
    </div>
    <div class="relative">
        <div class="inline-flex items-center gap-2 bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full mb-3">
            <i class="fa-solid fa-cube"></i> Koleksi E-RTIFACT
        </div>
        <h1 class="text-2xl font-bold mb-2">Artefak Bersejarah</h1>
        <p class="text-white/70 text-sm max-w-xl">Temukan benda-benda bersejarah peninggalan Kesultanan Samudera Pasai dan peradaban kuno Lhokseumawe yang tersimpan di museum ini.</p>
        <p class="text-white/50 text-xs mt-3"><i class="fa-solid fa-circle-info mr-1"></i>{{ $artefak->total() }} artefak dalam koleksi</p>
    </div>
</div>

{{-- Grid Kartu --}}
@if($artefak->isEmpty())
    <div class="text-center py-20 text-brand-300">
        <i class="fa-solid fa-cube text-6xl mb-4 block opacity-30"></i>
        <p class="font-semibold text-brand-400">Koleksi artefak sedang dipersiapkan</p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($artefak as $item)
        <article class="bg-white rounded-2xl border border-brand-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            {{-- Gambar --}}
            <div class="relative h-48 overflow-hidden bg-brand-50">
                <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_artefak }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                {{-- Kondisi Badge --}}
                <div class="absolute top-3 left-3">
                    <span class="flex items-center gap-1 bg-white/90 backdrop-blur-sm text-[10px] font-bold px-2 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full {{ $item->health_color }}"></span>
                        Keutuhan {{ $item->persentase_keutuhan ?? 100 }}%
                    </span>
                </div>
                @if($item->bisa_dipinjam)
                <div class="absolute top-3 right-3">
                    <span class="bg-emerald-500 text-white text-[9px] font-bold px-2 py-1 rounded-full uppercase">Bisa Dipinjam</span>
                </div>
                @endif
                {{-- Nama di atas gambar --}}
                <div class="absolute bottom-3 left-3 right-3">
                    <h2 class="text-white font-bold text-sm drop-shadow-lg leading-tight">{{ $item->nama_artefak }}</h2>
                    @if($item->nama_lokal)
                        <p class="text-white/70 text-[10px] italic">"{{ $item->nama_lokal }}"</p>
                    @endif
                </div>
            </div>
            {{-- Konten --}}
            <div class="p-4">
                <div class="flex flex-wrap gap-1.5 mb-3">
                    @if($item->era_periodisasi)
                        <span class="text-[10px] bg-amber-50 text-amber-700 border border-amber-200 px-2 py-0.5 rounded-full font-semibold">
                            <i class="fa-solid fa-hourglass-half mr-0.5"></i>{{ $item->era_periodisasi }}
                        </span>
                    @endif
                    @if($item->kategori)
                        <span class="text-[10px] bg-brand-50 text-brand-600 border border-brand-200 px-2 py-0.5 rounded-full font-semibold">
                            {{ $item->kategori }}
                        </span>
                    @endif
                </div>

                @if($item->deskripsi)
                    <p class="text-xs text-brand-600 leading-relaxed line-clamp-4">{{ $item->deskripsi }}</p>
                @else
                    <p class="text-xs text-brand-400 italic">Deskripsi belum tersedia.</p>
                @endif

                <div class="mt-4 pt-3 border-t border-brand-50 grid grid-cols-2 gap-y-1 text-[10px] text-brand-400">
                    @if($item->asal_daerah)
                    <span class="flex items-center gap-1"><i class="fa-solid fa-map-pin text-brand-300"></i>{{ $item->asal_daerah }}</span>
                    @endif
                    @if($item->bahan_utama)
                    <span class="flex items-center gap-1"><i class="fa-solid fa-gem text-brand-300"></i>{{ $item->bahan_utama }}</span>
                    @endif
                    @if($item->periode_abad)
                    <span class="flex items-center gap-1 col-span-2"><i class="fa-solid fa-calendar text-brand-300"></i>{{ $item->periode_abad }}</span>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </div>
    <div class="flex justify-center">{{ $artefak->links() }}</div>
@endif
@endsection
