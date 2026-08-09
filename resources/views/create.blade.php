@extends('layouts.dashboard')
@section('title','Buat Reservasi')
@section('page-title','Buat Reservasi Baru')
@section('page-subtitle','Isi formulir untuk membuat reservasi kunjungan atau peminjaman artefak')

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
<div class="max-w-2xl mx-auto">
    <a href="{{ route('pengunjung.reservasi.index') }}" class="inline-flex items-center gap-2 text-sm text-brand-400 hover:text-brand-600 mb-6">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden shadow-sm">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-brand-700 to-brand-800 px-6 py-5">
            <h2 class="font-serif text-lg font-bold text-white">Formulir Reservasi</h2>
            <p class="text-brand-300 text-xs mt-0.5">Reservasi akan diproses admin dalam 1×24 jam kerja</p>
        </div>

        <form method="POST" action="{{ route('pengunjung.reservasi.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- Jenis Kunjungan --}}
            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-2">Jenis Kunjungan <span class="text-red-400">*</span></label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(['Kunjungan Umum','Kunjungan Rombongan','Kunjungan Riset','Peminjaman Artefak'] as $j)
                    <label class="flex items-center gap-3 border-2 rounded-xl p-3 cursor-pointer transition-all
                        {{ old('jenis') === $j ? 'border-brand-gold bg-brand-50' : 'border-brand-200 hover:border-brand-300' }}">
                        <input type="radio" name="jenis" value="{{ $j }}" class="accent-brand-gold"
                               {{ old('jenis') === $j ? 'checked' : '' }}
                               onchange="togglePeminjaman(this)">
                        <span class="text-xs font-semibold text-brand-700">{{ $j }}</span>
                    </label>
                    @endforeach
                </div>
                @error('jenis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal & Sesi --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Tanggal Kunjungan <span class="text-red-400">*</span></label>
                    <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20">
                    @error('tanggal_kunjungan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Sesi <span class="text-red-400">*</span></label>
                    <select name="sesi" class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20 appearance-none">
                        @foreach(['Pagi (08.00-12.00)','Siang (12.00-16.00)','Penuh (08.00-16.00)'] as $s)
                            <option value="{{ $s }}" {{ old('sesi') === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    @error('sesi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Jumlah orang --}}
            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Jumlah Orang <span class="text-red-400">*</span></label>
                <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', 1) }}" min="1" max="100"
                       class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20">
                @error('jumlah_orang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Keperluan --}}
            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Keperluan / Tujuan</label>
                <textarea name="keperluan" rows="3"
                          class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold/20 resize-none"
                          placeholder="Ceritakan tujuan kunjungan Anda...">{{ old('keperluan') }}</textarea>
            </div>

            {{-- Field khusus peminjaman artefak --}}
            <div id="peminjaman-fields" class="{{ old('jenis') === 'Peminjaman Artefak' ? '' : 'hidden' }} space-y-4 border-t-2 border-dashed border-brand-200 pt-4">
                <p class="text-xs font-bold text-purple-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-box-archive"></i> Data Peminjaman Artefak
                </p>

                <div>
                    <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Pilih Artefak</label>
                    <select name="artefak_id" class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none appearance-none">
                        <option value="">— Pilih artefak —</option>
                        @foreach($artefak_dipinjam as $a)
                        <option value="{{ $a->id }}" {{ old('artefak_id') == $a->id ? 'selected' : '' }}>
                            {{ $a->nama_artefak }} ({{ $a->kode_registrasi }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}"
                               class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Institusi Peminjam</label>
                        <input type="text" name="institusi_peminjam" value="{{ old('institusi_peminjam') }}"
                               class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none"
                               placeholder="Nama universitas / lembaga">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">Tujuan Peminjaman</label>
                    <textarea name="tujuan_peminjaman" rows="2"
                              class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none resize-none"
                              placeholder="Jelaskan tujuan peminjaman artefak...">{{ old('tujuan_peminjaman') }}</textarea>
                </div>
            </div>

            {{-- Info tarif --}}
            <div class="bg-brand-50 border border-brand-200 rounded-xl p-4 flex gap-3">
                <i class="fa-solid fa-circle-info text-brand-gold shrink-0 mt-0.5"></i>
                <div class="text-xs text-brand-600 space-y-0.5">
                    <p><strong>Tiket Umum:</strong> Rp 15.000/orang &nbsp;|&nbsp; <strong>Rombongan:</strong> Rp 10.000/orang</p>
                    <p>Pembayaran dilakukan setelah reservasi disetujui admin.</p>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('pengunjung.reservasi.index') }}" class="btn-outline flex-1 justify-center">Batal</a>
                <button type="submit" class="btn-primary flex-1 justify-center">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Reservasi
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function togglePeminjaman(radio) {
    const fields = document.getElementById('peminjaman-fields');
    fields.classList.toggle('hidden', radio.value !== 'Peminjaman Artefak');
}
// Init
document.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('input[name="jenis"]:checked');
    if (checked) togglePeminjaman(checked);
});
</script>
@endpush
@endsection