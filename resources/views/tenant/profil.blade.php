@extends('layouts.dashboard')

@section('title', 'Profil Usaha')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-brand-900">Profil Usaha</h1>
    <p class="text-brand-500 text-sm">Kelola informasi usaha Anda</p>
</div>

@if(session('success'))
    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-2xl border border-brand-200 p-6 max-w-2xl">
    <form action="{{ route('Tenant.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div class="flex items-center gap-4">
            <img src="{{ $Tenant->logo_url }}" class="w-16 h-16 rounded-full object-cover border border-brand-200">
            <div>
                <label class="block text-xs font-semibold text-brand-600 mb-1">Logo Usaha</label>
                <input type="file" name="logo" accept=".jpg,.jpeg,.png" class="text-sm">
                @error('logo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-brand-600 mb-1">Nama Usaha</label>
            <input type="text" name="nama_Tenant" value="{{ old('nama_Tenant', $Tenant->nama_Tenant) }}"
                class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm" required>
            @error('nama_Tenant') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-brand-600 mb-1">Jenis Usaha</label>
            <input type="text" name="jenis_usaha" value="{{ old('jenis_usaha', $Tenant->jenis_usaha) }}"
                class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm" required>
            @error('jenis_usaha') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-brand-600 mb-1">Lokasi / Lapak di Museum</label>
            <input type="text" name="lokasi_di_museum" value="{{ old('lokasi_di_museum', $Tenant->lokasi_di_museum) }}"
                class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm" placeholder="Contoh: Lantai 1 - Sayap Barat">
        </div>

        <div>
            <label class="block text-xs font-semibold text-brand-600 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm">{{ old('deskripsi', $Tenant->deskripsi) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-brand-600 mb-1">No. Kontak</label>
                <input type="text" name="no_kontak" value="{{ old('no_kontak', $Tenant->no_kontak) }}"
                    class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-brand-600 mb-1">Website (opsional)</label>
                <input type="url" name="website" value="{{ old('website', $Tenant->website) }}"
                    class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm" placeholder="https://...">
                @error('website') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <button type="submit"
            class="bg-brand-800 hover:bg-brand-900 text-white font-semibold rounded-lg px-6 py-2.5 text-sm">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection