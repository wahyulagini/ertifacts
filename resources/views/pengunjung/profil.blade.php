@extends('layouts.dashboard')
@section('title','Edit Profil')
@section('page-title','Edit Profil')
@section('page-subtitle','Kelola informasi akun Anda')

@section('sidebar-nav')
<p class="nav-section">Menu Utama</p>
<a href="{{ route('pengunjung.dashboard') }}" class="nav-link"><i class="fa-solid fa-house"></i> Beranda</a>
<a href="{{ route('pengunjung.reservasi.index') }}" class="nav-link"><i class="fa-solid fa-calendar-check"></i> Reservasi Saya</a>
<a href="{{ route('pengunjung.transaksi.index') }}" class="nav-link"><i class="fa-solid fa-receipt"></i> Riwayat Transaksi</a>
<p class="nav-section">Akun</p>
<a href="{{ route('pengunjung.profil') }}" class="nav-link active"><i class="fa-solid fa-user-pen"></i> Edit Profil</a>
@endsection

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-brand-700 to-brand-800 px-6 py-5 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-brand-gold/30 flex items-center justify-center text-brand-gold font-serif font-bold text-2xl">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="font-serif text-lg font-bold text-white">{{ $user->name }}</h2>
                <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded bg-brand-gold/20 text-brand-gold">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('pengunjung.profil.update') }}" class="p-6 space-y-4">
            @csrf

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-700">
                @foreach($errors->all() as $e) <p>{{ $e }}</p> @endforeach
            </div>
            @endif

            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20" required>
            </div>

            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Email</label>
                <input type="email" value="{{ $user->email }}" disabled
                    class="w-full border-2 border-brand-100 rounded-xl px-4 py-2.5 text-sm bg-brand-50 text-brand-400 cursor-not-allowed">
                <p class="text-[11px] text-brand-400 mt-1">Email tidak dapat diubah.</p>
            </div>

            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">No. WhatsApp</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20"
                    placeholder="08xxxxxxxxxx">
            </div>

            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}"
                    class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20"
                    placeholder="Alamat lengkap">
            </div>

            <div class="border-t border-brand-100 pt-4 space-y-3">
                <p class="text-xs font-bold text-brand-500 uppercase tracking-wider">Ganti Password <span class="font-normal normal-case">(kosongkan jika tidak ingin mengubah)</span></p>
                <div>
                    <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Password Baru</label>
                    <input type="password" name="password"
                        class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20"
                        placeholder="Min. 8 karakter">
                </div>
                <div>
                    <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20"
                        placeholder="Ulangi password baru">
                </div>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection