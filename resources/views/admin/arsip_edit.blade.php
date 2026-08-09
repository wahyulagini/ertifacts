@extends('layouts.admin')
@section('title', 'Edit Arsip Sejarah')
@section('page-title', 'Edit Arsip Sejarah')
@section('page-subtitle', 'Perbarui data arsip museum')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.arsip') }}" class="text-brand-500 hover:text-brand-700 text-sm font-semibold">&larr; Kembali ke Daftar Arsip</a>
</div>
<div class="max-w-3xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-brand-100">
        <h3 class="font-bold text-brand-800">Edit: {{ $item->judul_arsip }}</h3>
    </div>
    <form action="{{ route('admin.arsip.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Judul Arsip *</label>
            <input type="text" name="judul_arsip" value="{{ old('judul_arsip', $item->judul_arsip) }}" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            @error('judul_arsip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Jenis Koleksi *</label>
                <select name="jenis_koleksi" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
                    @foreach(['Naskah Kuno','Foto Bersejarah','Peta Kuno','Surat / Dokumen Resmi','Rekaman Audio','Rekaman Video','Laporan Arkeologi','Lainnya'] as $type)
                    <option value="{{ $type }}" {{ old('jenis_koleksi', $item->jenis_koleksi) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Bahasa</label>
                <input type="text" name="bahasa" value="{{ old('bahasa', $item->bahasa) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Tahun Dokumen</label>
                <input type="text" name="tahun_dokumen" value="{{ old('tahun_dokumen', $item->tahun_dokumen) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Asal Instansi</label>
                <input type="text" name="asal_instansi" value="{{ old('asal_instansi', $item->asal_instansi) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Deskripsi Isi</label>
            <textarea name="deskripsi_isi" rows="3" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">{{ old('deskripsi_isi', $item->deskripsi_isi) }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Kondisi Fisik</label>
                <input type="text" name="kondisi_fisik" value="{{ old('kondisi_fisik', $item->kondisi_fisik) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Lokasi Penyimpanan</label>
                <input type="text" name="lokasi_penyimpanan" value="{{ old('lokasi_penyimpanan', $item->lokasi_penyimpanan) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Gambar Thumbnail</label>
            @if($item->gambar_thumbnail)
                <div class="mb-2"><img src="{{ asset('storage/'.$item->gambar_thumbnail) }}" class="h-24 rounded-xl object-cover border border-brand-100"></div>
            @endif
            <input type="file" name="gambar" accept="image/*" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
        </div>
        <div class="flex items-center mt-4">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="tersedia_publik" value="1" {{ $item->tersedia_publik ? 'checked' : '' }} class="w-4 h-4 rounded border-brand-300 text-brand-600 focus:ring-brand-500">
                <span class="text-sm font-semibold text-brand-700">Tersedia Publik</span>
            </label>
        </div>
        <div class="pt-4 flex justify-end gap-3 border-t border-brand-100">
            <a href="{{ route('admin.arsip') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
