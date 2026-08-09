@extends('layouts.admin')

@section('title', 'Tambah Tokoh Penting')
@section('page-title', 'Tambah Tokoh Penting')
@section('page-subtitle', 'Tambahkan data tokoh bersejarah ke koleksi museum')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.tokoh') }}" class="text-brand-500 hover:text-brand-700 text-sm font-semibold inline-block">
        &larr; Kembali ke Daftar Tokoh
    </a>
</div>

<div class="max-w-4xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <form action="{{ route('admin.tokoh.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Nama Tokoh *</label>
                <input type="text" name="nama_tokoh" value="{{ old('nama_tokoh') }}" required
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                @error('nama_tokoh') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                <p class="text-xs text-brand-400 mt-1"><i class="fa-solid fa-circle-info"></i> Nama tokoh harus unik dan belum pernah digunakan.</p>
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Nama Julukan</label>
                <input type="text" name="nama_julukan" value="{{ old('nama_julukan') }}"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Gelar</label>
                <input type="text" name="gelar" value="{{ old('gelar') }}" placeholder="Sultan, Pahlawan Nasional, dll"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Peran</label>
                <input type="text" name="peran" value="{{ old('peran') }}" placeholder="Pendiri Kesultanan, Pejuang, dll"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Era Aktif</label>
                <input type="text" name="era_aktif" value="{{ old('era_aktif') }}" placeholder="Abad ke-13"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Tahun Lahir</label>
                <input type="text" name="tahun_lahir" value="{{ old('tahun_lahir') }}" placeholder="1200"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Tahun Wafat</label>
                <input type="text" name="tahun_wafat" value="{{ old('tahun_wafat') }}" placeholder="1297"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Tempat Asal</label>
            <input type="text" name="tempat_asal" value="{{ old('tempat_asal') }}" placeholder="Samudera Pasai / Lhokseumawe"
                class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Biografi</label>
            <textarea name="biografi" rows="4" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">{{ old('biografi') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Kontribusi</label>
            <textarea name="kontribusi" rows="2" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">{{ old('kontribusi') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Foto Tokoh</label>
                <input type="file" name="gambar" accept="image/*"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm file:mr-3 file:px-3 file:py-1 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-200 file:text-brand-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Sumber Referensi</label>
                <input type="text" name="sumber_referensi" value="{{ old('sumber_referensi') }}" placeholder="URL atau nama buku"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div class="pt-4 border-t border-brand-100 flex justify-end">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-save"></i> Simpan Tokoh</button>
        </div>
    </form>
</div>
@endsection
