@extends('layouts.dashboard')

@section('title', 'Tagihan Sewa')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-brand-900">Tagihan Sewa Booth</h1>
    <p class="text-brand-500 text-sm">Kelola kewajiban biaya sewa booth Anda ke museum</p>
</div>

@if(session('success'))
    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="bg-brand-900 rounded-2xl p-5 mb-6 flex items-center justify-between text-white">
    <div>
        <p class="text-brand-300 text-xs">Total Tagihan Belum Lunas</p>
        <p class="text-2xl font-bold">Rp {{ number_format($total_belum, 0, ',', '.') }}</p>
    </div>
    @if($total_belum > 0)
        <span class="bg-red-500/20 text-red-200 text-xs font-semibold px-3 py-1.5 rounded-full">Perlu Dibayar</span>
    @else
        <span class="bg-emerald-500/20 text-emerald-200 text-xs font-semibold px-3 py-1.5 rounded-full">Semua Lunas</span>
    @endif
</div>

<div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-brand-50 text-brand-600 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Periode</th>
                <th class="text-right px-5 py-3">Nominal Tagihan</th>
                <th class="text-center px-5 py-3">Status</th>
                <th class="text-center px-5 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pajak as $p)
                <tr class="border-t border-brand-50">
                    <td class="px-5 py-3 text-brand-800 font-medium">{{ $p->periode }}</td>
                    <td class="px-5 py-3 text-right font-bold text-purple-600">{{ $p->nominal_pajak_rp }}</td>
                    <td class="px-5 py-3 text-center">
                        @if($p->status_bayar === 'sudah_bayar')
                            <span class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-2.5 py-1 rounded-full">Lunas</span>
                        @elseif($p->status_bayar === 'menunggu_konfirmasi')
                            <span class="bg-amber-50 text-amber-600 text-xs font-semibold px-2.5 py-1 rounded-full">Menunggu Konfirmasi</span>
                        @else
                            <span class="bg-red-50 text-red-600 text-xs font-semibold px-2.5 py-1 rounded-full">Belum Bayar</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-center">
                        @if($p->status_bayar === 'belum_bayar')
                            <button onclick="document.getElementById('modal-bayar-{{ $p->id }}').classList.remove('hidden')"
                                class="text-xs font-semibold text-brand-600 hover:text-brand-800 underline">
                                Upload Bukti
                            </button>

                            {{-- Modal upload --}}
                            <div id="modal-bayar-{{ $p->id }}" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
                                <div class="bg-white rounded-2xl p-6 max-w-sm w-full">
                                    <h4 class="font-bold text-brand-800 mb-3">Upload Bukti Bayar - {{ $p->periode }}</h4>
                                    <form action="{{ route('tenant.pajak.bayar', $p->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="bukti_bayar" accept=".jpg,.jpeg,.png,.pdf"
                                            class="w-full text-sm border border-brand-200 rounded-lg px-3 py-2 mb-3" required>
                                        <div class="flex gap-2">
                                            <button type="button"
                                                onclick="document.getElementById('modal-bayar-{{ $p->id }}').classList.add('hidden')"
                                                class="flex-1 border border-brand-200 text-brand-600 rounded-lg py-2 text-sm font-semibold">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="flex-1 bg-brand-800 text-white rounded-lg py-2 text-sm font-semibold">
                                                Kirim
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @elseif($p->status_bayar === 'menunggu_konfirmasi')
                            <span class="text-xs text-brand-400">Menunggu admin</span>
                        @else
                            <span class="text-xs text-emerald-500">✓ Lunas</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-10 text-brand-400">Belum ada tagihan sewa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $pajak->links() }}
    </div>
</div>
@endsection