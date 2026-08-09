@extends('layouts.dashboard')

@section('title', 'Dashboard Pengunjung')
@section('page-title', 'Dashboard Saya')
@section('page-subtitle', 'Selamat datang di E-RTIFACT Museum Digital Lhokseumawe')

@section('sidebar-nav')
    <p class="nav-section">Menu Utama</p>
    <a href="{{ route('pengunjung.dashboard') }}" class="nav-link {{ request()->routeIs('pengunjung.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i> Beranda
    </a>
    <a href="{{ route('pengunjung.reservasi.create') }}" class="nav-link {{ request()->routeIs('pengunjung.reservasi.create') ? 'active' : '' }}">
        <i class="fa-solid fa-calendar-plus"></i> Buat Reservasi
    </a>
    <a href="{{ route('pengunjung.reservasi.index') }}" class="nav-link {{ request()->routeIs('pengunjung.reservasi.index', 'pengunjung.reservasi.show') ? 'active' : '' }}">
        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Reservasi
    </a>

    <p class="nav-section mt-6">Koleksi Museum</p>
    <a href="{{ route('landing') }}" class="nav-link">
        <i class="fa-solid fa-museum"></i> Lihat Katalog
    </a>

    <p class="nav-section">Akun</p>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-user-pen"></i> Edit Profil
    </a>
@endsection

@section('content')

{{-- Greeting --}}
<div class="mb-6">
    <h2 class="font-serif text-2xl font-bold text-brand-900">
        Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋
    </h2>
    <p class="text-brand-400 text-sm mt-1">Ini ringkasan aktivitas kunjungan dan koleksi museum untuk Anda.</p>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['fa-calendar-check', 'Total Reservasi',    $stats['total_reservasi']    ?? 0,  'bg-teal-50 text-teal-600'],
        ['fa-hourglass-half', 'Menunggu Approval',  $stats['menunggu']           ?? 0,  'bg-yellow-50 text-yellow-600'],
        ['fa-circle-check',   'Disetujui',          $stats['disetujui']          ?? 0,  'bg-emerald-50 text-emerald-600'],
        ['fa-cube',           'Koleksi Artefak',    $stats['total_artefak']      ?? 0,  'bg-purple-50 text-purple-600'],
    ] as [$icon, $label, $val, $cls])
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs text-brand-400 font-medium mb-1">{{ $label }}</p>
                <p class="font-serif text-3xl font-bold text-brand-900">{{ $val }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl {{ $cls }} flex items-center justify-center">
                <i class="fa-solid {{ $icon }} text-sm"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Reservasi terbaru --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-brand-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-brand-100 flex items-center justify-between">
            <h3 class="font-bold text-brand-800 text-sm">Reservasi Terbaru</h3>
            <a href="{{ route('pengunjung.reservasi.create') }}" class="btn-primary text-xs py-1.5 px-3">
                <i class="fa-solid fa-plus"></i> Buat Baru
            </a>
        </div>
        @if(isset($reservasi) && $reservasi->count())
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th text-left">Kode</th>
                    <th class="table-th text-left">Jenis</th>
                    <th class="table-th text-left">Tanggal</th>
                    <th class="table-th text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservasi as $r)
                <tr class="hover:bg-brand-50 transition-colors">
                    <td class="table-td font-mono text-xs text-brand-500">{{ $r->kode_booking }}</td>
                    <td class="table-td font-medium">{{ $r->jenis }}</td>
                    <td class="table-td text-brand-500">{{ $r->tanggal_kunjungan->format('d M Y') }}</td>
                    <td class="table-td">
                        <span class="badge {{ $r->status_badge_color }}">{{ $r->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        {{-- Empty state --}}
        <div class="py-16 flex flex-col items-center text-center px-6">
            <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mb-4">
                <i class="fa-regular fa-calendar text-brand-300 text-2xl"></i>
            </div>
            <p class="font-semibold text-brand-700 text-sm mb-1">Belum ada reservasi</p>
            <p class="text-brand-400 text-xs mb-4">Buat reservasi kunjungan atau peminjaman artefak museum.</p>
            <a href="{{ route('pengunjung.reservasi.create') }}" class="btn-primary text-xs">
                <i class="fa-solid fa-calendar-plus"></i> Buat Reservasi Pertama
            </a>
        </div>
        @endif
    </div>

    {{-- Info museum & tenant --}}
    <div class="space-y-4">

        {{-- Info kunjungan --}}
        <div class="bg-white rounded-2xl border border-brand-200 p-5 space-y-3">
            <h3 class="font-bold text-brand-800 text-sm">Info Museum</h3>
            <div class="space-y-2 text-xs text-brand-500">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-clock text-brand-gold w-4"></i>
                    <span>Sesi Pagi: 08.00 – 12.00 WIB</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-clock text-brand-gold w-4"></i>
                    <span>Sesi Siang: 12.00 – 16.00 WIB</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-ticket text-brand-gold w-4"></i>
                    <span>Tiket Umum: Rp 15.000 / orang</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-users text-brand-gold w-4"></i>
                    <span>Rombongan: Rp 10.000 / orang</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-map-pin text-brand-gold w-4"></i>
                    <span>Lhokseumawe, Aceh</span>
                </div>
            </div>
        </div>

        {{-- tenant aktif --}}
        <div class="bg-white rounded-2xl border border-brand-200 p-5 space-y-3">
            <h3 class="font-bold text-brand-800 text-sm">tenant Aktif di Museum</h3>
            @if(isset($tenant_aktif) && $tenant_aktif->count())
                <div class="space-y-2">
                    @foreach($tenant_aktif as $m)
                    <div class="flex items-center gap-3 py-1.5">
                        <div class="w-8 h-8 rounded-lg bg-brand-100 flex items-center justify-center text-brand-500 text-xs font-bold shrink-0">
                            {{ strtoupper(substr($m->nama_usaha, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-brand-800 truncate">{{ $m->nama_usaha }}</p>
                            <p class="text-[10px] text-brand-400">{{ $m->jenis_tenant }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-brand-400">Belum ada tenant aktif.</p>
            @endif
        </div>
    </div>

</div>
@endsection
