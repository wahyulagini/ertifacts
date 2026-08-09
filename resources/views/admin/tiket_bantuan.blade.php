@extends('layouts.admin')

@section('title', 'Tiket Bantuan Tenant')
@section('page-title', 'Tiket Bantuan')
@section('page-subtitle', 'Kelola dan balas pertanyaan yang dikirim oleh tenant')

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
            <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-sm shrink-0">
                {{ strtoupper(substr($tiket->tenant->nama_tenant ?? 'T', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <h3 class="font-bold text-brand-900 text-sm">{{ $tiket->subjek }}</h3>
                    @php
                        $badge = match($tiket->status) {
                            'menunggu' => 'badge-yellow',
                            'dibalas'  => 'badge-green',
                            'ditutup'  => 'badge-gray',
                            default    => 'badge-gray',
                        };
                        $label = match($tiket->status) {
                            'menunggu' => 'Menunggu',
                            'dibalas'  => 'Dibalas',
                            'ditutup'  => 'Ditutup',
                            default    => $tiket->status,
                        };
                    @endphp
                    <span class="badge {{ $badge }}">{{ $label }}</span>
                </div>
                <p class="text-xs text-brand-400 mb-2">
                    <i class="fa-solid fa-store mr-1"></i>{{ $tiket->tenant->nama_tenant ?? '-' }} &nbsp;·&nbsp;
                    <i class="fa-regular fa-clock mr-1"></i>{{ $tiket->created_at->translatedFormat('d M Y, H:i') }}
                </p>
                <p class="text-sm text-brand-600 leading-relaxed bg-brand-50 rounded-xl px-4 py-3">{{ $tiket->pesan }}</p>

                @if($tiket->balasan_admin)
                <div class="mt-3 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">
                    <p class="text-[11px] font-bold text-emerald-600 mb-1">
                        <i class="fa-solid fa-reply mr-1"></i> Balasan Admin — {{ $tiket->dibalas_pada?->translatedFormat('d M Y, H:i') }}
                    </p>
                    <p class="text-sm text-emerald-800">{{ $tiket->balasan_admin }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Action Area --}}
        @if($tiket->status !== 'ditutup')
        <div class="px-5 pb-5 border-t border-brand-50 pt-4 space-y-3">
            <form method="POST" action="{{ route('admin.tiket-bantuan.balas', $tiket->id) }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-brand-700 uppercase tracking-wider mb-1.5">
                        {{ $tiket->balasan_admin ? 'Perbarui Balasan' : 'Tulis Balasan' }}
                    </label>
                    <textarea name="balasan" rows="3"
                        class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none resize-none"
                        placeholder="Ketik balasan untuk tenant...">{{ old('balasan', $tiket->balasan_admin) }}</textarea>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="btn-primary text-xs py-2 px-4">
                        <i class="fa-solid fa-paper-plane"></i> {{ $tiket->balasan_admin ? 'Perbarui Balasan' : 'Kirim Balasan' }}
                    </button>
                    <form method="POST" action="{{ route('admin.tiket-bantuan.tutup', $tiket->id) }}"
                          onsubmit="return confirm('Tutup tiket ini?')">
                        @csrf
                        <button type="submit" class="btn-outline text-xs py-2 px-4">
                            <i class="fa-solid fa-lock"></i> Tutup Tiket
                        </button>
                    </form>
                </div>
            </form>
        </div>
        @else
        <div class="px-5 pb-4 flex items-center gap-2 text-xs text-gray-400 border-t border-brand-50 pt-3">
            <i class="fa-solid fa-lock"></i> Tiket ini sudah ditutup.
        </div>
        @endif
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-brand-200 py-20 flex flex-col items-center text-center">
        <i class="fa-solid fa-headset text-4xl text-brand-200 mb-4"></i>
        <p class="font-bold text-brand-600">Belum ada tiket bantuan masuk</p>
        <p class="text-xs text-brand-400 mt-1">Tiket akan muncul saat tenant mengirim pertanyaan atau keluhan.</p>
    </div>
    @endforelse
</div>

<div class="mt-5">{{ $tikets->links() }}</div>
@endsection
