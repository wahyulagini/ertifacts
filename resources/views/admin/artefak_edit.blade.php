@extends('layouts.admin')
@section('title', 'Edit Artefak')
@section('page-title', 'Edit Artefak')
@section('page-subtitle', 'Perbarui data artefak koleksi museum')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.artefak') }}" class="text-brand-500 hover:text-brand-700 text-sm font-semibold inline-block">&larr; Kembali ke Daftar Artefak</a>
</div>

<div class="max-w-4xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-brand-100">
        <p class="text-xs font-mono text-brand-400">{{ $item->kode_registrasi }}</p>
        <h3 class="font-bold text-brand-800">Edit: {{ $item->nama_artefak }}</h3>
    </div>
    <form action="{{ route('admin.artefak.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Nama Artefak *</label>
            <input type="text" name="nama_artefak" value="{{ old('nama_artefak', $item->nama_artefak) }}" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            @error('nama_artefak') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Nama Lokal</label>
                <input type="text" name="nama_lokal" value="{{ old('nama_lokal', $item->nama_lokal) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $item->kategori) }}" placeholder="Numismatika, Keramik, Tekstil" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Era / Periodisasi</label>
                <input type="text" name="era_periodisasi" value="{{ old('era_periodisasi', $item->era_periodisasi) }}" placeholder="Kesultanan Aceh Darussalam" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Periode / Abad</label>
                <input type="text" name="periode_abad" value="{{ old('periode_abad', $item->periode_abad) }}" placeholder="Abad ke-16 M" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Asal Daerah</label>
                <input type="text" name="asal_daerah" value="{{ old('asal_daerah', $item->asal_daerah) }}" placeholder="Lhokseumawe, Aceh" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Bahan Utama</label>
                <input type="text" name="bahan_utama" value="{{ old('bahan_utama', $item->bahan_utama) }}" placeholder="Emas, Perak, Batu Andesit" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Keutuhan (%)</label>
                <input type="number" name="persentase_keutuhan" value="{{ old('persentase_keutuhan', $item->persentase_keutuhan ?? 100) }}" min="0" max="100" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">{{ old('deskripsi', $item->deskripsi) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Gambar Artefak</label>
                @if($item->gambar_path)
                <div class="mb-2"><img src="{{ asset('storage/'.$item->gambar_path) }}" class="h-24 rounded-xl object-cover border border-brand-100"></div>
                @endif
                <input type="file" name="gambar" accept="image/*" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm file:mr-3 file:px-3 file:py-1 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-200 file:text-brand-700">
            </div>
            <div class="flex items-end">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="bisa_dipinjam" value="1" {{ $item->bisa_dipinjam ? 'checked' : '' }} class="w-4 h-4 rounded border-brand-300 text-brand-600 focus:ring-brand-500">
                    <span class="text-sm font-semibold text-brand-700">Bisa dipinjamkan</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-brand-100 flex justify-end gap-3">
            <a href="{{ route('admin.artefak') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary"><i class="fa-solid fa-save"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
