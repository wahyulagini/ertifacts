@extends('layouts.app')

@section('title', 'Pembayaran QRIS — E-RTIFACT')

@section('content')
<section class="py-20 cultural-bg min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center mb-10 reveal-on-scroll">
            <span class="inline-flex items-center gap-2 bg-budaya-accent/20 text-budaya-700 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase mb-4">
                <i class="fa-solid fa-wallet"></i> Pembayaran
            </span>
            <h1 class="font-serif text-3xl font-bold text-budaya-900 mb-2">Bayar dengan QRIS</h1>
            <p class="text-budaya-500">Selesaikan pembayaran untuk mendapatkan tiket.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-budaya-100 overflow-hidden reveal-on-scroll">
            <!-- Order Summary -->
            <div class="bg-budaya-50 p-6 border-b border-budaya-100">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-budaya-600 text-xs font-bold uppercase tracking-wider">Detail Pesanan</p>
                    <span class="bg-budaya-200 text-budaya-800 text-[10px] font-bold px-2.5 py-1 rounded-full">{{ $bukuTamu->kode_tiket }}</span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-budaya-600">Nama</span>
                        <span class="font-bold text-budaya-900">{{ $bukuTamu->nama_pengunjung }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-budaya-600">Tiket</span>
                        <span class="font-bold text-budaya-900">{{ $bukuTamu->jumlah_orang }}x {{ ucfirst($bukuTamu->jenis_tiket) }}</span>
                    </div>
                    @if($bukuTamu->butuh_guide)
                    <div class="flex justify-between text-sm">
                        <span class="text-budaya-600">Pemandu (Guide)</span>
                        <span class="font-bold text-budaya-900">Ya (+ Rp 50.000)</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-sm pt-2 border-t border-budaya-200 mt-2">
                        <span class="text-budaya-800 font-bold">Total Bayar</span>
                        <span class="font-bold text-budaya-terracotta text-lg">{{ $bukuTamu->harga_formatted }}</span>
                    </div>
                </div>
            </div>

            <!-- QR Code -->
            <div class="p-8 text-center space-y-6">
                <div class="inline-block p-4 bg-white border border-budaya-200 rounded-2xl shadow-sm relative">
                    <!-- Placeholder QR (SVG) -->
                    <svg viewBox="0 0 100 100" class="w-48 h-48 mx-auto" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100" height="100" fill="#fff"/>
                        <rect x="10" y="10" width="20" height="20" fill="none" stroke="#000" stroke-width="4"/>
                        <rect x="70" y="10" width="20" height="20" fill="none" stroke="#000" stroke-width="4"/>
                        <rect x="10" y="70" width="20" height="20" fill="none" stroke="#000" stroke-width="4"/>
                        <!-- Data modules -->
                        @for($i = 0; $i < 20; $i++)
                        <rect x="{{ rand(10,85) }}" y="{{ rand(35,65) }}" width="4" height="4" fill="#000"/>
                        @endfor
                        @for($i = 0; $i < 20; $i++)
                        <rect x="{{ rand(35,65) }}" y="{{ rand(10,85) }}" width="4" height="4" fill="#000"/>
                        @endfor
                        <rect x="40" y="40" width="20" height="20" fill="#D4AF37"/>
                        <text x="50" y="53" text-anchor="middle" font-size="10" font-weight="bold" fill="#fff">QRIS</text>
                    </svg>
                </div>
                
                <p class="text-sm text-budaya-600">Scan dengan aplikasi e-Wallet atau Mobile Banking Anda.</p>

                <div class="bg-blue-50 text-blue-700 text-sm p-3 rounded-xl flex items-center justify-center gap-2 border border-blue-100">
                    <i class="fa-regular fa-clock"></i>
                    Selesaikan dalam waktu <span class="font-bold text-blue-800">15:00</span>
                </div>

                <form method="POST" action="{{ route('buku-tamu.confirm', $bukuTamu->kode_tiket) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="text-left">
                        <label class="block text-sm font-bold text-budaya-700 mb-2">Upload Bukti Pembayaran <span class="text-red-500">*</span></label>
                        <input type="file" name="bukti_pembayaran" required accept="image/*"
                            class="w-full text-sm text-budaya-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-budaya-100 file:text-budaya-700 hover:file:bg-budaya-200 border border-budaya-200 rounded-xl bg-budaya-50">
                        @error('bukti_pembayaran')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-budaya-700 hover:bg-budaya-800 text-white font-bold py-3.5 px-6 rounded-xl transition-all shadow flex items-center justify-center gap-2 mt-4">
                        <i class="fa-solid fa-check"></i> Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
