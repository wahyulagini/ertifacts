@extends('layouts.dashboard')
@section('title', 'Dashboard Tenant')
@section('page-title', 'Dashboard Tenant')
@section('page-subtitle', 'Pantau status usaha dan kelola lapak Anda')

@section('sidebar-nav')
<p class="nav-section">Utama</p>
<a href="{{ route('Tenant.dashboard') }}" class="nav-link active">
    <i class="fa-solid fa-gauge"></i> Beranda
</a>

<p class="nav-section">Keuangan</p>
<a href="{{ route('Tenant.pajak') }}" class="nav-link">
    <i class="fa-solid fa-receipt"></i> Tagihan Sewa
    @if(($stats['pajak_belum_bayar'] ?? 0) > 0)
    <span class="ml-auto bg-brand-rust text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">!</span>
    @endif
</a>

<p class="nav-section">Pusat Bantuan</p>
<a href="{{ route('Tenant.bantuan') }}" class="nav-link">
    <i class="fa-solid fa-headset"></i> Pusat Bantuan
    @if(isset($stats['tiket_menunggu_balasan']) && $stats['tiket_menunggu_balasan'] > 0)
    <span class="ml-auto bg-blue-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">{{ $stats['tiket_menunggu_balasan'] }}</span>
    @endif
</a>

<p class="nav-section">Akun</p>
<a href="{{ route('Tenant.profil') }}" class="nav-link">
    <i class="fa-solid fa-store"></i> Profil Usaha
</a>
@endsection

@section('content')

{{-- ── STATUS BANNER ──────────────────────────────── --}}
@if($Tenant->status === 'menunggu')
<div class="flex items-start gap-3 bg-yellow-50 border border-yellow-300 rounded-2xl px-5 py-4 mb-6">
    <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center shrink-0">
        <i class="fa-solid fa-hourglass-half text-yellow-600"></i>
    </div>
    <div class="flex-1">
        <p class="font-bold text-yellow-800 text-sm">Menunggu Persetujuan Admin</p>
        <p class="text-yellow-700 text-xs mt-0.5 leading-relaxed">
            Permohonan Tenant Anda sedang ditinjau. Proses biasanya selesai dalam 1×24 jam kerja.
            Anda akan dapat menggunakan fitur penuh setelah disetujui.
        </p>
    </div>
    <span class="badge badge-yellow shrink-0">Pending</span>
</div>

@elseif($Tenant->status === 'ditolak')
<div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 mb-6">
    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
        <i class="fa-solid fa-circle-xmark text-red-500"></i>
    </div>
    <div class="flex-1">
        <p class="font-bold text-red-800 text-sm">Permohonan Ditolak</p>
        <p class="text-red-600 text-xs mt-0.5">{{ $Tenant->catatan_admin ?? 'Hubungi admin untuk informasi lebih lanjut.' }}</p>
    </div>
</div>

@elseif($Tenant->status === 'aktif' && ($stats['pajak_belum_bayar'] ?? 0) > 0)
<div class="flex items-center gap-3 bg-orange-50 border border-orange-200 rounded-2xl px-5 py-3 mb-6">
    <i class="fa-solid fa-triangle-exclamation text-orange-500 shrink-0"></i>
    <div class="flex-1">
        <p class="font-bold text-orange-800 text-sm">Ada Tagihan Sewa Belum Dibayar</p>
        <p class="text-orange-600 text-xs">Total: <strong>Rp {{ number_format($stats['pajak_belum_bayar'], 0, ',', '.') }}</strong></p>
    </div>
    <a href="{{ route('Tenant.pajak') }}" class="btn-primary text-xs py-1.5 px-3 shrink-0">
        Bayar Sekarang
    </a>
</div>
@endif

{{-- ── HEADER INFO USAHA ───────────────────────────── --}}
<div class="bg-gradient-to-r from-brand-700 to-brand-800 rounded-2xl p-5 mb-6 flex items-center gap-4">
    <div class="w-14 h-14 rounded-2xl bg-brand-gold/30 flex items-center justify-center text-brand-gold font-serif font-bold text-2xl shrink-0">
        {{ strtoupper(substr($Tenant->nama_Tenant, 0, 1)) }}
    </div>
    <div class="flex-1 min-w-0">
        <h2 class="font-serif text-xl font-bold text-white truncate">{{ $Tenant->nama_Tenant }}</h2>
        <div class="flex items-center gap-3 mt-1 flex-wrap">
            <span class="text-brand-300 text-xs">{{ $Tenant->jenis_usaha }}</span>
            @if($Tenant->lokasi_di_museum)
            <span class="text-brand-300 text-xs">· {{ $Tenant->lokasi_di_museum }}</span>
            @endif
            <span class="badge {{ $Tenant->status === 'aktif' ? 'badge-green' : ($Tenant->status === 'menunggu' ? 'badge-yellow' : 'badge-red') }}">
                {{ ucfirst($Tenant->status) }}
            </span>
        </div>
    </div>
    <div class="hidden sm:block text-right shrink-0">
        <p class="text-brand-300 text-xs">Sewa Booth</p>
        <p class="font-bold text-brand-gold text-lg">{{ $Tenant->tarif_sewa_rp }}</p>
    </div>
</div>

{{-- ── STAT CARDS ──────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-2 gap-4 mb-6">
    @foreach([
        ['fa-receipt',        'Tagihan Sewa Bulan Ini',         'Rp ' . number_format($stats['pajak_bulan'],       0, ',', '.'), 'bg-purple-50 text-purple-600'],
        ['fa-headset',        'Tiket Bantuan',           $stats['total_tiket'] . ' tiket',                               'bg-blue-50 text-blue-600'],
    ] as [$icon, $label, $val, $cls])
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div class="min-w-0 pr-2">
                <p class="text-xs text-brand-400 font-medium mb-1 leading-tight">{{ $label }}</p>
                <p class="font-serif text-lg font-bold text-brand-900 leading-tight">{{ $val }}</p>
            </div>
            <div class="w-9 h-9 rounded-xl {{ $cls }} flex items-center justify-center shrink-0">
                <i class="fa-solid {{ $icon }} text-sm"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── PUSAT BANTUAN ──────────────────────────── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- FAQ --}}
        <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-brand-100 flex items-center gap-2">
                <i class="fa-solid fa-circle-question text-brand-gold"></i>
                <h3 class="font-bold text-brand-800 text-sm">FAQ Tenant — Pertanyaan Umum</h3>
            </div>
            <div class="divide-y divide-brand-50" x-data="{ open: null }">
                @foreach([
                    ['Bagaimana cara mengubah profil usaha saya?',
                     'Masuk ke menu "Profil Usaha" di sidebar kiri. Di sana Anda bisa mengubah nama usaha, jenis usaha, deskripsi, nomor kontak, serta mengunggah logo.'],
                    ['Kapan tagihan sewa saya muncul?',
                     'Tagihan sewa akan di-generate otomatis oleh sistem. Anda akan mendapat notifikasi jika ada tagihan baru.'],
                    ['Bagaimana cara membayar tagihan sewa?',
                     'Pergi ke menu "Tagihan Sewa", pilih tagihan yang belum dibayar, lalu unggah bukti transfer sesuai nomor rekening yang tertera. Admin akan mengkonfirmasi dalam 1×24 jam kerja.'],
                    ['Status Tenant saya masih "Menunggu", apa yang harus dilakukan?',
                     'Tidak perlu khawatir. Tim admin kami akan meninjau permohonan Anda. Proses biasanya selesai dalam 1×24 jam kerja. Jika lebih dari itu, gunakan fitur Tiket Bantuan untuk menghubungi admin.'],
                    ['Bagaimana cara menghubungi admin jika ada masalah?',
                     'Gunakan fitur "Kirim Tiket Bantuan" di bagian bawah halaman ini atau di halaman Pusat Bantuan. Jelaskan masalah Anda secara detail dan admin akan membalas secepatnya.'],
                    ['Apakah saya bisa mendaftar ke lebih dari satu event?',
                     'Ya, Anda bisa mendaftar ke event lain melalui menu "Daftar Event" jika tersedia event baru. Setiap pendaftaran akan melalui proses persetujuan admin terlebih dahulu.'],
                ] as $i => [$q, $a])
                <div class="px-5 py-3" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-left gap-3 group">
                        <span class="text-sm font-semibold text-brand-800 group-hover:text-brand-600 transition-colors">{{ $q }}</span>
                        <i class="fa-solid fa-chevron-down text-brand-300 text-xs transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition class="mt-2 text-xs text-brand-500 leading-relaxed">
                        {{ $a }}
                    </div>
                </div>
                @endforeach
            </div>
            <div class="px-5 py-3 border-t border-brand-100">
                <a href="{{ route('Tenant.bantuan') }}" class="text-xs text-brand-400 hover:text-brand-600 font-semibold">
                    Lihat semua tiket bantuan →
                </a>
            </div>
        </div>

        {{-- Kirim Tiket Bantuan --}}
        <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-brand-100 flex items-center gap-2">
                <i class="fa-solid fa-ticket text-brand-500"></i>
                <h3 class="font-bold text-brand-800 text-sm">Kirim Tiket Bantuan</h3>
            </div>
            <div class="p-5">
                @if(session('success'))
                <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm mb-4">
                    <i class="fa-solid fa-circle-check shrink-0"></i>
                    {{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-4">
                    @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
                </div>
                @endif
                <form method="POST" action="{{ route('Tenant.bantuan.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-brand-700 uppercase tracking-wider mb-1.5">Subjek</label>
                        <input type="text" name="subjek" value="{{ old('subjek') }}"
                            class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none"
                            placeholder="Contoh: Pertanyaan tentang tagihan sewa..." required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-brand-700 uppercase tracking-wider mb-1.5">Pesan</label>
                        <textarea name="pesan" rows="4"
                            class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none resize-none"
                            placeholder="Jelaskan pertanyaan atau masalah Anda secara detail..." required>{{ old('pesan') }}</textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center py-2.5">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Tiket Bantuan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── PANEL KANAN ─────────────────────────────── --}}
    <div class="space-y-4">

        {{-- Info Event --}}
        @if($Tenant->event)
        <div class="bg-gradient-to-br from-brand-gold to-yellow-600 rounded-2xl p-5 text-white space-y-3 relative overflow-hidden shadow-lg shadow-brand-gold/20">
            <div class="absolute -right-4 -top-4 opacity-20 text-6xl">
                <i class="fa-solid fa-calendar-star"></i>
            </div>
            <div class="relative z-10">
                <p class="text-yellow-100 text-[10px] font-bold uppercase tracking-wider mb-1">Event Saat Ini</p>
                <h3 class="font-serif text-lg font-bold leading-tight">{{ $Tenant->event->judul_event }}</h3>
                <div class="space-y-1.5 mt-3 text-xs text-yellow-50">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-calendar-day w-4 text-center"></i>
                        <span>Mulai: {{ \Carbon\Carbon::parse($Tenant->event->tanggal_mulai)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 font-bold text-white">
                        <i class="fa-solid fa-calendar-check w-4 text-center"></i>
                        <span>Berakhir: {{ \Carbon\Carbon::parse($Tenant->event->tanggal_selesai)->translatedFormat('d F Y') }}</span>
                    </div>
                    @if($Tenant->event->lokasi_area)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot w-4 text-center"></i>
                        <span>Area: {{ $Tenant->event->lokasi_area }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Ringkasan pajak --}}
        <div class="bg-white rounded-2xl border border-brand-200 p-5 space-y-3">
            <h3 class="font-bold text-brand-800 text-sm">Perhitungan Tagihan Sewa</h3>
            <div class="bg-brand-50 rounded-xl p-4 space-y-2.5">
                @foreach([
                    ['Sewa tempat/bulan', 'Rp ' . number_format($Tenant->tarif_sewa ?? 0, 0, ',', '.'), 'font-bold text-brand-800'],
                    ['Tagihan bulan ini', 'Rp ' . number_format($stats['pajak_bulan'], 0, ',', '.'), 'font-bold text-purple-600'],
                ] as [$label, $val, $cls])
                <div class="flex items-center justify-between text-xs">
                    <span class="text-brand-500">{{ $label }}</span>
                    <span class="{{ $cls }}">{{ $val }}</span>
                </div>
                @endforeach
                <div class="border-t border-brand-200 pt-2 flex items-center justify-between">
                    <span class="text-xs font-bold text-brand-700">Tagihan belum bayar</span>
                    <span class="font-bold {{ ($stats['pajak_belum_bayar'] ?? 0) > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        Rp {{ number_format($stats['pajak_belum_bayar'] ?? 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            @if(($stats['pajak_belum_bayar'] ?? 0) > 0)
            <a href="{{ route('Tenant.pajak') }}" class="btn-primary w-full justify-center text-xs">
                <i class="fa-solid fa-money-bill-wave"></i> Bayar Tagihan
            </a>
            @else
            <div class="flex items-center gap-2 justify-center text-xs text-emerald-600 font-semibold py-1">
                <i class="fa-solid fa-circle-check"></i> Semua tagihan lunas
            </div>
            @endif
        </div>

        {{-- Tiket Terakhir --}}
        <div class="bg-white rounded-2xl border border-brand-200 p-5 space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-brand-800 text-sm">Tiket Bantuan</h3>
                <a href="{{ route('Tenant.bantuan') }}" class="text-xs text-brand-400 hover:text-brand-600 font-semibold">Semua →</a>
            </div>
            @forelse($tikets->take(4) as $t)
            <div class="flex items-start gap-3 py-1.5 border-b border-brand-50 last:border-0">
                <div class="w-2 h-2 rounded-full mt-1.5 shrink-0 {{ $t->status === 'menunggu' ? 'bg-yellow-400' : ($t->status === 'dibalas' ? 'bg-emerald-400' : 'bg-gray-300') }}"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-brand-800 truncate">{{ $t->subjek }}</p>
                    <p class="text-[10px] text-brand-400">{{ $t->created_at->diffForHumans() }}</p>
                </div>
                <span class="badge {{ $t->status_badge }} text-[10px] shrink-0">{{ $t->status_label }}</span>
            </div>
            @empty
            <p class="text-xs text-brand-400 text-center py-3">Belum ada tiket bantuan</p>
            @endforelse
        </div>

        {{-- Info operasional --}}
        <div class="bg-gradient-to-br from-brand-700 to-brand-900 rounded-2xl p-5 text-white space-y-3">
            <p class="text-brand-gold text-[10px] font-bold uppercase tracking-wider">Info Operasional Museum</p>
            <div class="space-y-2 text-xs text-brand-300">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-clock text-brand-gold w-4"></i>
                    <span>Buka: 08.00 – 16.00 WIB</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-map-pin text-brand-gold w-4"></i>
                    <span>{{ $Tenant->lokasi_di_museum ?? 'Lokasi belum ditetapkan' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>Biaya sewa: {{ $Tenant->tarif_sewa_rp }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Simple accordion without Alpine
document.querySelectorAll('[\\@click]') && document.querySelectorAll('.faq-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const ans = btn.nextElementSibling;
        ans.classList.toggle('hidden');
        btn.querySelector('i').classList.toggle('rotate-180');
    });
});
</script>
@endpush
@endsection
