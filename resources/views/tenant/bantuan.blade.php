@extends('layouts.dashboard')
@section('title', 'Pusat Bantuan')
@section('page-title', 'Pusat Bantuan')
@section('page-subtitle', 'FAQ dan tiket bantuan untuk Tenant E-RTIFACT')

@section('sidebar-nav')
<p class="nav-section">Utama</p>
<a href="{{ route('Tenant.dashboard') }}" class="nav-link">
    <i class="fa-solid fa-gauge"></i> Beranda
</a>

<p class="nav-section">Keuangan</p>
<a href="{{ route('Tenant.pajak') }}" class="nav-link">
    <i class="fa-solid fa-receipt"></i> Tagihan Pajak
</a>

<p class="nav-section">Pusat Bantuan</p>
<a href="{{ route('Tenant.bantuan') }}" class="nav-link active">
    <i class="fa-solid fa-headset"></i> Pusat Bantuan
</a>

<p class="nav-section">Akun</p>
<a href="{{ route('Tenant.profil') }}" class="nav-link">
    <i class="fa-solid fa-store"></i> Profil Usaha
</a>
@endsection

@section('content')

@if(session('success'))
<div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm mb-5">
    <i class="fa-solid fa-circle-check shrink-0"></i>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kiri: FAQ + Form --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- FAQ --}}
        <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-brand-100 bg-brand-50 flex items-center gap-2">
                <i class="fa-solid fa-circle-question text-brand-gold text-lg"></i>
                <div>
                    <h3 class="font-bold text-brand-800 text-sm">FAQ Tenant</h3>
                    <p class="text-[11px] text-brand-400">Pertanyaan yang sering diajukan</p>
                </div>
            </div>
            <div class="divide-y divide-brand-50">
                @foreach([
                    ['Bagaimana cara mengubah profil usaha saya?',
                     'Masuk ke menu "Profil Usaha" di sidebar kiri. Di sana Anda bisa mengubah nama usaha, jenis usaha, deskripsi, nomor kontak, serta mengunggah logo baru.'],
                    ['Kapan tagihan pajak saya muncul?',
                     'Tagihan pajak digenerate otomatis oleh sistem setiap bulan berdasarkan persentase yang disepakati dengan admin. Anda dapat melihatnya di menu "Tagihan Pajak".'],
                    ['Bagaimana cara membayar tagihan pajak?',
                     'Pergi ke menu "Tagihan Pajak", pilih tagihan yang belum dibayar, lalu unggah bukti transfer ke nomor rekening yang tertera. Admin akan mengkonfirmasi dalam 1×24 jam kerja.'],
                    ['Status Tenant saya masih "Menunggu", apa yang harus dilakukan?',
                     'Tidak perlu khawatir. Tim admin kami sedang meninjau permohonan Anda. Proses biasanya selesai dalam 1×24 jam kerja. Jika lebih dari itu, kirim tiket bantuan di bawah ini.'],
                    ['Apakah saya bisa mendaftar ke lebih dari satu event?',
                     'Ya, Anda bisa mendaftar ke event lain melalui menu "Daftar Event" jika tersedia event baru. Setiap pendaftaran akan melalui proses persetujuan admin terlebih dahulu.'],
                    ['Bagaimana jika ada perbedaan data pada tagihan saya?',
                     'Jika ada ketidaksesuaian data tagihan, segera kirim tiket bantuan dengan menyebutkan nomor tagihan dan detail perbedaannya. Admin akan meninjau dan mengoreksi dalam 1×24 jam.'],
                    ['Apakah data usaha saya aman di E-RTIFACT?',
                     'Ya, seluruh data Anda tersimpan aman dan terenkripsi. Hanya Anda dan admin museum yang berwenang dapat mengakses informasi usaha Anda.'],
                ] as $i => [$q, $a])
                <div class="faq-item">
                    <button onclick="toggleFaq({{ $i }})"
                        class="w-full px-5 py-4 flex items-center justify-between text-left gap-3 hover:bg-brand-50 transition-colors group">
                        <span class="text-sm font-semibold text-brand-800 group-hover:text-brand-600">{{ $q }}</span>
                        <i id="faq-icon-{{ $i }}" class="fa-solid fa-chevron-down text-brand-300 text-xs transition-transform duration-300 shrink-0"></i>
                    </button>
                    <div id="faq-ans-{{ $i }}" class="hidden px-5 pb-4 text-xs text-brand-500 leading-relaxed -mt-1">
                        {{ $a }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Form Kirim Tiket --}}
        <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-brand-100 bg-brand-50 flex items-center gap-2">
                <i class="fa-solid fa-ticket text-brand-500 text-lg"></i>
                <div>
                    <h3 class="font-bold text-brand-800 text-sm">Kirim Tiket Bantuan</h3>
                    <p class="text-[11px] text-brand-400">Admin akan merespons dalam 1×24 jam kerja</p>
                </div>
            </div>
            <div class="p-5">
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-4">
                    @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
                </div>
                @endif
                <form method="POST" action="{{ route('Tenant.bantuan.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-brand-700 uppercase tracking-wider mb-1.5">
                            Subjek Tiket <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="subjek" value="{{ old('subjek') }}"
                            class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none transition-colors"
                            placeholder="Contoh: Pertanyaan tentang tagihan pajak..." required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-brand-700 uppercase tracking-wider mb-1.5">
                            Pesan <span class="text-red-400">*</span>
                        </label>
                        <textarea name="pesan" rows="5"
                            class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none transition-colors resize-none"
                            placeholder="Jelaskan pertanyaan atau masalah Anda secara detail agar admin dapat membantu dengan cepat..." required>{{ old('pesan') }}</textarea>
                    </div>
                    <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 text-xs text-blue-700">
                        <i class="fa-solid fa-circle-info shrink-0"></i>
                        <span>Tiket yang sudah disubmit tidak dapat diubah. Pastikan isi pesan Anda sudah benar sebelum mengirim.</span>
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center py-3">
                        <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Tiket Bantuan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Kanan: Riwayat Tiket --}}
    <div class="space-y-4">

        {{-- Statistik tiket --}}
        <div class="grid grid-cols-3 gap-2">
            @foreach([
                ['Menunggu', $tikets->where('status','menunggu')->count(), 'bg-yellow-50 border-yellow-200 text-yellow-700'],
                ['Dibalas',  $tikets->where('status','dibalas')->count(),  'bg-emerald-50 border-emerald-200 text-emerald-700'],
                ['Ditutup',  $tikets->where('status','ditutup')->count(),  'bg-gray-50 border-gray-200 text-gray-600'],
            ] as [$label, $count, $cls])
            <div class="border rounded-xl p-3 text-center {{ $cls }}">
                <p class="font-serif text-xl font-bold">{{ $count }}</p>
                <p class="text-[10px] font-bold uppercase">{{ $label }}</p>
            </div>
            @endforeach
        </div>

        {{-- Daftar tiket --}}
        <div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
            <div class="px-4 py-3 border-b border-brand-100 bg-brand-50">
                <h3 class="font-bold text-brand-800 text-sm">Riwayat Tiket Saya</h3>
            </div>
            <div class="divide-y divide-brand-50 max-h-[600px] overflow-y-auto">
                @forelse($tikets as $t)
                <div class="p-4 hover:bg-brand-50 transition-colors">
                    <div class="flex items-start justify-between gap-2 mb-1.5">
                        <p class="text-xs font-semibold text-brand-800 leading-snug">{{ $t->subjek }}</p>
                        <span class="badge {{ $t->status_badge }} text-[10px] shrink-0">{{ $t->status_label }}</span>
                    </div>
                    <p class="text-[11px] text-brand-400 mb-2">{{ $t->created_at->translatedFormat('d M Y, H:i') }}</p>
                    <p class="text-[11px] text-brand-500 leading-relaxed line-clamp-2">{{ $t->pesan }}</p>
                    @if($t->balasan_admin)
                    <div class="mt-2 bg-emerald-50 border border-emerald-200 rounded-lg p-2.5">
                        <p class="text-[10px] font-bold text-emerald-700 mb-1">
                            <i class="fa-solid fa-reply mr-1"></i> Balasan Admin · {{ $t->dibalas_pada?->translatedFormat('d M Y') }}
                        </p>
                        <p class="text-[11px] text-emerald-800 leading-relaxed">{{ $t->balasan_admin }}</p>
                    </div>
                    @endif
                </div>
                @empty
                <div class="py-12 flex flex-col items-center text-center px-4">
                    <i class="fa-regular fa-ticket text-3xl text-brand-200 mb-3"></i>
                    <p class="text-sm font-semibold text-brand-600">Belum ada tiket bantuan</p>
                    <p class="text-xs text-brand-400 mt-1">Gunakan form di samping untuk mengirim tiket pertama Anda.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleFaq(idx) {
    const ans  = document.getElementById('faq-ans-' + idx);
    const icon = document.getElementById('faq-icon-' + idx);
    const hidden = ans.classList.contains('hidden');
    // close all
    document.querySelectorAll('[id^="faq-ans-"]').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('[id^="faq-icon-"]').forEach(el => el.classList.remove('rotate-180'));
    // open clicked if it was closed
    if (hidden) {
        ans.classList.remove('hidden');
        icon.classList.add('rotate-180');
    }
}
</script>
@endpush
@endsection
