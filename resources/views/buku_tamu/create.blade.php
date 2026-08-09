@extends('layouts.app')

@section('title', 'Buku Tamu & Pembelian Tiket — E-RTIFACT')

@section('content')
<section class="py-20 cultural-bg min-h-screen flex items-center justify-center">
    <div class="max-w-xl w-full mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header -->
        <div class="text-center mb-10 reveal-on-scroll">
            <span class="inline-flex items-center gap-2 bg-budaya-accent/20 text-budaya-700 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase mb-4">
                <i class="fa-solid fa-book-open"></i> Buku Tamu
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-budaya-900 mb-2">Selamat Datang di Museum</h1>
            <p class="text-budaya-500">Mohon isi buku tamu dan pilih jenis tiket untuk kunjungan Anda.</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-3xl shadow-xl border border-budaya-100 overflow-hidden reveal-on-scroll">
            <form action="{{ route('buku-tamu.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-bold text-budaya-700 mb-2">Nama Lengkap / Rombongan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-budaya-400">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <input type="text" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" required
                            class="w-full border border-budaya-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:ring-2 focus:ring-budaya-400 focus:border-budaya-400 transition-colors bg-budaya-50/50 focus:bg-white" 
                            placeholder="Misal: Budi Santoso atau SMAN 1">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-budaya-700 mb-2">Jumlah Orang <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-budaya-400">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <input type="number" name="jumlah_orang" id="jumlah_orang" value="{{ old('jumlah_orang', 1) }}" required min="1"
                                class="w-full border border-budaya-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:ring-2 focus:ring-budaya-400 focus:border-budaya-400 transition-colors bg-budaya-50/50 focus:bg-white"
                                onchange="hitungTotal()" oninput="hitungTotal()">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-budaya-700 mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-budaya-400">
                                <i class="fa-regular fa-calendar"></i>
                            </div>
                            <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required
                                class="w-full border border-budaya-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:ring-2 focus:ring-budaya-400 focus:border-budaya-400 transition-colors bg-budaya-50/50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <!-- Jenis Tiket -->
                <div>
                    <label class="block text-sm font-bold text-budaya-700 mb-3">Jenis Tiket <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="jenis_tiket" value="reguler" class="peer sr-only" {{ old('jenis_tiket', 'reguler') === 'reguler' ? 'checked' : '' }} onchange="hitungTotal()">
                            <div class="border-2 border-budaya-100 peer-checked:border-budaya-accent peer-checked:bg-budaya-accent/5 rounded-2xl p-4 transition-all text-center">
                                <i class="fa-solid fa-ticket text-budaya-accent text-2xl mb-2"></i>
                                <p class="font-bold text-budaya-900 text-sm">Reguler</p>
                                <p class="text-budaya-600 font-bold mt-1">Rp 15.000</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="jenis_tiket" value="pelajar" class="peer sr-only" {{ old('jenis_tiket') === 'pelajar' ? 'checked' : '' }} onchange="hitungTotal()">
                            <div class="border-2 border-budaya-100 peer-checked:border-budaya-terracotta peer-checked:bg-budaya-terracotta/5 rounded-2xl p-4 transition-all text-center">
                                <i class="fa-solid fa-graduation-cap text-budaya-terracotta text-2xl mb-2"></i>
                                <p class="font-bold text-budaya-900 text-sm">Pelajar</p>
                                <p class="text-budaya-600 font-bold mt-1">Rp 10.000</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-budaya-700 mb-2">Email (Opsional)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-budaya-400">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-budaya-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:ring-2 focus:ring-budaya-400 focus:border-budaya-400 transition-colors bg-budaya-50/50 focus:bg-white" 
                            placeholder="Untuk menerima salinan tiket digital">
                    </div>
                </div>

                <div class="bg-budaya-50 rounded-xl p-4 border border-budaya-100">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <div class="flex items-center h-5 mt-0.5">
                            <input type="checkbox" name="butuh_guide" id="butuh_guide" value="1" {{ old('butuh_guide') ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-budaya-300 text-budaya-600 focus:ring-budaya-500" onchange="hitungTotal()">
                        </div>
                        <div>
                            <span class="text-sm font-bold text-budaya-800">Kami membutuhkan pemandu wisata (Guide)</span>
                            <p class="text-xs text-budaya-500 mt-1">Centang jika rombongan Anda membutuhkan pemandu.</p>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-bold text-budaya-700 mb-2">Saran & Komentar (Opsional)</label>
                    <textarea name="saran_komentar" rows="3"
                        class="w-full border border-budaya-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-budaya-400 focus:border-budaya-400 transition-colors bg-budaya-50/50 focus:bg-white resize-none" 
                        placeholder="Tuliskan pesan, kesan, atau saran untuk museum kami...">{{ old('saran_komentar') }}</textarea>
                </div>

                <!-- Total Harga Preview -->
                <div class="bg-budaya-900 rounded-2xl p-5 text-center">
                    <p class="text-budaya-300 text-xs font-bold uppercase tracking-wider">Total Pembayaran</p>
                    <p id="total-harga" class="text-budaya-accent font-serif text-3xl font-bold mt-1">Rp 15.000</p>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-budaya-700 hover:bg-budaya-800 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg flex justify-center items-center gap-2">
                        Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function hitungTotal() {
    const jumlah = parseInt(document.getElementById('jumlah_orang').value) || 1;
    const jenis = document.querySelector('input[name="jenis_tiket"]:checked')?.value || 'reguler';
    const butuhGuide = document.getElementById('butuh_guide')?.checked;
    const harga = jenis === 'pelajar' ? 10000 : 15000;
    let total = harga * jumlah;
    if (butuhGuide) {
        total += 50000;
    }
    document.getElementById('total-harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
@endpush
