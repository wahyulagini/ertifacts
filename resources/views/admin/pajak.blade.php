@extends('layouts.admin')

@section('title', 'Pajak Tenant')
@section('page-title', 'Pajak Tenant')
@section('page-subtitle', 'Kelola dan konfirmasi pembayaran pajak operasional tenant')

 

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-brand-900">Pajak Tenant</h1>
    <p class="text-brand-500 text-sm">Kelola dan konfirmasi pembayaran pajak operasional tenant</p>
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

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
        <p class="text-red-700 text-sm font-semibold">Belum Bayar</p>
        <p class="text-2xl font-bold text-red-800">{{ $stats['belum_bayar'] }}</p>
    </div>
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
        <p class="text-amber-700 text-sm font-semibold">Menunggu Konfirmasi</p>
        <p class="text-2xl font-bold text-amber-800">{{ $stats['menunggu_konfirmasi'] }}</p>
    </div>
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4">
        <p class="text-emerald-700 text-sm font-semibold">Sudah Lunas</p>
        <p class="text-2xl font-bold text-emerald-800">{{ $stats['sudah_bayar'] }}</p>
    </div>
    <div class="bg-brand-900 rounded-2xl p-4">
        <p class="text-brand-300 text-sm font-semibold">Terkumpul Bulan Ini</p>
        <p class="text-2xl font-bold text-white">Rp {{ number_format($stats['total_terkumpul'], 0, ',', '.') }}</p>
    </div>
</div>

{{-- TAB FILTER --}}
<div class="flex flex-wrap gap-2 mb-5">
    @php
        $tabs = [
            ''                     => 'Semua',
            'belum_bayar'          => 'Belum Bayar',
            'menunggu_konfirmasi'  => 'Menunggu Konfirmasi',
            'sudah_bayar'          => 'Lunas',
        ];
    @endphp
    @foreach($tabs as $value => $label)
        <a href="{{ route('admin.pajak', $value ? ['status' => $value] : []) }}"
            class="px-4 py-2 rounded-full text-sm font-semibold transition
                {{ request('status', '') === $value
                    ? 'bg-brand-900 text-white'
                    : 'bg-white border border-brand-200 text-brand-600 hover:bg-brand-50' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- TABLE --}}
<div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-brand-50 text-brand-600 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Tenant</th>
                <th class="text-left px-5 py-3">Periode</th>
                <th class="text-right px-5 py-3">Pendapatan Kotor</th>
                <th class="text-right px-5 py-3">Nominal Pajak</th>
                <th class="text-center px-5 py-3">Bukti Bayar</th>
                <th class="text-center px-5 py-3">Status</th>
                <th class="text-center px-5 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pajak as $p)
                <tr class="border-t border-brand-50">
                    <td class="px-5 py-3">
                        <p class="font-semibold text-brand-800">{{ $p->tenant->nama_tenant ?? '-' }}</p>
                        <p class="text-xs text-brand-400">{{ $p->tenant->user->name ?? '-' }}</p>
                    </td>
                    <td class="px-5 py-3 text-brand-600">{{ $p->periode }}</td>
                    <td class="px-5 py-3 text-right text-brand-500">Rp {{ number_format($p->pendapatan_kotor, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-right font-bold text-purple-600">{{ $p->nominal_pajak_rp }}</td>
                    <td class="px-5 py-3 text-center">
                        @if($p->bukti_bayar_path)
                            <a href="{{ asset('storage/' . $p->bukti_bayar_path) }}" target="_blank"
                                class="text-brand-600 hover:text-brand-800 underline text-xs">Lihat Bukti</a>
                        @else
                            <span class="text-xs text-brand-300">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-center">
                        @php
                            $badge = [
                                'belum_bayar'         => 'bg-red-50 text-red-700',
                                'menunggu_konfirmasi' => 'bg-amber-50 text-amber-700',
                                'sudah_bayar'         => 'bg-emerald-50 text-emerald-700',
                            ][$p->status_bayar] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="{{ $badge }} text-xs font-semibold px-2.5 py-1 rounded-full">
                            {{ $p->status_label }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        @if($p->status_bayar === 'menunggu_konfirmasi')
                            <div class="flex items-center justify-center gap-2 text-xs">
                                <form action="{{ route('admin.pajak.konfirmasi', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Konfirmasi pembayaran ini sebagai LUNAS?')">
                                    @csrf
                                    <button class="text-emerald-600 hover:text-emerald-800 font-semibold underline">Konfirmasi</button>
                                </form>
                                <form action="{{ route('admin.pajak.tolak', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Tolak bukti pembayaran ini?')">
                                    @csrf
                                    <button class="text-red-500 hover:text-red-700 font-semibold underline">Tolak</button>
                                </form>
                            </div>
                        @elseif($p->status_bayar === 'sudah_bayar')
                            <span class="text-xs text-emerald-500">✓ {{ $p->dibayar_pada?->translatedFormat('d M Y') }}</span>
                        @else
                            <span class="text-xs text-brand-300">Menunggu tenant bayar</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-16">
                        <i class="fa-solid fa-file-invoice-dollar text-3xl text-brand-200 mb-2 block"></i>
                        <p class="text-brand-400">Belum ada data pajak tenant</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $pajak->links() }}
    </div>
</div>
@endsection