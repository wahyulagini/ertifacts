@extends('layouts.admin')

@section('title', 'Tambah Arsip Sejarah')
@section('page-title', 'Tambah Arsip Sejarah')
@section('page-subtitle', 'Tambahkan data arsip dan dokumen historis baru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.arsip') }}" class="text-brand-500 hover:text-brand-700 text-sm font-semibold inline-block">
        &larr; Kembali ke Daftar Arsip
    </a>
</div>

<div class="max-w-4xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <form action="{{ route('admin.arsip.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf

        <div class="bg-brand-50 border border-brand-200 rounded-xl px-4 py-3 flex items-center gap-3 text-sm text-brand-600">
            <i class="fa-solid fa-tag text-brand-gold"></i>
            <span>Kode Arsip akan dibuat otomatis oleh sistem (contoh: <strong>ARS-202608-001</strong>)</span>
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Judul Arsip *</label>
            <input type="text" name="judul_arsip" value="{{ old('judul_arsip') }}" required
                class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            @error('judul_arsip') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <p class="text-xs text-brand-400 mt-1"><i class="fa-solid fa-circle-info"></i> Judul arsip harus unik dan belum pernah digunakan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Jenis Koleksi *</label>
                <select name="jenis_koleksi" required
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                    @foreach(['Naskah Kuno','Foto Bersejarah','Peta Kuno','Surat / Dokumen Resmi','Rekaman Audio','Rekaman Video','Laporan Arkeologi','Lainnya'] as $jenis)
                        <option value="{{ $jenis }}" {{ old('jenis_koleksi') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Bahasa</label>
                <input type="text" name="bahasa" value="{{ old('bahasa') }}" placeholder="Melayu Kuno, Arab"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Tahun Dokumen</label>
                <input type="text" name="tahun_dokumen" value="{{ old('tahun_dokumen') }}" placeholder="1512"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Asal Instansi</label>
                <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" placeholder="Museum Islam Samudera Pasai"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Kondisi Fisik</label>
                <input type="text" name="kondisi_fisik" value="{{ old('kondisi_fisik') }}" placeholder="Baik, Rapuh, dll"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Deskripsi Isi</label>
            <textarea name="deskripsi_isi" rows="3" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">{{ old('deskripsi_isi') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Lokasi Penyimpanan</label>
                <input type="text" name="lokasi_penyimpanan" value="{{ old('lokasi_penyimpanan') }}"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Thumbnail Arsip</label>
                <input type="file" name="gambar" accept="image/*"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm file:mr-3 file:px-3 file:py-1 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-200 file:text-brand-700">
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="tersedia_publik" value="1" {{ old('tersedia_publik') ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-brand-300 text-brand-600 focus:ring-brand-500">
                <span class="text-sm font-semibold text-brand-700">Tersedia untuk publik</span>
            </label>
        </div>

        <div class="pt-4 border-t border-brand-100 flex justify-end">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-save"></i> Simpan Arsip</button>
        </div>
    </form>
</div>
@endsection
