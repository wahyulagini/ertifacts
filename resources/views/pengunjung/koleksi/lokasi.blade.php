@extends('layouts.dashboard')

@section('title', 'Peta Lokasi')
@section('page-title', 'Peta Lokasi')
@section('page-subtitle', 'Situs dan tempat bersejarah yang tersebar di wilayah Lhokseumawe')

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
<div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-rose-900 via-red-800 to-brand-900 p-8 mb-8 text-white">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-2 right-4 text-9xl"><i class="fa-solid fa-map-location-dot"></i></div>
    </div>
    <div class="relative">
        <div class="inline-flex items-center gap-2 bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full mb-3">
            <i class="fa-solid fa-map-location-dot"></i> Situs Bersejarah
        </div>
        <h1 class="text-2xl font-bold mb-2">Peta Lokasi Bersejarah</h1>
        <p class="text-white/70 text-sm max-w-xl">Jelajahi situs-situs bersejarah di Lhokseumawe dan sekitarnya. Dari makam sultan hingga benteng peninggalan masa perang, semua tersimpan di sini.</p>
        <p class="text-white/50 text-xs mt-3"><i class="fa-solid fa-circle-info mr-1"></i>{{ $lokasi->total() }} lokasi bersejarah</p>
    </div>
</div>

@if($lokasi->isEmpty())
    <div class="text-center py-20 text-brand-300">
        <i class="fa-solid fa-map-location-dot text-6xl mb-4 block opacity-30"></i>
        <p class="font-semibold text-brand-400">Belum ada lokasi yang terdaftar</p>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8">
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
        <article class="bg-white rounded-2xl border border-brand-100 overflow-hidden hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 group">
            {{-- Gambar --}}
            <div class="h-44 relative overflow-hidden bg-brand-100">
                <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_lokasi }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                {{-- Status badge --}}
                <div class="absolute top-3 right-3">
                    <span class="flex items-center gap-1 bg-white/90 backdrop-blur-sm text-[10px] font-bold px-2 py-1 rounded-full {{ $statusColor['label'] }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $statusColor['dot'] }}"></span>
                        {{ $item->status_kelola }}
                    </span>
                </div>
                {{-- Nama di gambar --}}
                <div class="absolute bottom-3 left-4 right-4">
                    <span class="text-[10px] bg-rose-500 text-white font-bold px-2 py-0.5 rounded-full mb-1 inline-block">{{ $item->jenis_lokasi }}</span>
                    <h2 class="text-white font-bold text-base drop-shadow-lg">{{ $item->nama_lokasi }}</h2>
                </div>
            </div>

            {{-- Konten --}}
            <div class="p-4">
                @if($item->deskripsi)
                    <p class="text-xs text-brand-500 leading-relaxed mb-4">{{ Str::limit($item->deskripsi, 200) }}</p>
                @endif

                <div class="grid grid-cols-2 gap-3 text-xs text-brand-500 mb-3">
                    @if($item->alamat_lengkap)
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-map-pin text-rose-400 mt-0.5 shrink-0"></i>
                        <span>{{ $item->alamat_lengkap }}</span>
                    </div>
                    @endif
                    @if($item->pengelola)
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-building text-brand-300 mt-0.5 shrink-0"></i>
                        <span>{{ $item->pengelola }}</span>
                    </div>
                    @endif
                    @if($item->jam_operasional)
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-clock text-brand-300 shrink-0"></i>
                        <span>{{ $item->jam_operasional }}</span>
                    </div>
                    @endif
                    @if($item->periode_sejarah)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-hourglass text-brand-300 shrink-0"></i>
                        <span>{{ $item->periode_sejarah }}</span>
                    </div>
                    @endif
                </div>

                @if($item->hasCoordinates())
                <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longitude }}"
                    target="_blank"
                    class="flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-brand-50 hover:bg-brand-100 border border-brand-200 text-brand-700 text-xs font-bold transition">
                    <i class="fa-solid fa-map-location-dot text-rose-500"></i>
                    Buka di Google Maps
                </a>
                @endif
            </div>
        </article>
        @endforeach
    </div>
    <div class="flex justify-center">{{ $lokasi->links() }}</div>
@endif
@endsection
