@extends('layouts.admin')
@section('title', 'Edit Tokoh Penting')
@section('page-title', 'Edit Tokoh Penting')
@section('page-subtitle', 'Perbarui data tokoh penting museum')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.tokoh') }}" class="text-brand-500 hover:text-brand-700 text-sm font-semibold">&larr; Kembali ke Daftar Tokoh</a>
</div>

<div class="max-w-3xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-brand-100">
        <h3 class="font-bold text-brand-800">Edit: {{ $item->nama_tokoh }}</h3>
    </div>
    <form action="{{ route('admin.tokoh.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Nama Tokoh *</label>
            <input type="text" name="nama_tokoh" value="{{ old('nama_tokoh', $item->nama_tokoh) }}" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            @error('nama_tokoh') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Nama Julukan</label>
            <input type="text" name="nama_julukan" value="{{ old('nama_julukan', $item->nama_julukan) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Gelar</label>
                <input type="text" name="gelar" value="{{ old('gelar', $item->gelar) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Peran</label>
                <input type="text" name="peran" value="{{ old('peran', $item->peran) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Era Aktif</label>
                <input type="text" name="era_aktif" value="{{ old('era_aktif', $item->era_aktif) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Tahun Lahir</label>
                <input type="text" name="tahun_lahir" value="{{ old('tahun_lahir', $item->tahun_lahir) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Tahun Wafat</label>
                <input type="text" name="tahun_wafat" value="{{ old('tahun_wafat', $item->tahun_wafat) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Tempat Asal</label>
                <input type="text" name="tempat_asal" value="{{ old('tempat_asal', $item->tempat_asal) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Biografi</label>
            <textarea name="biografi" rows="3" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">{{ old('biografi', $item->biografi) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Kontribusi</label>
            <textarea name="kontribusi" rows="2" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">{{ old('kontribusi', $item->kontribusi) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Gambar Tokoh</label>
            @if($item->gambar_path)
            <div class="mb-2"><img src="{{ asset('storage/'.$item->gambar_path) }}" class="h-24 rounded-xl object-cover border border-brand-100"></div>
            @endif
            <input type="file" name="gambar" accept="image/*" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
        </div>
        <div class="pt-4 flex justify-end gap-3 border-t border-brand-100">
            <a href="{{ route('admin.tokoh') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
