@extends('layouts.app')

@section('title', 'Bantuan & FAQ — E-RTIFACT')

@section('content')

{{-- ── HERO SECTION ── --}}
<section class="relative py-20 cultural-bg overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-budaya-900/5 via-transparent to-budaya-accent/5 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-on-scroll">
        <span class="inline-flex items-center gap-2 bg-budaya-accent/20 text-budaya-700 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase mb-6">
            <i class="fa-solid fa-headset"></i> Pusat Bantuan
        </span>
        <h1 class="font-serif text-4xl sm:text-5xl font-bold text-budaya-900 leading-tight">
            Ada yang Bisa Kami <span class="text-budaya-terracotta">Bantu?</span>
        </h1>
        <p class="mt-4 text-budaya-500 text-lg max-w-2xl mx-auto">
            Temukan jawaban dari pertanyaan yang sering diajukan, atau kirim tiket bantuan jika Anda membutuhkan informasi lebih lanjut.
        </p>
    </div>
</section>

{{-- ── FAQ SECTION ── --}}
<section class="py-20 bg-white relative">
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-budaya-300 to-transparent"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center reveal-on-scroll mb-14">
            <span class="inline-flex items-center gap-2 bg-budaya-100 text-budaya-600 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase">
                <i class="fa-solid fa-circle-question"></i> FAQ
            </span>
            <h2 class="mt-4 font-serif text-3xl font-bold text-budaya-900">Pertanyaan yang Sering Diajukan</h2>
        </div>

        <div class="space-y-4 reveal-on-scroll">
            @foreach([
                ['Berapa harga tiket masuk museum?',
                 'Tiket masuk museum tersedia dalam dua jenis: Reguler seharga Rp 15.000 per orang, dan Pelajar seharga Rp 10.000 per orang. Anda bisa membeli tiket secara online melalui halaman Buku Tamu di website kami.'],
                ['Bagaimana cara membeli tiket online?',
                 'Kunjungi halaman "Buku Tamu" di website kami, isi formulir dengan data kunjungan Anda, pilih jenis tiket, lalu lakukan pembayaran melalui QRIS. Setelah pembayaran berhasil, tiket digital Anda bisa langsung didownload atau dicetak.'],
                ['Apa saja jam operasional museum?',
                 'Museum buka setiap hari Senin sampai Sabtu, pukul 08.00 - 16.00 WIB. Museum tutup pada hari Minggu dan hari libur nasional.'],
                ['Apakah tersedia pemandu wisata (guide)?',
                 'Ya! Saat mengisi Buku Tamu, Anda bisa mencentang opsi "Membutuhkan Pemandu Wisata". Tim kami akan menyiapkan guide yang akan menemani rombongan Anda selama berkeliling museum.'],
                ['Bisakah saya berkunjung secara rombongan?',
                 'Tentu saja! Museum kami menerima kunjungan rombongan dari sekolah, instansi, dan komunitas. Silakan isi jumlah orang saat mengisi Buku Tamu. Untuk rombongan besar (> 50 orang), kami sarankan mengirim tiket bantuan terlebih dahulu agar kami bisa menyiapkan fasilitas terbaik.'],
                ['Apa itu E-RTIFACT?',
                 'E-RTIFACT adalah Sistem Informasi Kearsipan Budaya Lhokseumawe — sebuah platform digital yang memadukan pelestarian sejarah Aceh dengan teknologi modern. Kami mengelola koleksi artefak, arsip sejarah, tokoh penting, dan peta lokasi bersejarah secara digital dan interaktif.'],
                ['Bagaimana cara menjadi Tenant di event museum?',
                 'Untuk menjadi Tenant di event museum, daftarkan akun Anda melalui halaman Registrasi, lalu pilih event yang tersedia. Admin akan meninjau permohonan Anda dan memberikan keputusan dalam 1×24 jam kerja.'],
                ['Apakah tiket bisa direfund?',
                 'Saat ini kami belum menyediakan fasilitas refund otomatis. Jika ada kendala, silakan kirim tiket bantuan melalui formulir di bawah ini, dan tim admin kami akan membantu menyelesaikan masalah Anda.'],
            ] as $i => [$q, $a])
            <div class="bg-budaya-50 border border-budaya-200 rounded-2xl overflow-hidden hover:shadow-md transition-all duration-300">
                <button onclick="toggleFaq({{ $i }})"
                    class="w-full px-6 py-5 flex items-center justify-between text-left gap-4 group">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 bg-budaya-accent/20 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-budaya-accent/30 transition-colors">
                            <span class="text-budaya-accent font-bold text-sm">{{ $i + 1 }}</span>
                        </div>
                        <span class="font-bold text-budaya-800 group-hover:text-budaya-terracotta transition-colors">{{ $q }}</span>
                    </div>
                    <i id="faq-icon-{{ $i }}" class="fa-solid fa-chevron-down text-budaya-300 text-sm transition-transform duration-300 shrink-0"></i>
                </button>
                <div id="faq-ans-{{ $i }}" class="hidden px-6 pb-5 -mt-1">
                    <div class="pl-12 text-sm text-budaya-600 leading-relaxed border-l-2 border-budaya-accent/30 ml-4 pl-6">
                        {{ $a }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── FORM TIKET BANTUAN ── --}}
<section class="py-20 cultural-bg relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-5 gap-10">
            {{-- Info Panel --}}
            <div class="lg:col-span-2 reveal-on-scroll">
                <span class="inline-flex items-center gap-2 bg-budaya-accent/20 text-budaya-700 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase mb-6">
                    <i class="fa-solid fa-envelope"></i> Hubungi Kami
                </span>
                <h2 class="font-serif text-3xl font-bold text-budaya-900 mb-4">Kirim Tiket Bantuan</h2>
                <p class="text-budaya-500 leading-relaxed mb-8">
                    Tidak menemukan jawaban di FAQ? Kirim pertanyaan atau keluhan Anda melalui formulir ini. Tim admin kami akan merespons secepat mungkin.
                </p>

                <div class="space-y-5">
                    @foreach([
                        ['fa-clock', 'Respon Cepat', 'Kami berusaha membalas setiap tiket dalam 1×24 jam kerja.'],
                        ['fa-shield-halved', 'Data Aman', 'Informasi Anda dijaga kerahasiaannya dan tidak dibagikan ke pihak ketiga.'],
                        ['fa-phone', 'Kontak Alternatif', 'Telp: (0645) 12345 | WhatsApp: 0812-xxxx-xxxx'],
                    ] as [$icon, $title, $desc])
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-budaya-accent/20 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid {{ $icon }} text-budaya-accent"></i>
                        </div>
                        <div>
                            <p class="font-bold text-budaya-800 text-sm">{{ $title }}</p>
                            <p class="text-xs text-budaya-500 mt-0.5">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Form --}}
            <div class="lg:col-span-3 reveal-on-scroll">
                <div class="bg-white rounded-3xl shadow-xl border border-budaya-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-budaya-900 to-budaya-800 px-6 py-4 flex items-center gap-3">
                        <i class="fa-solid fa-ticket text-budaya-accent text-lg"></i>
                        <div>
                            <h3 class="text-white font-bold text-sm">Formulir Tiket Bantuan</h3>
                            <p class="text-budaya-400 text-[11px]">Isi formulir di bawah, lalu tekan kirim</p>
                        </div>
                    </div>

                    <div class="p-6">
                        @if(session('success'))
                        <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm mb-5">
                            <i class="fa-solid fa-circle-check shrink-0"></i>
                            {{ session('success') }}
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-5">
                            @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
                        </div>
                        @endif

                        <form method="POST" action="{{ route('bantuan-publik.store') }}" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-budaya-700 uppercase tracking-wider mb-1.5">
                                        Nama Lengkap <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" name="nama" value="{{ old('nama') }}" required
                                        class="w-full border border-budaya-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-budaya-400 focus:border-budaya-400 transition-colors bg-budaya-50/50 focus:bg-white"
                                        placeholder="Nama Anda">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-budaya-700 uppercase tracking-wider mb-1.5">
                                        Email <span class="text-red-400">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full border border-budaya-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-budaya-400 focus:border-budaya-400 transition-colors bg-budaya-50/50 focus:bg-white"
                                        placeholder="email@contoh.com">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-budaya-700 uppercase tracking-wider mb-1.5">
                                    Subjek <span class="text-red-400">*</span>
                                </label>
                                <input type="text" name="subjek" value="{{ old('subjek') }}" required
                                    class="w-full border border-budaya-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-budaya-400 focus:border-budaya-400 transition-colors bg-budaya-50/50 focus:bg-white"
                                    placeholder="Contoh: Pertanyaan tentang tiket rombongan">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-budaya-700 uppercase tracking-wider mb-1.5">
                                    Pesan <span class="text-red-400">*</span>
                                </label>
                                <textarea name="pesan" rows="5" required
                                    class="w-full border border-budaya-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-budaya-400 focus:border-budaya-400 transition-colors bg-budaya-50/50 focus:bg-white resize-none"
                                    placeholder="Jelaskan pertanyaan atau masalah Anda secara detail...">{{ old('pesan') }}</textarea>
                            </div>
                            <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 text-xs text-blue-700">
                                <i class="fa-solid fa-circle-info shrink-0"></i>
                                <span>Tiket yang sudah dikirim tidak dapat diubah. Pastikan isi pesan sudah benar.</span>
                            </div>
                            <button type="submit" class="w-full bg-budaya-900 hover:bg-budaya-800 text-budaya-accent font-bold py-3.5 px-6 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> Kirim Tiket Bantuan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
