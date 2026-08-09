@extends('layouts.dashboard')

@section('title', 'Edit Event')
@section('page-title', 'Edit Event')
@section('page-subtitle', 'Perbarui informasi event museum')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-brand-100 flex items-center justify-between">
        <h3 class="font-bold text-brand-800">Form Edit Event</h3>
        <a href="{{ route('admin.events.index') }}" class="text-sm text-brand-500 hover:text-brand-700">← Kembali</a>
    </div>

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf
        @method('PUT')

        @if(session('success'))
        <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">{{ session('success') }}</div>
        @endif

        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Judul Event</label>
            <input type="text" name="judul_event" value="{{ old('judul_event', $event->judul_event) }}" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            @error('judul_event') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">{{ old('deskripsi', $event->deskripsi) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $event->tanggal_mulai) }}" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $event->tanggal_selesai) }}" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Lokasi Area</label>
                <input type="text" name="lokasi_area" value="{{ old('lokasi_area', $event->lokasi_area) }}" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400" placeholder="Misal: Taman Museum Aceh">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Status</label>
                <select name="status" required class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
                    @foreach(['mendatang'=>'Mendatang','berjalan'=>'Berjalan','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $val => $label)
                    <option value="{{ $val }}" {{ old('status', $event->status) == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Kuota Tenant</label>
                <input type="number" name="kuota_tenant" value="{{ old('kuota_tenant', $event->kuota_tenant) }}" required min="1" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label class="block text-sm font-bold text-brand-700 mb-1">Harga Sewa Booth</label>
                <input type="number" name="harga_sewa_booth" value="{{ old('harga_sewa_booth', $event->harga_sewa_booth) }}" required min="0" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-700 mb-1">Gambar/Flyer Event</label>
            @if($event->gambar_path)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$event->gambar_path) }}" class="h-28 rounded-xl object-cover border border-brand-200">
                <p class="text-xs text-brand-400 mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
            </div>
            @endif
            <input type="file" name="gambar" accept="image/*" class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-400">
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-brand-100">
            <a href="{{ route('admin.events.index') }}" class="btn-outline px-5 py-2">Batal</a>
            <button type="submit" class="btn-primary px-5 py-2">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
