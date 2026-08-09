@extends('layouts.admin')
@section('title', 'Edit Lokasi Geografis')
@section('page-title', 'Edit Lokasi')
@section('page-subtitle', 'Perbarui data lokasi museum')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.lokasi') }}" class="text-brand-500 hover:text-brand-700 text-sm font-semibold">&larr; Kembali ke Daftar Lokasi</a>
</div>
<div class="max-w-3xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-brand-100">
        <h3 class="font-bold text-brand-800">Edit: {{ $item->nama_lokasi }}</h3>
    </div>
    <form action="{{ route('admin.lokasi.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Nama Lokasi *</label>
                <input type="text" name="nama_lokasi" value="{{ old('nama_lokasi', $item->nama_lokasi) }}" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Jenis Lokasi *</label>
                <select name="jenis_lokasi" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
                    @foreach(['Situs Arkeologi','Museum','Cagar Budaya','Makam Bersejarah','Masjid Bersejarah','Benteng','Istana / Keraton','Lainnya'] as $type)
                    <option value="{{ $type }}" {{ old('jenis_lokasi', $item->jenis_lokasi) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-4">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan', $item->kecamatan) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Kabupaten/Kota</label>
                <input type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota', $item->kabupaten_kota) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi', $item->provinsi) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-5 mt-4">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Latitude</label>
                <input type="text" name="latitude" value="{{ old('latitude', $item->latitude) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Longitude</label>
                <input type="text" name="longitude" value="{{ old('longitude', $item->longitude) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-bold text-brand-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">{{ old('deskripsi', $item->deskripsi) }}</textarea>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-bold text-brand-700 mb-1">Gambar Lokasi</label>
            @if($item->gambar_path)
                <div class="mb-2"><img src="{{ asset('storage/'.$item->gambar_path) }}" class="h-24 rounded-xl object-cover border border-brand-100"></div>
            @endif
            <input type="file" name="gambar" accept="image/*" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm">
        </div>
        <div class="mt-4">
            <label class="block text-sm font-bold text-brand-700 mb-1">Status Kelola *</label>
            <select name="status_kelola" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
                @foreach(['Aktif Dijaga','Terbengkalai','Renovasi','Tertutup'] as $status)
                <option value="{{ $status }}" {{ old('status_kelola', $item->status_kelola) == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center mt-4">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="jam_operasional" value="1" {{ $item->jam_operasional ? 'checked' : '' }} class="w-4 h-4 rounded border-brand-300 text-brand-600 focus:ring-brand-500">
                <span class="text-sm font-semibold text-brand-700">Jam Operasional Aktif</span>
            </label>
        </div>
        <div class="pt-4 flex justify-end gap-3 border-t border-brand-100 mt-4">
            <a href="{{ route('admin.lokasi') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
