@extends('layouts.dashboard')
@section('title', 'Daftarkan Usaha Anda')
@section('page-title', 'Daftarkan Usaha Anda')
@section('page-subtitle', 'Lengkapi data usaha untuk mengajukan permohonan Tenant museum')

@section('sidebar-nav')
<p class="nav-section">Akun Tenant</p>
<a href="{{ route('Tenant.daftar') }}" class="nav-link active">
    <i class="fa-solid fa-store"></i> Daftar Tenant
</a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Info --}}
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6 flex gap-3">
        <i class="fa-solid fa-circle-info text-amber-500 shrink-0 mt-0.5"></i>
        <div class="text-xs text-amber-800 space-y-1">
            <p class="font-bold">Cara Menjadi Tenant Museum E-RTIFACT:</p>
            <ol class="list-decimal list-inside space-y-0.5 text-amber-700">
                <li>Isi formulir data usaha di bawah ini</li>
                <li>Admin akan meninjau permohonan dalam 1×24 jam kerja</li>
                <li>Jika disetujui, Anda dapat langsung mencatat penjualan dan memantau laporan</li>
                <li>Tarif sewa dan persentase pajak akan ditetapkan admin saat persetujuan</li>
            </ol>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-brand-700 to-brand-800 px-6 py-5">
            <h2 class="font-serif text-lg font-bold text-white">Formulir Pendaftaran Tenant</h2>
            <p class="text-brand-300 text-xs mt-0.5">Semua data dapat diubah setelah permohonan disetujui</p>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border-b border-red-200 px-6 py-4 flex items-start gap-3">
            <i class="fa-solid fa-circle-xmark text-red-500 shrink-0 mt-0.5"></i>
            <ul class="text-xs text-red-700 space-y-0.5">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('Tenant.daftar.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- Nama Usaha --}}
            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">
                    Nama Usaha / Lapak <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <i class="fa-solid fa-store absolute left-3.5 top-1/2 -translate-y-1/2 text-brand-300 text-sm pointer-events-none"></i>
                    <input type="text" name="nama_Tenant" value="{{ old('nama_Tenant') }}"
                        class="w-full border-2 border-brand-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20"
                        placeholder="Nama toko / kafe / stand Anda" required>
                </div>
            </div>

            {{-- Jenis Usaha --}}
            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">
                    Jenis Usaha <span class="text-red-400">*</span>
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach(['Kafe / Restoran','Toko Souvenir','Toko Buku','Pameran Tamu','Jasa Edukasi','Lainnya'] as $j)
                    <label class="flex items-center gap-2 border-2 rounded-xl px-3 py-2.5 cursor-pointer transition-all
                        {{ old('jenis_usaha') === $j ? 'border-brand-gold bg-brand-50' : 'border-brand-200 hover:border-brand-300' }}">
                        <input type="radio" name="jenis_usaha" value="{{ $j }}" class="accent-brand-gold"
                               {{ old('jenis_usaha') === $j ? 'checked' : '' }} required>
                        <span class="text-xs font-medium text-brand-700">{{ $j }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">
                    Deskripsi Usaha
                </label>
                <textarea name="deskripsi" rows="3"
                    class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20 resize-none"
                    placeholder="Ceritakan singkat tentang usaha Anda, produk yang dijual, dll...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Preferensi lokasi --}}
                <div>
                    <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">
                        Preferensi Lokasi di Museum
                    </label>
                    <select name="lokasi_di_museum"
                        class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20 appearance-none">
                        <option value="">— Pilih lokasi —</option>
                        @foreach(['Lantai 1 - Sayap Barat','Lantai 1 - Sayap Timur','Lantai 1 - Tengah (Hall Utama)','Lantai 2 - Sayap Barat','Lantai 2 - Sayap Timur','Area Luar / Taman Museum'] as $lok)
                        <option value="{{ $lok }}" {{ old('lokasi_di_museum') === $lok ? 'selected' : '' }}>{{ $lok }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- No kontak --}}
                <div>
                    <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">
                        No. Kontak Usaha
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-brand-300 text-sm pointer-events-none"></i>
                        <input type="tel" name="no_kontak" value="{{ old('no_kontak') }}"
                            class="w-full border-2 border-brand-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20"
                            placeholder="08xxxxxxxxxx">
                    </div>
                </div>
            </div>

            <div class="bg-brand-50 border border-brand-200 rounded-xl p-4 flex gap-3">
                <i class="fa-solid fa-circle-info text-brand-gold shrink-0 mt-0.5"></i>
                <p class="text-xs text-brand-600">
                    <strong>Tarif sewa bulanan</strong> dan <strong>persentase pajak</strong> akan ditetapkan oleh admin museum
                    setelah permohonan diverifikasi dan disetujui.
                </p>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('Tenant.dashboard') }}" class="btn-outline flex-1 justify-center py-3">
                    Nanti Saja
                </a>
                <button type="submit" class="btn-primary flex-1 justify-center py-3">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Permohonan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection