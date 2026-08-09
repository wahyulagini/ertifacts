@extends('layouts.admin')

@section('title', 'Tambah Lokasi')
@section('page-title', 'Tambah Lokasi')
@section('page-subtitle', 'Tambahkan data situs bersejarah baru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.lokasi') }}" class="text-brand-500 hover:text-brand-700 text-sm font-semibold inline-block">
        &larr; Kembali ke Daftar Lokasi
    </a>
</div>

<div class="max-w-4xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <form action="{{ route('admin.lokasi.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Nama Lokasi *</label>
                <input type="text" name="nama_lokasi" value="{{ old('nama_lokasi') }}" required
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                @error('nama_lokasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                <p class="text-xs text-brand-400 mt-1"><i class="fa-solid fa-circle-info"></i> Nama lokasi harus unik dan belum pernah digunakan.</p>
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Jenis Lokasi *</label>
                <select name="jenis_lokasi" required
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                    @foreach(['Situs Arkeologi','Museum','Cagar Budaya','Makam Bersejarah','Masjid Bersejarah','Benteng','Istana / Keraton','Lainnya'] as $jenis)
                        <option value="{{ $jenis }}" {{ old('jenis_lokasi') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan') }}"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Kabupaten / Kota</label>
                <input type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota', 'Lhokseumawe') }}"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi', 'Aceh') }}"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Latitude</label>
                <input type="text" name="latitude" value="{{ old('latitude') }}" placeholder="5.1472"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Longitude</label>
                <input type="text" name="longitude" value="{{ old('longitude') }}" placeholder="97.1423"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Status Kelola *</label>
                <select name="status_kelola" required
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                    @foreach(['Aktif Dijaga','Terbengkalai','Renovasi','Tertutup'] as $status)
                        <option value="{{ $status }}" {{ old('status_kelola') == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Pengelola</label>
                <input type="text" name="pengelola" value="{{ old('pengelola') }}" placeholder="Pemerintah Daerah"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Jam Operasional</label>
                <input type="text" name="jam_operasional" value="{{ old('jam_operasional') }}" placeholder="08:00 - 17:00"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Gambar Lokasi</label>
            <input type="file" name="gambar" accept="image/*"
                class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm file:mr-3 file:px-3 file:py-1 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-200 file:text-brand-700">
        </div>

        <div class="pt-4 border-t border-brand-100 flex justify-end">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-save"></i> Simpan Lokasi</button>
        </div>
    </form>
</div>
@endsection
