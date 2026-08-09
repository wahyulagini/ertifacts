@extends('layouts.dashboard')
@section('title','Reservasi Saya')
@section('page-title','Reservasi Saya')
@section('page-subtitle','Daftar semua reservasi dan peminjaman artefak')

@section('sidebar-nav')
<p class="nav-section">Menu Utama</p>
<a href="{{ route('pengunjung.dashboard') }}" class="nav-link"><i class="fa-solid fa-house"></i> Beranda</a>
<a href="{{ route('pengunjung.reservasi.index') }}" class="nav-link active"><i class="fa-solid fa-calendar-check"></i> Reservasi Saya</a>
<a href="{{ route('pengunjung.transaksi.index') }}" class="nav-link"><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</a>
<p class="nav-section">Koleksi</p>
<a href="#" class="nav-link"><i class="fa-solid fa-cube"></i> Artefak & 3D</a>
<a href="#" class="nav-link"><i class="fa-solid fa-person-chalkboard"></i> Tokoh Penting</a>
<a href="#" class="nav-link"><i class="fa-solid fa-scroll"></i> Arsip Sejarah</a>
<a href="#" class="nav-link"><i class="fa-solid fa-map-location-dot"></i> Peta Lokasi</a>
<p class="nav-section">Akun</p>
<a href="{{ route('pengunjung.profil') }}" class="nav-link"><i class="fa-solid fa-user-pen"></i> Edit Profil</a>
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-serif text-xl font-bold text-brand-900">Daftar Reservasi</h2>
        <p class="text-brand-400 text-xs mt-0.5">Total {{ $reservasi->total() }} reservasi</p>
    </div>
    <a href="{{ route('pengunjung.reservasi.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Buat Reservasi
    </a>
</div>

@if($reservasi->count())
<div class="space-y-3">
    @foreach($reservasi as $r)
    <div class="bg-white rounded-2xl border border-brand-200 p-5 flex flex-col sm:flex-row sm:items-center gap-4 hover:shadow-md transition-all">
        <div class="flex items-center gap-4 flex-1 min-w-0">
            {{-- Icon jenis --}}
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0
                {{ $r->jenis === 'Peminjaman Artefak' ? 'bg-purple-100 text-purple-600' : 'bg-teal-100 text-teal-600' }}">
                <i class="fa-solid {{ $r->jenis === 'Peminjaman Artefak' ? 'fa-box-archive' : 'fa-ticket' }} text-lg"></i>
            </div>
            <div class="min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-bold text-brand-900 text-sm">{{ $r->jenis }}</span>
                    <span class="badge {{ $r->status_badge_color }}">{{ ucfirst($r->status) }}</span>
                </div>
                <p class="text-xs text-brand-400 mt-0.5">
                    <i class="fa-regular fa-calendar mr-1"></i>
                    {{ $r->tanggal_kunjungan->format('d M Y') }} · {{ $r->sesi }}
                </p>
                <p class="text-xs text-brand-500 font-mono mt-0.5">{{ $r->kode_booking }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <span class="text-xs text-brand-400">{{ $r->jumlah_orang }} orang</span>
            <a href="{{ route('pengunjung.reservasi.show', $r->id) }}" class="btn-outline text-xs py-1.5 px-3">
                <i class="fa-solid fa-eye"></i> Detail
            </a>
            @if($r->status === 'menunggu')
            <form method="POST" action="{{ route('pengunjung.reservasi.cancel', $r->id) }}"
                  onsubmit="return confirm('Batalkan reservasi ini?')">
                @csrf
                <button class="btn-outline text-xs py-1.5 px-3 text-red-600 border-red-200 hover:bg-red-50">
                    <i class="fa-solid fa-xmark"></i> Batal
                </button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4">{{ $reservasi->links() }}</div>

@else
<div class="bg-white rounded-2xl border border-brand-200 py-20 flex flex-col items-center text-center">
    <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mb-4">
        <i class="fa-regular fa-calendar text-brand-300 text-2xl"></i>
    </div>
    <p class="font-bold text-brand-700 mb-1">Belum ada reservasi</p>
    <p class="text-brand-400 text-sm mb-5">Buat reservasi kunjungan atau peminjaman artefak museum.</p>
    <a href="{{ route('pengunjung.reservasi.create') }}" class="btn-primary">
        <i class="fa-solid fa-calendar-plus"></i> Buat Reservasi Pertama
    </a>
</div>
@endif
@endsection