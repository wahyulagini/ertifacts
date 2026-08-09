@extends('layouts.dashboard')

@section('title', 'Buat Reservasi')
@section('page-title', 'Buat Reservasi Baru')
@section('page-subtitle', 'Silakan isi form di bawah ini dengan lengkap')

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
<div class="max-w-2xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-brand-100">
        <h3 class="font-bold text-brand-800 text-sm">Form Reservasi</h3>
    </div>
    <form action="{{ route('pengunjung.reservasi.store') }}" method="POST" class="p-5 space-y-4">
        @csrf
        
        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Jenis Kunjungan</label>
            <select name="jenis" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                <option value="">Pilih Jenis Kunjungan...</option>
                <option value="Kunjungan Umum">Kunjungan Umum</option>
                <option value="Kunjungan Rombongan">Kunjungan Rombongan</option>
                <option value="Kunjungan Riset">Kunjungan Riset</option>
                <option value="Peminjaman Artefak">Peminjaman Artefak</option>
            </select>
            @error('jenis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Tanggal Kunjungan</label>
                <input type="date" name="tanggal_kunjungan" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                @error('tanggal_kunjungan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Sesi</label>
                <select name="sesi" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                    <option value="">Pilih Sesi...</option>
                    <option value="Pagi (08.00-12.00)">Pagi (08.00-12.00)</option>
                    <option value="Siang (12.00-16.00)">Siang (12.00-16.00)</option>
                    <option value="Penuh (08.00-16.00)">Penuh (08.00-16.00)</option>
                </select>
                @error('sesi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Jumlah Orang</label>
                <input type="number" name="jumlah_orang" min="1" max="100" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                @error('jumlah_orang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center mt-6">
                <input type="checkbox" name="opsi_guide" id="opsi_guide" value="1" class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded">
                <label for="opsi_guide" class="ml-2 block text-sm text-gray-900">
                    Gunakan Jasa Guide Tour (+Rp 50.000)
                </label>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Keperluan / Keterangan</label>
            <textarea name="keperluan" rows="3" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400"></textarea>
            @error('keperluan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('pengunjung.reservasi.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Kirim Reservasi</button>
        </div>
    </form>
</div>
@endsection
