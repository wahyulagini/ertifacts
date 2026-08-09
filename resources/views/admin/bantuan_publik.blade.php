@extends('layouts.admin')

@section('title', 'Bantuan Publik')
@section('page-title', 'Bantuan Publik')
@section('page-subtitle', 'Kelola pertanyaan dan tiket bantuan dari pengunjung umum')

@section('content')

@if(session('success'))
<div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm mb-5">
    <i class="fa-solid fa-circle-check shrink-0"></i> {{ session('success') }}
</div>
@endif

{{-- Stat Cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    @foreach([
        ['Menunggu Balasan', $stats['menunggu'] ?? 0, 'bg-yellow-50 border-yellow-200 text-yellow-800'],
        ['Sudah Dibalas',    $stats['dibalas']  ?? 0, 'bg-emerald-50 border-emerald-200 text-emerald-800'],
        ['Ditutup',          $stats['ditutup']  ?? 0, 'bg-gray-50 border-gray-200 text-gray-700'],
    ] as [$label, $val, $cls])
    <div class="border rounded-2xl px-5 py-4 {{ $cls }}">
        <p class="text-xs font-bold uppercase tracking-wider">{{ $label }}</p>
        <p class="font-serif text-3xl font-bold mt-0.5">{{ $val }}</p>
    </div>
    @endforeach
</div>

{{-- Tiket List --}}
<div class="space-y-4">
    @forelse($tikets as $tiket)
    <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden hover:shadow-md transition-all">
        <div class="flex items-start gap-4 p-5">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm shrink-0">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="font-bold text-brand-900 text-sm">{{ $tiket->subjek }}</h3>
                        <span class="badge {{ $tiket->status_badge }}">{{ $tiket->status_label }}</span>
                    </div>
                    <span class="text-[10px] text-gray-400 font-mono">{{ $tiket->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>
                
                <p class="text-xs text-brand-500 font-medium mb-3">
                    Dari: <span class="font-bold text-brand-700">{{ $tiket->nama }}</span> 
                    <a href="mailto:{{ $tiket->email }}" class="text-blue-500 hover:underline ml-1">({{ $tiket->email }})</a>
                </p>
                
                <div class="bg-brand-50 rounded-xl px-4 py-3 border border-brand-100">
                    <p class="text-sm text-brand-700 leading-relaxed">{{ $tiket->pesan }}</p>
                </div>

                @if($tiket->balasan_admin)
                <div class="mt-3 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 relative">
                    <div class="absolute -top-2 left-6 w-4 h-4 bg-emerald-50 border-l border-t border-emerald-200 rotate-45"></div>
                    <p class="text-[11px] font-bold text-emerald-700 mb-1 flex items-center gap-1.5 relative z-10">
                        <i class="fa-solid fa-reply"></i> Balasan Admin &mdash; {{ $tiket->dibalas_pada?->translatedFormat('d M Y, H:i') }}
                    </p>
                    <p class="text-sm text-emerald-900 relative z-10">{{ $tiket->balasan_admin }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Action Area --}}
        @if($tiket->status !== 'ditutup')
        <div class="px-5 pb-5 border-t border-brand-50 pt-4 bg-gray-50/50">
            <form method="POST" action="{{ route('admin.bantuan-publik.balas', $tiket->id) }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-brand-600 uppercase tracking-wider mb-1.5 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square"></i> {{ $tiket->balasan_admin ? 'Perbarui Balasan' : 'Tulis Balasan' }}
                    </label>
                    <textarea name="balasan" rows="3" required
                        class="w-full border border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition-colors resize-none bg-white"
                        placeholder="Ketik balasan untuk pengunjung (balasan ini biasanya dikirim via email oleh sistem)...">{{ old('balasan', $tiket->balasan_admin) }}</textarea>
                </div>
                <div class="flex items-center gap-2 justify-end">
                    <form method="POST" action="{{ route('admin.bantuan-publik.tutup', $tiket->id) }}"
                          onsubmit="return confirm('Tutup tiket ini? Pastikan masalah sudah selesai.')" class="inline">
                        @csrf
                        <button type="submit" formAction="{{ route('admin.bantuan-publik.tutup', $tiket->id) }}" class="btn-outline text-xs py-2 px-4 flex items-center gap-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 border-gray-300">
                            <i class="fa-solid fa-lock"></i> Tutup
                        </button>
                    </form>
                    <button type="submit" class="btn-primary text-xs py-2 px-5 flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-paper-plane"></i> {{ $tiket->balasan_admin ? 'Simpan Perubahan' : 'Kirim Balasan' }}
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="px-5 py-3 flex items-center justify-between gap-2 text-xs text-gray-400 border-t border-gray-100 bg-gray-50">
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-lock text-gray-400"></i> Tiket ini sudah ditutup.</span>
            <span class="text-[10px] uppercase font-bold tracking-wider">Closed</span>
        </div>
        @endif
    </div>
    @empty
    <div class="bg-white rounded-3xl border border-dashed border-brand-200 py-24 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center mb-4 text-brand-300">
            <i class="fa-solid fa-inbox text-2xl"></i>
        </div>
        <p class="font-bold text-brand-700 text-lg">Belum ada tiket bantuan masuk</p>
        <p class="text-sm text-brand-400 mt-1 max-w-sm">Tiket dari pengunjung umum akan muncul di sini. Anda bisa membalasnya secara langsung.</p>
    </div>
    @endforelse
</div>

<div class="mt-6">{{ $tikets->links() }}</div>
@endsection
