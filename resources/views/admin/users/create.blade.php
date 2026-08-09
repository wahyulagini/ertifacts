@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')
@section('page-title', 'Tambah Pengguna')
@section('page-subtitle', 'Buat akun pengguna baru (Admin, Tenant, atau Pengunjung)')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-brand-500 hover:text-brand-700 text-sm font-semibold mb-2 inline-block">
        &larr; Kembali ke Data Pengguna
    </a>
    <h1 class="text-2xl font-bold text-brand-900">Tambah Akun</h1>
</div>

<div class="max-w-3xl bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Nomor HP</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-700 mb-1">Peran (Role)</label>
                <select name="role" id="roleSelect" required
                    class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                    <option value="pengunjung" {{ old('role') == 'pengunjung' ? 'selected' : '' }}>Pengunjung</option>
                    <option value="Tenant" {{ old('role') == 'Tenant' ? 'selected' : '' }}>Tenant</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-brand-700 mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            <p class="text-[10px] text-brand-400 mt-1">Minimal 8 karakter.</p>
            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Form Tambahan Jika Memilih Tenant --}}
        <div id="TenantFields" class="{{ old('role') == 'Tenant' ? 'block' : 'hidden' }} space-y-5 p-5 bg-amber-50 rounded-xl border border-amber-200 mt-4">
            <h3 class="text-sm font-bold text-amber-800 border-b border-amber-200 pb-2">Informasi Usaha (Khusus Tenant)</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-amber-900 mb-1">Nama Usaha / Tenant</label>
                    <input type="text" name="nama_Tenant" value="{{ old('nama_Tenant') }}"
                        class="w-full bg-white border border-amber-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('nama_Tenant') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-amber-900 mb-1">Jenis Usaha</label>
                    <input type="text" name="jenis_usaha" value="{{ old('jenis_usaha') }}" placeholder="Contoh: Kuliner, Souvenir"
                        class="w-full bg-white border border-amber-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('jenis_usaha') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-amber-900 mb-1">Tarif Sewa Bulanan (Rp)</label>
                    <input type="number" name="tarif_sewa" value="{{ old('tarif_sewa', 0) }}"
                        class="w-full bg-white border border-amber-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('tarif_sewa') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-amber-900 mb-1">Persentase Pajak (%)</label>
                    <input type="number" name="persentase_pajak" value="{{ old('persentase_pajak', 10) }}" max="100"
                        class="w-full bg-white border border-amber-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @error('persentase_pajak') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-brand-100 flex justify-end">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-save"></i> Simpan Pengguna
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('roleSelect').addEventListener('change', function() {
        const TenantFields = document.getElementById('TenantFields');
        if (this.value === 'Tenant') {
            TenantFields.classList.remove('hidden');
        } else {
            TenantFields.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
