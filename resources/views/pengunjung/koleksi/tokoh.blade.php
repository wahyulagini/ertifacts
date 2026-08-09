@extends('layouts.dashboard')

@section('title', 'Tokoh Penting')
@section('page-title', 'Tokoh Penting')
@section('page-subtitle', 'Para tokoh bersejarah yang membentuk peradaban Lhokseumawe dan Samudera Pasai')

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
{{-- Hero --}}
<div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-brand-900 p-8 mb-8 text-white">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-2 right-6 text-9xl"><i class="fa-solid fa-person-chalkboard"></i></div>
    </div>
    <div class="relative">
        <div class="inline-flex items-center gap-2 bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full mb-3">
            <i class="fa-solid fa-person-chalkboard"></i> Tokoh Bersejarah
        </div>
        <h1 class="text-2xl font-bold mb-2">Tokoh Penting</h1>
        <p class="text-white/70 text-sm max-w-xl">Mengenal para tokoh yang perannya membentuk peradaban Islam di Nusantara, dari sultan-sultan Samudera Pasai hingga para pejuang kemerdekaan di tanah Lhokseumawe.</p>
        <p class="text-white/50 text-xs mt-3"><i class="fa-solid fa-circle-info mr-1"></i>{{ $tokoh->total() }} tokoh dalam koleksi</p>
    </div>
</div>

@if($tokoh->isEmpty())
    <div class="text-center py-20 text-brand-300">
        <i class="fa-solid fa-person-chalkboard text-6xl mb-4 block opacity-30"></i>
        <p class="font-semibold text-brand-400">Koleksi tokoh sedang dipersiapkan</p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($tokoh as $item)
        <article class="bg-white rounded-2xl border border-brand-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            {{-- Foto --}}
            <div class="relative h-52 overflow-hidden">
                <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_tokoh }}"
                    class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                @if($item->era_aktif)
                <div class="absolute top-3 right-3">
                    <span class="bg-brand-900/80 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded-full">{{ $item->era_aktif }}</span>
                </div>
                @endif
                <div class="absolute bottom-4 left-4 right-4">
                    <h2 class="text-white font-bold text-base drop-shadow-lg leading-tight">{{ $item->nama_tokoh }}</h2>
                    @if($item->nama_julukan)
                        <p class="text-white/70 text-xs italic">"{{ $item->nama_julukan }}"</p>
                    @endif
                </div>
            </div>
            {{-- Konten --}}
            <div class="p-4">
                @if($item->gelar)
                <span class="inline-block text-[10px] bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded-full font-semibold mb-2">{{ $item->gelar }}</span>
                @endif
                @if($item->peran)
                <p class="text-xs font-bold text-brand-700 mb-2 flex items-center gap-1.5">
                    <span class="w-1 h-4 bg-amber-400 rounded-full shrink-0"></span>{{ $item->peran }}
                </p>
                @endif

                @if($item->biografi)
                    <p class="text-xs text-brand-500 leading-relaxed line-clamp-4">{{ $item->biografi }}</p>
                @endif

                @if($item->kontribusi)
                <div class="mt-3 p-3 bg-amber-50 border border-amber-100 rounded-xl">
                    <p class="text-[10px] font-bold text-amber-700 mb-1">Kontribusi Utama</p>
                    <p class="text-xs text-amber-800 leading-relaxed">{{ Str::limit($item->kontribusi, 120) }}</p>
                </div>
                @endif

                <div class="mt-3 pt-3 border-t border-brand-50 flex items-center justify-between text-[10px] text-brand-400">
                    <span><i class="fa-solid fa-location-dot mr-1"></i>{{ $item->tempat_asal ?? 'Tidak diketahui' }}</span>
                    <span>{{ $item->periode_label }}</span>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    <div class="flex justify-center">{{ $tokoh->links() }}</div>
@endif
@endsection
