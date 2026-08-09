@extends('layouts.dashboard')

@section('title', 'Input Penjualan')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-brand-900">Input Penjualan</h1>
        <p class="text-brand-500 text-sm">Catat transaksi penjualan usaha Anda</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
        {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- FORM INPUT --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-brand-200 p-5">
            <h3 class="font-bold text-brand-800 mb-4">Transaksi Baru</h3>
            <form action="{{ route('Tenant.penjualan.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-brand-600 mb-1">Nominal Penjualan (Rp)</label>
                    <input type="number" name="jumlah" min="1000" step="1000" value="{{ old('jumlah') }}"
                        class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400"
                        placeholder="Contoh: 150000" required>
                    @error('jumlah') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-600 mb-1">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                        class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-600 mb-1">Metode Pembayaran</label>
                    <select name="metode_bayar" class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400" required>
                        <option value="">Pilih metode</option>
                        <option value="Tunai">Tunai</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Kartu Debit/Kredit">Kartu Debit/Kredit</option>
                    </select>
                    @error('metode_bayar') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-brand-600 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                        class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400"
                        placeholder="Contoh: Penjualan kopi & snack">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                @if($Tenant)
                <div class="rounded-lg bg-brand-50 border border-brand-100 px-3 py-2 text-xs text-brand-600">
                    Pajak otomatis <strong>{{ $Tenant->persentase_pajak }}%</strong> akan dihitung dari nominal ini.
                </div>
                @endif

                <button type="submit"
                    class="w-full bg-brand-800 hover:bg-brand-900 text-white font-semibold rounded-lg py-2.5 text-sm transition">
                    Simpan Transaksi
                </button>
            </form>
        </div>
    </div>

    {{-- LIST TRANSAKSI --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-brand-200 p-5">
            <h3 class="font-bold text-brand-800 mb-4">Daftar Transaksi</h3>

            @forelse($transaksi as $t)
                <div class="flex items-center justify-between py-3 border-b border-brand-50 last:border-0">
                    <div>
                        <p class="text-sm font-semibold text-brand-800">{{ $t->keterangan }}</p>
                        <p class="text-xs text-brand-400">{{ $t->created_at->translatedFormat('d M Y, H:i') }} &middot; {{ $t->metode_bayar }}</p>
                    </div>
                    <p class="text-sm font-bold text-emerald-600">{{ $t->jumlah_rp }}</p>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-brand-400 text-sm">Belum ada transaksi.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $transaksi->links() }}
            </div>
        </div>
    </div>
</div>
@endsection