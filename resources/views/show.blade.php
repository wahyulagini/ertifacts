@extends('layouts.dashboard')
@section('title','Detail Reservasi')
@section('page-title','Detail Reservasi')
@section('page-subtitle', $reservasi->kode_booking)

@section('sidebar-nav')
<p class="nav-section">Menu Utama</p>
<a href="{{ route('pengunjung.dashboard') }}" class="nav-link"><i class="fa-solid fa-house"></i> Beranda</a>
<a href="{{ route('pengunjung.reservasi.index') }}" class="nav-link active"><i class="fa-solid fa-calendar-check"></i> Reservasi Saya</a>
<a href="{{ route('pengunjung.transaksi.index') }}" class="nav-link"><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</a>
<p class="nav-section">Koleksi</p>
<a href="#" class="nav-link"><i class="fa-solid fa-cube"></i> Artefak & 3D</a>
<a href="{{ route('pengunjung.profil') }}" class="nav-link"><i class="fa-solid fa-user-pen"></i> Edit Profil</a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto space-y-5">
    <a href="{{ route('pengunjung.reservasi.index') }}" class="inline-flex items-center gap-2 text-sm text-brand-400 hover:text-brand-600">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke daftar
    </a>

    {{-- Status banner --}}
    @php
        $bannerClass = match($reservasi->status) {
            'menunggu'   => 'bg-yellow-50 border-yellow-200 text-yellow-800',
            'disetujui'  => 'bg-emerald-50 border-emerald-200 text-emerald-800',
            'ditolak'    => 'bg-red-50 border-red-200 text-red-800',
            'selesai'    => 'bg-blue-50 border-blue-200 text-blue-800',
            default      => 'bg-gray-50 border-gray-200 text-gray-700',
        };
        $bannerIcon = match($reservasi->status) {
            'menunggu'   => 'fa-hourglass-half',
            'disetujui'  => 'fa-circle-check',
            'ditolak'    => 'fa-circle-xmark',
            'selesai'    => 'fa-flag-checkered',
            default      => 'fa-circle-info',
        };
    @endphp
    <div class="flex items-center gap-3 border rounded-xl px-4 py-3 {{ $bannerClass }}">
        <i class="fa-solid {{ $bannerIcon }} text-lg shrink-0"></i>
        <div>
            <p class="font-bold text-sm">Status: {{ ucfirst($reservasi->status) }}</p>
            @if($reservasi->catatan_admin)
            <p class="text-xs mt-0.5">Catatan admin: {{ $reservasi->catatan_admin }}</p>
            @endif
        </div>
    </div>

    {{-- Info utama --}}
    <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
        <div class="bg-brand-800 px-5 py-4">
            <p class="text-brand-300 text-[10px] font-bold uppercase tracking-wider">Kode Booking</p>
            <p class="text-white font-mono font-bold text-lg">{{ $reservasi->kode_booking }}</p>
        </div>
        <div class="p-5 grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-brand-400">Jenis</p>
                <p class="font-semibold text-brand-800 mt-0.5">{{ $reservasi->jenis }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-brand-400">Tanggal Kunjungan</p>
                <p class="font-semibold text-brand-800 mt-0.5">{{ $reservasi->tanggal_kunjungan->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-brand-400">Sesi</p>
                <p class="font-semibold text-brand-800 mt-0.5">{{ $reservasi->sesi }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-brand-400">Jumlah Orang</p>
                <p class="font-semibold text-brand-800 mt-0.5">{{ $reservasi->jumlah_orang }} orang</p>
            </div>
            @if($reservasi->keperluan)
            <div class="col-span-2">
                <p class="text-[11px] font-bold uppercase tracking-wider text-brand-400">Keperluan</p>
                <p class="font-semibold text-brand-800 mt-0.5">{{ $reservasi->keperluan }}</p>
            </div>
            @endif
            @if($reservasi->artefak)
            <div class="col-span-2 border-t border-brand-100 pt-3">
                <p class="text-[11px] font-bold uppercase tracking-wider text-purple-500 mb-2">Artefak Dipinjam</p>
                <p class="font-semibold text-brand-800">{{ $reservasi->artefak->nama_artefak }}</p>
                <p class="text-xs text-brand-400">{{ $reservasi->artefak->kode_registrasi }}</p>
                @if($reservasi->tanggal_kembali)
                <p class="text-xs text-brand-500 mt-1">Kembali: {{ $reservasi->tanggal_kembali->format('d F Y') }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>

    @if($reservasi->status === 'menunggu')
    <form method="POST" action="{{ route('pengunjung.reservasi.cancel', $reservasi->id) }}"
          onsubmit="return confirm('Yakin ingin membatalkan reservasi ini?')">
        @csrf
        <button class="w-full btn-outline text-red-600 border-red-200 hover:bg-red-50 justify-center py-3">
            <i class="fa-solid fa-xmark"></i> Batalkan Reservasi
        </button>
    </form>
    @endif
</div>
@endsection