@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Panel')
@section('page-subtitle', 'Kelola seluruh operasional Museum Digital E-RTIFACT')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['fa-users',      'Total Pengguna',      $stats['total_user']         ?? 0,   'bg-blue-50 text-blue-600'],
        ['fa-book-open',  'Kunjungan Hari Ini',  $stats['kunjungan_hari_ini'] ?? 0,   'bg-teal-50 text-teal-600'],
        ['fa-store',      'Tenant Aktif',        $stats['tenant_aktif']       ?? 0,   'bg-amber-50 text-amber-600'],
        ['fa-coins',      'Pendapatan Bulan Ini','Rp ' . number_format($stats['pendapatan_bulan'] ?? 0, 0, ',', '.'), 'bg-emerald-50 text-emerald-600'],
    ] as [$icon, $label, $val, $cls])
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div class="min-w-0 pr-2">
                <p class="text-xs text-brand-400 font-medium mb-1 truncate">{{ $label }}</p>
                <p class="font-serif text-2xl font-bold text-brand-900 leading-tight">{{ $val }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl {{ $cls }} flex items-center justify-center shrink-0">
                <i class="fa-solid {{ $icon }} text-sm"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Alert pending --}}
@if(($stats['menunggu_tenant'] ?? 0) > 0)
<div class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 mb-6">
    <i class="fa-solid fa-handshake text-blue-500 shrink-0"></i>
    <div class="flex-1 min-w-0">
        <p class="text-xs font-bold text-blue-800">{{ $stats['menunggu_tenant'] }} permohonan tenant baru</p>
        <p class="text-[11px] text-blue-600">Tinjau dan setujui.</p>
    </div>
    <a href="{{ route('admin.tenant') }}" class="text-xs font-bold text-blue-700 underline whitespace-nowrap">Lihat →</a>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Buku Tamu Terbaru --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-brand-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-brand-100 flex items-center justify-between">
            <h3 class="font-bold text-brand-800 text-sm">Kunjungan Terbaru (Buku Tamu)</h3>
            <a href="{{ route('admin.buku-tamu.index') }}" class="text-xs text-brand-400 hover:text-brand-600 font-semibold">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr>
                <th class="table-th text-left">Nama</th>
                <th class="table-th text-left">Tgl Kunjungan</th>
                <th class="table-th text-center">Orang</th>
                <th class="table-th text-center">Guide</th>
                <th class="table-th text-center">Bayar</th>
            </tr></thead>
            <tbody>
                @forelse($buku_tamu_terbaru ?? [] as $b)
                <tr class="hover:bg-brand-50 transition-colors">
                    <td class="table-td text-xs font-semibold text-brand-800">{{ $b->nama_pengunjung }}</td>
                    <td class="table-td text-xs text-brand-500">{{ \Carbon\Carbon::parse($b->tanggal_kunjungan)->format('d M Y') }}</td>
                    <td class="table-td text-center text-xs">{{ $b->jumlah_orang }}</td>
                    <td class="table-td text-center">
                        <span class="badge {{ $b->butuh_guide ? 'badge-blue' : 'badge-gray' }} text-[10px]">
                            {{ $b->butuh_guide ? 'Ya' : 'Tidak' }}
                        </span>
                    </td>
                    <td class="table-td text-center">
                        <span class="badge {{ $b->status_bayar === 'lunas' ? 'badge-green' : 'badge-yellow' }} text-[10px]">
                            {{ $b->status_bayar === 'lunas' ? 'Lunas' : 'Belum' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="table-td text-center text-brand-300 py-10">
                    <i class="fa-regular fa-book text-2xl mb-2 block opacity-40"></i>
                    Belum ada data kunjungan
                </td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    {{-- Kanan: keuangan + tenant pending --}}
    <div class="space-y-4">

        {{-- Ringkasan keuangan --}}
        <div class="bg-white rounded-2xl border border-brand-200 p-5 space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-brand-800 text-sm">Keuangan Bulan Ini</h3>
                <span class="text-[10px] text-brand-400 font-semibold">{{ now()->format('M Y') }}</span>
            </div>
            <div class="space-y-2.5">
                @foreach([
                    ['Tiket Masuk',      $stats['tiket_bulan']  ?? 0, 'text-emerald-600'],
                    ['Sewa Tenant',      $stats['sewa_bulan']   ?? 0, 'text-blue-600'],
                    ['Tagihan Sewa Terkumpul', $stats['pajak_bulan']  ?? 0, 'text-purple-600'],
                ] as [$label, $val, $cls])
                <div class="flex items-center justify-between text-xs">
                    <span class="text-brand-500">{{ $label }}</span>
                    <span class="font-bold {{ $cls }}">Rp {{ number_format($val, 0, ',', '.') }}</span>
                </div>
                @endforeach
                <div class="border-t border-brand-100 pt-2 flex items-center justify-between">
                    <span class="font-bold text-brand-700 text-sm">Total</span>
                    <span class="font-serif font-bold text-brand-900">
                        Rp {{ number_format(($stats['tiket_bulan'] ?? 0) + ($stats['sewa_bulan'] ?? 0) + ($stats['pajak_bulan'] ?? 0), 0, ',', '.') }}
                    </span>
                </div>
            </div>
            <a href="{{ route('admin.keuangan') }}" class="btn-outline w-full justify-center text-xs mt-1">
                <i class="fa-solid fa-chart-line"></i> Laporan Lengkap
            </a>
        </div>

        {{-- Permohonan tenant pending --}}
        <div class="bg-white rounded-2xl border border-brand-200 p-5 space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-brand-800 text-sm">Permohonan Tenant</h3>
                <a href="{{ route('admin.tenant') }}" class="text-xs text-brand-400 hover:text-brand-600 font-semibold">Semua →</a>
            </div>
            @forelse($tenant_pending ?? [] as $t)
            <div class="flex items-center gap-3 py-1.5 border-b border-brand-50 last:border-0">
                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-700 text-xs font-bold shrink-0">
                    {{ strtoupper(substr($t->nama_tenant, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-brand-800 truncate">{{ $t->nama_tenant }}</p>
                    <p class="text-[10px] text-brand-400">{{ $t->jenis_usaha }}</p>
                </div>
                <div class="flex gap-1 shrink-0">
                    <a href="{{ route('admin.tenant') }}" class="w-7 h-7 bg-brand-100 text-brand-600 rounded-lg flex items-center justify-center text-xs hover:bg-brand-200 transition-colors" title="Review">
                        <i class="fa-solid fa-eye text-[10px]"></i>
                    </a>
                </div>
            </div>
            @empty
            <p class="text-xs text-brand-300 text-center py-3">Tidak ada permohonan pending</p>
            @endforelse
        </div>
    </div>
</div>
@endsection