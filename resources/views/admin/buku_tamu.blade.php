@extends('layouts.admin')

@section('title', 'Data Pengunjung')
@section('page-title', 'Data Pengunjung')
@section('page-subtitle', 'Rekapitulasi data kunjungan dan pesan dari pengunjung museum')

@section('content')
<div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="p-5 border-b border-brand-100 flex justify-between items-center bg-brand-50/50">
        <h3 class="font-bold text-brand-800">Daftar Kunjungan Terbaru</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-brand-50 border-b border-brand-100">
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Tanggal</th>
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Nama Pengunjung</th>
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Jml Orang</th>
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Guide</th>
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Bukti Bayar</th>
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase w-1/4">Saran / Komentar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-50">
                @forelse($buku_tamu as $item)
                <tr class="hover:bg-brand-50/50 transition-colors">
                    <td class="py-4 px-5 text-sm text-brand-600 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}
                        <div class="text-[10px] text-brand-400 mt-1">Disubmit: {{ $item->created_at->format('d/m/Y H:i') }}</div>
                    </td>
                    <td class="py-4 px-5 font-bold text-brand-900">{{ $item->nama_pengunjung }}</td>
                    <td class="py-4 px-5 text-sm text-brand-700">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-brand-100 text-brand-800 font-semibold">
                            <i class="fa-solid fa-users text-[10px]"></i> {{ $item->jumlah_orang }}
                        </span>
                    </td>
                    <td class="py-4 px-5">
                        @if($item->butuh_guide)
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-blue-100 text-blue-700">Ya</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-600">Tidak</span>
                        @endif
                    </td>
                    <td class="py-4 px-5">
                        @if($item->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-100 text-brand-700 hover:bg-brand-200 text-xs font-bold transition">
                                <i class="fa-solid fa-image"></i> Lihat Bukti
                            </a>
                        @else
                            <span class="text-xs text-brand-400 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="py-4 px-5 text-sm text-brand-600 italic">
                        @if($item->saran_komentar)
                            "{{ $item->saran_komentar }}"
                        @else
                            <span class="text-brand-300 not-italic">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 px-5 text-center">
                        <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-book-open text-brand-300 text-xl"></i>
                        </div>
                        <p class="text-brand-500 font-medium">Belum ada data di buku tamu.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($buku_tamu->hasPages())
    <div class="p-4 border-t border-brand-100">
        {{ $buku_tamu->links() }}
    </div>
    @endif
</div>
@endsection
