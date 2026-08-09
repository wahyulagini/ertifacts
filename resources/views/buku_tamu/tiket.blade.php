@extends('layouts.app')

@section('title', 'Tiket Masuk Museum — E-RTIFACT')

@section('content')
<section class="py-20 cultural-bg min-h-screen flex items-center justify-center print:bg-white print:py-0 print:min-h-0">
    <div class="max-w-xl w-full mx-auto px-4 sm:px-6 lg:px-8 relative z-10 print:p-0 print:max-w-none">
        
        <div class="text-center mb-10 print:hidden reveal-on-scroll">
            <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase mb-4">
                <i class="fa-solid fa-circle-check"></i> Pembayaran Berhasil
            </span>
            <h1 class="font-serif text-3xl font-bold text-budaya-900 mb-2">Tiket Digital Anda</h1>
            <p class="text-budaya-500">Tunjukkan tiket ini kepada petugas di pintu masuk.</p>
        </div>

        <!-- Ticket Card -->
        <div id="ticket-card" class="bg-white rounded-3xl shadow-2xl border border-budaya-200 overflow-hidden relative reveal-on-scroll print:shadow-none print:border-2 print:border-black print:rounded-none">
            <!-- Decorative edge -->
            <div class="h-4 w-full bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PHBhdGggZD0iTTAgMjBMMTAgMEwyMCAyMFoiIGZpbGw9IiNjMDVjMzMiLz48L3N2Zz4=')] bg-repeat-x opacity-20"></div>

            <div class="p-8">
                <div class="flex justify-between items-start border-b-2 border-dashed border-budaya-200 pb-6 mb-6">
                    <div>
                        <p class="text-budaya-400 text-xs font-bold uppercase tracking-widest mb-1">E-RTIFACT TICKET</p>
                        <h2 class="font-serif text-2xl font-bold text-budaya-900">{{ $bukuTamu->kode_tiket }}</h2>
                    </div>
                    <div class="bg-budaya-50 p-3 rounded-xl border border-budaya-100 print:border-black">
                        <!-- QR Code placeholder -->
                        <div class="w-16 h-16 bg-white border border-budaya-200 flex items-center justify-center print:border-black">
                            <i class="fa-solid fa-qrcode text-3xl text-budaya-900"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-y-6 gap-x-4 mb-6">
                    <div>
                        <p class="text-[10px] font-bold text-budaya-400 uppercase tracking-wider">Nama Pengunjung</p>
                        <p class="font-bold text-budaya-900 mt-1">{{ $bukuTamu->nama_pengunjung }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-budaya-400 uppercase tracking-wider">Tanggal Kunjungan</p>
                        <p class="font-bold text-budaya-900 mt-1">{{ \Carbon\Carbon::parse($bukuTamu->tanggal_kunjungan)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-budaya-400 uppercase tracking-wider">Jenis Tiket</p>
                        <p class="font-bold text-budaya-900 mt-1">{{ ucfirst($bukuTamu->jenis_tiket) }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-budaya-400 uppercase tracking-wider">Jumlah Pengunjung</p>
                        <p class="font-bold text-budaya-900 mt-1">{{ $bukuTamu->jumlah_orang }} Orang</p>
                    </div>
                </div>
                
                <div class="bg-budaya-50 p-4 rounded-xl border border-budaya-100 flex justify-between items-center print:border-black print:bg-white">
                    <div>
                        <p class="text-xs text-budaya-500 font-bold uppercase tracking-wider">Total Pembayaran</p>
                        <p class="font-bold text-budaya-900">Lunas</p>
                    </div>
                    <p class="text-xl font-bold text-budaya-terracotta">{{ $bukuTamu->harga_formatted }}</p>
                </div>
            </div>
            
            <div class="bg-budaya-900 p-4 text-center">
                <p class="text-budaya-200 text-xs font-semibold">Museum Digital Lhokseumawe</p>
                <p class="text-budaya-400 text-[10px] mt-1">Harap simpan tiket ini sebagai bukti pembayaran yang sah.</p>
            </div>
        </div>

        <div class="mt-8 flex justify-center gap-4 print:hidden">
            <a href="{{ route('landing') }}" class="px-6 py-3 bg-white border-2 border-budaya-200 text-budaya-700 font-bold rounded-xl hover:bg-budaya-50 transition">
                Kembali ke Beranda
            </a>
            <button onclick="window.print()" class="px-6 py-3 bg-budaya-700 text-white font-bold rounded-xl shadow-lg hover:bg-budaya-800 transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
            </button>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>
@media print {
    body * { visibility: hidden; }
    #ticket-card, #ticket-card * { visibility: visible; }
    #ticket-card { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none !important; }
}
</style>
@endpush
