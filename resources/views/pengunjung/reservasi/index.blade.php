@extends('layouts.dashboard')

@section('title', 'Riwayat Reservasi')
@section('page-title', 'Riwayat Reservasi')
@section('page-subtitle', 'Daftar semua reservasi Anda')

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

    <p class="nav-section">Koleksi Museum</p>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-cube"></i> Artefak & 3D
    </a>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-person-chalkboard"></i> Tokoh Penting
    </a>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-scroll"></i> Arsip Sejarah
    </a>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-map-location-dot"></i> Peta Lokasi
    </a>

    <p class="nav-section">Akun</p>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-user-pen"></i> Edit Profil
    </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-brand-100 flex items-center justify-between">
        <h3 class="font-bold text-brand-800 text-sm">Semua Reservasi</h3>
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
                <th class="table-th text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservasi as $r)
            <tr class="hover:bg-brand-50 transition-colors">
                <td class="table-td font-mono text-xs text-brand-500">{{ $r->kode_booking }}</td>
                <td class="table-td font-medium">{{ $r->jenis }}</td>
                <td class="table-td text-brand-500">{{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('d M Y') }}</td>
                <td class="table-td">
                    <span class="badge {{ $r->status == 'menunggu' ? 'badge-yellow' : ($r->status == 'disetujui' ? 'badge-green' : ($r->status == 'dibatalkan' || $r->status == 'ditolak' ? 'badge-red' : 'badge-blue')) }}">{{ ucfirst($r->status) }}</span>
                </td>
                <td class="table-td text-right">
                    <a href="{{ route('pengunjung.reservasi.show', $r->id) }}" class="btn-outline text-xs py-1 px-2">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4 border-t border-brand-100">
        {{ $reservasi->links() }}
    </div>
    @else
    <div class="py-16 flex flex-col items-center text-center px-6">
        <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mb-4">
            <i class="fa-regular fa-calendar text-brand-300 text-2xl"></i>
        </div>
        <p class="font-semibold text-brand-700 text-sm mb-1">Belum ada reservasi</p>
        <p class="text-brand-400 text-xs mb-4">Buat reservasi kunjungan atau peminjaman artefak museum.</p>
        <a href="{{ route('pengunjung.reservasi.create') }}" class="btn-primary text-xs">
            <i class="fa-solid fa-calendar-plus"></i> Buat Reservasi
        </a>
    </div>
    @endif
</div>
@endsection
