@extends('layouts.dashboard')

@section('title', 'Arsip Sejarah')
@section('page-title', 'Arsip Sejarah')
@section('page-subtitle', 'Koleksi naskah, dokumen, dan rekaman bersejarah yang tersedia untuk publik')

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
<div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-emerald-900 via-teal-800 to-brand-900 p-8 mb-8 text-white">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-2 right-6 text-9xl"><i class="fa-solid fa-scroll"></i></div>
    </div>
    <div class="relative">
        <div class="inline-flex items-center gap-2 bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full mb-3">
            <i class="fa-solid fa-scroll"></i> Dokumen Bersejarah
        </div>
        <h1 class="text-2xl font-bold mb-2">Arsip Sejarah</h1>
        <p class="text-white/70 text-sm max-w-xl">Kumpulan naskah kuno, peta bersejarah, surat-surat diplomatik, dan berbagai dokumen penting yang menjadi saksi bisu perjalanan panjang peradaban Lhokseumawe.</p>
        <p class="text-white/50 text-xs mt-3"><i class="fa-solid fa-circle-info mr-1"></i>{{ $arsip->total() }} arsip tersedia untuk publik</p>
    </div>
</div>

@if($arsip->isEmpty())
    <div class="text-center py-20 text-brand-300">
        <i class="fa-solid fa-scroll text-6xl mb-4 block opacity-30"></i>
        <p class="font-semibold text-brand-400">Belum ada arsip yang tersedia untuk publik</p>
    </div>
@else
    {{-- Layout artikel (horizontal card) untuk arsip --}}
    <div class="space-y-5 mb-8">
        @foreach($arsip as $item)
        @php
            $jenisColors = [
                'Naskah Kuno'           => 'bg-amber-100 text-amber-700 border-amber-200',
                'Foto Bersejarah'       => 'bg-purple-100 text-purple-700 border-purple-200',
                'Peta Kuno'             => 'bg-blue-100 text-blue-700 border-blue-200',
                'Surat / Dokumen Resmi' => 'bg-orange-100 text-orange-700 border-orange-200',
                'Rekaman Audio'         => 'bg-pink-100 text-pink-700 border-pink-200',
                'Rekaman Video'         => 'bg-red-100 text-red-700 border-red-200',
                'Laporan Arkeologi'     => 'bg-teal-100 text-teal-700 border-teal-200',
            ];
            $colorClass = $jenisColors[$item->jenis_koleksi] ?? 'bg-gray-100 text-gray-700 border-gray-200';
        @endphp
        <article class="bg-white rounded-2xl border border-brand-100 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group flex">
            {{-- Thumbnail Kiri --}}
            <div class="w-40 sm:w-48 shrink-0 relative overflow-hidden bg-brand-100">
                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->judul_arsip }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent to-black/10"></div>
                {{-- Icon Jenis --}}
                <div class="absolute bottom-3 left-3">
                    <div class="w-9 h-9 rounded-xl bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-sm">
                        <i class="fa-solid {{ $item->jenis_icon }} text-brand-700 text-base"></i>
                    </div>
                </div>
            </div>
            {{-- Konten --}}
            <div class="p-5 flex flex-col justify-between flex-1 min-w-0">
                <div>
                    <div class="flex items-start gap-2 mb-2 flex-wrap">
                        <span class="text-[10px] font-bold border px-2 py-0.5 rounded-full {{ $colorClass }}">{{ $item->jenis_koleksi }}</span>
                        @if($item->tahun_dokumen)
                            <span class="text-[10px] font-bold text-brand-400 flex items-center gap-1">
                                <i class="fa-regular fa-calendar"></i>{{ $item->tahun_dokumen }}
                            </span>
                        @endif
                    </div>
                    <p class="text-[10px] font-mono text-brand-300 mb-0.5">{{ $item->kode_arsip }}</p>
                    <h2 class="font-bold text-brand-900 text-sm sm:text-base leading-snug mb-2">{{ $item->judul_arsip }}</h2>

                    @if($item->deskripsi_isi)
                        <p class="text-xs text-brand-500 leading-relaxed line-clamp-3">{{ $item->deskripsi_isi }}</p>
                    @endif
                </div>

                <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-[10px] text-brand-400 border-t border-brand-50 pt-3">
                    @if($item->asal_instansi)
                        <span class="flex items-center gap-1"><i class="fa-solid fa-building-columns text-brand-300"></i>{{ $item->asal_instansi }}</span>
                    @endif
                    @if($item->bahasa)
                        <span class="flex items-center gap-1"><i class="fa-solid fa-language text-brand-300"></i>{{ $item->bahasa }}</span>
                    @endif
                    @if($item->kondisi_fisik)
                        <span class="flex items-center gap-1"><i class="fa-solid fa-shield-halved text-brand-300"></i>{{ $item->kondisi_fisik }}</span>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </div>
    <div class="flex justify-center">{{ $arsip->links() }}</div>
@endif
@endsection
