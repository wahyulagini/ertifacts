@extends('layouts.dashboard ')

@section('title', 'Kelola Reservasi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-brand-900">Kelola Reservasi</h1>
    <p class="text-brand-500 text-sm">Approve atau tolak permintaan reservasi & peminjaman artefak</p>
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
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
        <p class="text-amber-700 text-sm font-semibold">Menunggu</p>
        <p class="text-2xl font-bold text-amber-800">{{ $stats['menunggu'] }}</p>
    </div>
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4">
        <p class="text-emerald-700 text-sm font-semibold">Disetujui</p>
        <p class="text-2xl font-bold text-emerald-800">{{ $stats['disetujui'] }}</p>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
        <p class="text-red-700 text-sm font-semibold">Ditolak</p>
        <p class="text-2xl font-bold text-red-800">{{ $stats['ditolak'] }}</p>
    </div>
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
        <p class="text-blue-700 text-sm font-semibold">Selesai</p>
        <p class="text-2xl font-bold text-blue-800">{{ $stats['selesai'] }}</p>
    </div>
</div>

{{-- TAB FILTER --}}
<div class="flex flex-wrap gap-2 mb-5">
    @php
        $tabs = [
            ''          => 'Semua',
            'menunggu'  => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
            'selesai'   => 'Selesai',
        ];
    @endphp
    @foreach($tabs as $value => $label)
        <a href="{{ route('admin.reservasi', $value ? ['status' => $value] : []) }}"
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
                <th class="text-left px-5 py-3">Kode Booking</th>
                <th class="text-left px-5 py-3">Pengunjung</th>
                <th class="text-left px-5 py-3">Jenis</th>
                <th class="text-left px-5 py-3">Tanggal</th>
                <th class="text-left px-5 py-3">Sesi</th>
                <th class="text-center px-5 py-3">Jml</th>
                <th class="text-center px-5 py-3">Status</th>
                <th class="text-center px-5 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasi as $r)
                <tr class="border-t border-brand-50">
                    <td class="px-5 py-3 font-mono text-xs text-brand-700">{{ $r->kode_booking }}</td>
                    <td class="px-5 py-3">
                        <p class="font-semibold text-brand-800">{{ $r->user->name ?? '-' }}</p>
                        <p class="text-xs text-brand-400">{{ $r->user->email ?? '-' }}</p>
                    </td>
                    <td class="px-5 py-3 text-brand-600">{{ $r->jenis }}</td>
                    <td class="px-5 py-3 text-brand-600">{{ $r->tanggal_kunjungan->translatedFormat('d M Y') }}</td>
                    <td class="px-5 py-3 text-brand-600 text-xs">{{ $r->sesi }}</td>
                    <td class="px-5 py-3 text-center text-brand-600">{{ $r->jumlah_orang }}</td>
                    <td class="px-5 py-3 text-center">
                        @php
                            $badge = [
                                'menunggu'   => 'bg-amber-50 text-amber-700',
                                'disetujui'  => 'bg-emerald-50 text-emerald-700',
                                'ditolak'    => 'bg-red-50 text-red-700',
                                'selesai'    => 'bg-blue-50 text-blue-700',
                                'dibatalkan' => 'bg-gray-100 text-gray-600',
                            ][$r->status] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="{{ $badge }} text-xs font-semibold px-2.5 py-1 rounded-full">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-center gap-2 text-xs">
                            <button onclick="document.getElementById('modal-detail-{{ $r->id }}').classList.remove('hidden')"
                                class="text-brand-500 hover:text-brand-800 underline">Detail</button>

                            @if($r->status === 'menunggu')
                                <form action="{{ route('admin.reservasi.setuju', $r->id) }}" method="POST" onsubmit="return confirm('Setujui reservasi ini?')">
                                    @csrf
                                    <button class="text-emerald-600 hover:text-emerald-800 font-semibold underline">Setujui</button>
                                </form>
                                <button onclick="document.getElementById('modal-tolak-{{ $r->id }}').classList.remove('hidden')"
                                    class="text-red-500 hover:text-red-700 font-semibold underline">Tolak</button>
                            @elseif($r->status === 'disetujui')
                                <form action="{{ route('admin.reservasi.selesai', $r->id) }}" method="POST" onsubmit="return confirm('Tandai reservasi ini selesai?')">
                                    @csrf
                                    <button class="text-blue-600 hover:text-blue-800 font-semibold underline">Tandai Selesai</button>
                                </form>
                            @endif
                        </div>

                        {{-- MODAL DETAIL --}}
                        <div id="modal-detail-{{ $r->id }}" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
                            <div class="bg-white rounded-2xl p-6 max-w-md w-full">
                                <h4 class="font-bold text-brand-800 mb-3">Detail Reservasi</h4>
                                <div class="space-y-2 text-sm text-brand-600">
                                    <p><span class="font-semibold text-brand-800">Kode:</span> {{ $r->kode_booking }}</p>
                                    <p><span class="font-semibold text-brand-800">Pengunjung:</span> {{ $r->user->name ?? '-' }} ({{ $r->user->email ?? '-' }})</p>
                                    <p><span class="font-semibold text-brand-800">Jenis:</span> {{ $r->jenis }}</p>
                                    <p><span class="font-semibold text-brand-800">Tanggal:</span> {{ $r->tanggal_kunjungan->translatedFormat('d M Y') }}</p>
                                    <p><span class="font-semibold text-brand-800">Sesi:</span> {{ $r->sesi }}</p>
                                    <p><span class="font-semibold text-brand-800">Jumlah Orang:</span> {{ $r->jumlah_orang }}</p>
                                    @if($r->keperluan)
                                        <p><span class="font-semibold text-brand-800">Keperluan:</span> {{ $r->keperluan }}</p>
                                    @endif
                                    @if($r->jenis === 'Peminjaman Artefak')
                                        <p><span class="font-semibold text-brand-800">Artefak:</span> {{ $r->artefak->nama ?? '-' }}</p>
                                        <p><span class="font-semibold text-brand-800">Tujuan Peminjaman:</span> {{ $r->tujuan_peminjaman ?? '-' }}</p>
                                        <p><span class="font-semibold text-brand-800">Institusi:</span> {{ $r->institusi_peminjam ?? '-' }}</p>
                                        <p><span class="font-semibold text-brand-800">Tanggal Kembali:</span> {{ $r->tanggal_kembali?->translatedFormat('d M Y') ?? '-' }}</p>
                                    @endif
                                    @if($r->catatan_admin)
                                        <p><span class="font-semibold text-brand-800">Catatan Admin:</span> {{ $r->catatan_admin }}</p>
                                    @endif
                                </div>
                                <button onclick="document.getElementById('modal-detail-{{ $r->id }}').classList.add('hidden')"
                                    class="mt-4 w-full border border-brand-200 text-brand-600 rounded-lg py-2 text-sm font-semibold">
                                    Tutup
                                </button>
                            </div>
                        </div>

                        {{-- MODAL TOLAK --}}
                        @if($r->status === 'menunggu')
                        <div id="modal-tolak-{{ $r->id }}" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full">
                                <h4 class="font-bold text-brand-800 mb-3">Tolak Reservasi {{ $r->kode_booking }}</h4>
                                <form action="{{ route('admin.reservasi.tolak', $r->id) }}" method="POST">
                                    @csrf
                                    <label class="block text-xs font-semibold text-brand-600 mb-1">Alasan Penolakan</label>
                                    <textarea name="catatan" rows="3" required
                                        class="w-full rounded-lg border border-brand-200 px-3 py-2 text-sm mb-3"
                                        placeholder="Contoh: Sesi sudah penuh"></textarea>
                                    <div class="flex gap-2">
                                        <button type="button"
                                            onclick="document.getElementById('modal-tolak-{{ $r->id }}').classList.add('hidden')"
                                            class="flex-1 border border-brand-200 text-brand-600 rounded-lg py-2 text-sm font-semibold">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="flex-1 bg-red-600 hover:bg-red-700 text-white rounded-lg py-2 text-sm font-semibold">
                                            Tolak
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-16">
                        <i class="fa-regular fa-calendar text-3xl text-brand-200 mb-2 block"></i>
                        <p class="text-brand-400">Tidak ada reservasi</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $reservasi->links() }}
    </div>
</div>
@endsection