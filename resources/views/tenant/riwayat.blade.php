@extends('layouts.dashboard')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-brand-900">Riwayat Transaksi</h1>
    <p class="text-brand-500 text-sm">Seluruh riwayat penjualan usaha Anda</p>
</div>

<div class="bg-white rounded-2xl border border-brand-200 p-5 mb-5">
    <form action="{{ route('Tenant.riwayat') }}" method="GET" class="flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-xs font-semibold text-brand-600 mb-1">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ request('dari') }}"
                class="rounded-lg border border-brand-200 px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-brand-600 mb-1">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}"
                class="rounded-lg border border-brand-200 px-3 py-2 text-sm">
        </div>
        <button type="submit" class="bg-brand-800 hover:bg-brand-900 text-white text-sm font-semibold rounded-lg px-4 py-2">
            Filter
        </button>
        @if(request('dari') || request('sampai'))
            <a href="{{ route('Tenant.riwayat') }}" class="text-xs text-brand-400 hover:text-brand-600 underline">Reset filter</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-brand-50 text-brand-600 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Tanggal</th>
                <th class="text-left px-5 py-3">Keterangan</th>
                <th class="text-left px-5 py-3">Metode</th>
                <th class="text-right px-5 py-3">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $t)
                <tr class="border-t border-brand-50">
                    <td class="px-5 py-3 text-brand-500">{{ $t->created_at->translatedFormat('d M Y') }}</td>
                    <td class="px-5 py-3 text-brand-800 font-medium">{{ $t->keterangan }}</td>
                    <td class="px-5 py-3 text-brand-500">{{ $t->metode_bayar }}</td>
                    <td class="px-5 py-3 text-right font-bold text-emerald-600">{{ $t->jumlah_rp }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-10 text-brand-400">Tidak ada transaksi ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $transaksi->links() }}
    </div>
</div>
@endsection