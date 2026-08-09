@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-brand-900">Laporan Keuangan</h1>
    <p class="text-brand-500 text-sm">Ringkasan pendapatan operasional Museum Digital E-RTIFACT</p>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-brand-200 rounded-2xl p-4">
        <p class="text-brand-500 text-sm">Tiket Masuk</p>
        <p class="text-xl font-bold text-emerald-600">Rp {{ number_format($stats['tiket_bulan'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-white border border-brand-200 rounded-2xl p-4">
        <p class="text-brand-500 text-sm">Sewa Tenant</p>
        <p class="text-xl font-bold text-blue-600">Rp {{ number_format($stats['sewa_bulan'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-white border border-brand-200 rounded-2xl p-4">
        <p class="text-brand-500 text-sm">Pajak Terkumpul</p>
        <p class="text-xl font-bold text-purple-600">Rp {{ number_format($stats['pajak_bulan'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-brand-900 rounded-2xl p-4">
        <p class="text-brand-300 text-sm">Total Bulan Ini</p>
        <p class="text-xl font-bold text-white">Rp {{ number_format($stats['total_bulan'], 0, ',', '.') }}</p>
    </div>
</div>

{{-- INFO PENDAPATAN TENANT (bukan bagian pendapatan museum) --}}
<div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-6 text-sm text-amber-700">
    <i class="fa-solid fa-circle-info mr-1"></i>
    Total penjualan kotor seluruh tenant bulan ini: <strong>Rp {{ number_format($stats['pendapatan_tenant_kotor'], 0, ',', '.') }}</strong>
    — ini milik tenant, bukan pendapatan museum. Museum hanya menerima potongan pajak dari nilai ini.
</div>

{{-- GRAFIK TREN 6 BULAN --}}
<div class="bg-white rounded-2xl border border-brand-200 p-5 mb-6">
    <h3 class="font-bold text-brand-800 mb-4">Tren Pendapatan 6 Bulan Terakhir</h3>
    @php $max = max(1, $tren->max('total')); @endphp
    <div class="flex items-end justify-between gap-3 h-40">
        @foreach($tren as $t)
            <div class="flex-1 flex flex-col items-center justify-end h-full">
                <p class="text-xs text-brand-500 mb-1">
                    {{ $t['total'] > 0 ? number_format($t['total']/1000, 0) . 'K' : '0' }}
                </p>
                <div class="w-full bg-brand-800 rounded-t-lg transition-all"
                    style="height: {{ $t['total'] > 0 ? max(6, ($t['total'] / $max) * 100) : 4 }}%"></div>
                <p class="text-xs text-brand-400 mt-2">{{ $t['label'] }}</p>
            </div>
        @endforeach
    </div>
</div>

{{-- FILTER --}}
<div class="bg-white rounded-2xl border border-brand-200 p-5 mb-5">
    <form action="{{ route('admin.keuangan') }}" method="GET" class="flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-xs font-semibold text-brand-600 mb-1">Jenis Transaksi</label>
            <select name="jenis" class="rounded-lg border border-brand-200 px-3 py-2 text-sm">
                <option value="">Semua</option>
                @foreach(['Tiket Pengunjung','Sewa Tempat tenant','Pendapatan tenant','Biaya Peminjaman Artefak','Lainnya'] as $j)
                    <option value="{{ $j }}" {{ request('jenis') === $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-brand-600 mb-1">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-lg border border-brand-200 px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-brand-600 mb-1">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-lg border border-brand-200 px-3 py-2 text-sm">
        </div>
        <button type="submit" class="bg-brand-800 hover:bg-brand-900 text-white text-sm font-semibold rounded-lg px-4 py-2">
            Filter
        </button>
        @if(request()->anyFilled(['jenis','dari','sampai']))
            <a href="{{ route('admin.keuangan') }}" class="text-xs text-brand-400 hover:text-brand-600 underline">Reset</a>
        @endif
    </form>
</div>

{{-- TABLE TRANSAKSI --}}
<div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-brand-50 text-brand-600 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Kode</th>
                <th class="text-left px-5 py-3">Jenis</th>
                <th class="text-left px-5 py-3">Sumber</th>
                <th class="text-left px-5 py-3">Tanggal</th>
                <th class="text-center px-5 py-3">Status</th>
                <th class="text-right px-5 py-3">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $t)
                <tr class="border-t border-brand-50">
                    <td class="px-5 py-3 font-mono text-xs text-brand-700">{{ $t->kode_transaksi }}</td>
                    <td class="px-5 py-3 text-brand-600">{{ $t->jenis_transaksi }}</td>
                    <td class="px-5 py-3 text-brand-600">{{ $t->sumber }}</td>
                    <td class="px-5 py-3 text-brand-500">{{ $t->created_at ? \Carbon\Carbon::parse($t->created_at)->translatedFormat('d M Y') : '-' }}</td>
                    <td class="px-5 py-3 text-center">
                        @php
                            $badge = [
                                'lunas'        => 'bg-emerald-50 text-emerald-700',
                                'menunggu'     => 'bg-amber-50 text-amber-700',
                                'belum_bayar'  => 'bg-red-50 text-red-700',
                                'gagal'        => 'bg-red-50 text-red-700',
                                'dikembalikan' => 'bg-gray-100 text-gray-600',
                            ][$t->status_bayar] ?? 'bg-gray-100 text-gray-600';
                            $label = [
                                'lunas'        => 'Lunas',
                                'menunggu'     => 'Menunggu',
                                'belum_bayar'  => 'Belum Bayar',
                                'gagal'        => 'Gagal',
                                'dikembalikan' => 'Dikembalikan',
                            ][$t->status_bayar] ?? ucfirst($t->status_bayar);
                        @endphp
                        <span class="{{ $badge }} text-xs font-semibold px-2.5 py-1 rounded-full">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right font-bold text-brand-800">{{ $t->jumlah_rp }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-16 text-brand-400">Belum ada transaksi tercatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $transaksi->links() }}
    </div>
</div>
@endsection