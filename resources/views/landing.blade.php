@extends('layouts.app')

@section('title', 'E-RTIFACT — Museum Digital Lhokseumawe')

@section('content')

{{-- ============ LOADING SCREEN — KUPIAH MEUKEUTOP ============ --}}
<div id="loading-screen" class="fixed inset-0 z-[9999] bg-budaya-900 flex flex-col items-center justify-center transition-opacity duration-700">
    <div class="kupiah-loader mb-6">
        <svg width="100" height="90" viewBox="0 0 100 90" xmlns="http://www.w3.org/2000/svg">
            {{-- Kupiah Meukeutop shape --}}
            <defs>
                <linearGradient id="kupiah-gradient" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#1A0F06"/>
                    <stop offset="100%" stop-color="#321F0E"/>
                </linearGradient>
            </defs>
            {{-- Main hat body --}}
            <path d="M50 5 L85 35 L90 65 Q90 80 50 85 Q10 80 10 65 L15 35 Z" fill="url(#kupiah-gradient)" stroke="#C9963A" stroke-width="1.5"/>
            {{-- Gold zigzag band --}}
            <polyline points="15,45 25,38 35,45 45,38 55,45 65,38 75,45 85,38" fill="none" stroke="#D4AF37" stroke-width="2.5" class="kupiah-zigzag"/>
            {{-- Red zigzag band --}}
            <polyline points="13,55 23,48 33,55 43,48 53,55 63,48 73,55 83,48 88,52" fill="none" stroke="#C05C33" stroke-width="2" class="kupiah-zigzag-2"/>
            {{-- Top ornament --}}
            <circle cx="50" cy="12" r="4" fill="#D4AF37" class="kupiah-top-gem"/>
        </svg>
    </div>
    <p class="text-budaya-accent font-serif text-lg animate-pulse tracking-wider">Memuat Warisan Budaya...</p>
</div>

{{-- ============ HERO ============ --}}
<section id="hero" class="relative cultural-bg overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-budaya-900/5 via-transparent to-budaya-accent/5 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="reveal-on-scroll">
                <span class="inline-flex items-center gap-2 bg-budaya-200/60 text-budaya-700 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase mb-6">
                    <span class="w-2 h-2 bg-budaya-accent rounded-full animate-pulse"></span> Museum Digital Lhokseumawe
                </span>
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-budaya-900 leading-tight">
                    Jelajahi Sejarah di
                    <span class="text-budaya-terracotta block">E-RTIFACT</span>
                </h1>
                <p class="mt-6 text-budaya-500 text-lg leading-relaxed max-w-lg">
                    Temukan ribuan koleksi artefak kuno, arsip penting, dan kenali tokoh-tokoh bersejarah dari Aceh dan Nusantara.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#koleksi" class="inline-flex items-center gap-2 bg-budaya-700 hover:bg-budaya-800 text-white px-7 py-3.5 rounded-xl font-semibold text-sm transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        <i class="fa-solid fa-compass"></i> Eksplorasi Koleksi
                    </a>
                    <a href="{{ route('buku-tamu.create') }}" class="inline-flex items-center gap-2 bg-white hover:bg-budaya-100 text-budaya-700 border-2 border-budaya-300 px-7 py-3.5 rounded-xl font-semibold text-sm transition-all hover:-translate-y-0.5">
                        <i class="fa-solid fa-book-open"></i> Isi Buku Tamu
                    </a>
                </div>
            </div>
            <div class="reveal-on-scroll relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-2 border-budaya-200 group">
                    <img src="{{ asset('images/museum_1.jpg') }}"
                         alt="Museum E-RTIFACT"
                         class="w-full h-[400px] object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-budaya-900/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <p class="text-white font-serif text-xl font-bold">Museum Digital Lhokseumawe</p>
                        <p class="text-budaya-200 text-sm mt-1">Melestarikan warisan budaya Aceh melalui teknologi</p>
                    </div>
                </div>
                {{-- Floating badge --}}
                <div class="absolute -top-4 -right-4 bg-budaya-accent text-budaya-900 w-20 h-20 rounded-2xl flex flex-col items-center justify-center shadow-xl rotate-6 hover:rotate-0 transition-transform">
                    <span class="text-2xl font-bold leading-none">50+</span>
                    <span class="text-[9px] font-bold uppercase tracking-wide">Artefak</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ KOLEKSI PREVIEW ============ --}}
<section id="koleksi" class="py-20 bg-white relative">
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-budaya-300 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center reveal-on-scroll">
            <span class="inline-flex items-center gap-2 bg-budaya-100 text-budaya-600 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase">
                <i class="fa-solid fa-cube"></i> Koleksi Kami
            </span>
            <h2 class="mt-4 font-serif text-3xl sm:text-4xl font-bold text-budaya-900">
                Jelajahi Peninggalan Sejarah
            </h2>
            <p class="mt-3 text-budaya-400 max-w-xl mx-auto">Beberapa artefak pilihan dari koleksi museum kami yang bernilai sejarah tinggi.</p>
        </div>

        <div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($artefaks->take(4) as $idx => $item)
            <div class="reveal-on-scroll group bg-budaya-50 border border-budaya-200 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-500" style="transition-delay: {{ $idx * 100 }}ms">
                <div class="relative overflow-hidden">
                    <img src="{{ $item->gambar_path && !str_starts_with($item->gambar_path, 'http') ? asset('storage/'.$item->gambar_path) : ($item->gambar_path ?: 'https://images.unsplash.com/photo-1595079676339-1534801ad6cf?auto=format&fit=crop&w=400&q=80') }}"
                         alt="{{ $item->nama_artefak }}"
                         class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-budaya-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="p-5">
                    <h3 class="font-serif font-bold text-budaya-900 text-lg leading-snug group-hover:text-budaya-terracotta transition-colors">{{ $item->nama_artefak }}</h3>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-[11px] bg-budaya-100 text-budaya-600 px-2 py-0.5 rounded-full font-semibold">{{ $item->kategori }}</span>
                        <span class="text-[11px] text-budaya-400">{{ $item->era_periodisasi }}</span>
                    </div>
                    <p class="text-sm text-budaya-500 mt-3 leading-relaxed">{{ Str::limit($item->deskripsi, 70) }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center reveal-on-scroll">
            <a href="{{ route('landing.koleksi') }}" class="inline-flex items-center gap-3 bg-budaya-700 hover:bg-budaya-800 text-white px-8 py-4 rounded-xl font-bold text-sm transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <i class="fa-solid fa-layer-group"></i>
                Lihat Selengkapnya di Katalog Koleksi
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- ============ EVENT MENDATANG ============ --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<section id="event" class="py-24 cultural-bg relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center reveal-on-scroll mb-16">
            <span class="inline-flex items-center gap-2 bg-budaya-accent/20 text-budaya-700 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase">
                <i class="fa-solid fa-calendar-star"></i> Event Museum
            </span>
            <h2 class="mt-4 font-serif text-4xl sm:text-5xl font-bold text-budaya-900">
                Event Mendatang
            </h2>
            <p class="mt-4 text-budaya-500 max-w-2xl mx-auto text-lg">Ikuti berbagai kegiatan budaya dan pameran interaktif yang diselenggarakan secara rutin di area museum.</p>
        </div>

        <div class="swiper eventSwiper reveal-on-scroll">
            <div class="swiper-wrapper pb-16">
                @forelse($events as $idx => $event)
                <div class="swiper-slide">
                    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl border border-budaya-200 cursor-pointer group flex flex-col lg:flex-row h-full mx-2" onclick="openEventModal({{ $event->id }})">
                        <div class="lg:w-5/12 relative h-72 lg:h-auto overflow-hidden">
                            @if($event->gambar_path)
                            <img src="{{ asset('storage/' . $event->gambar_path) }}" alt="{{ $event->judul_event }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-budaya-900/60 via-budaya-900/10 to-transparent pointer-events-none"></div>
                            @else
                            <div class="absolute inset-0 bg-gradient-to-br from-budaya-700 via-budaya-800 to-budaya-900 flex items-center justify-center group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#D4AF37_1px,transparent_1px)] [background-size:20px_20px]"></div>
                                <div class="text-center px-8 relative z-10">
                                    <div class="w-20 h-20 mx-auto bg-budaya-accent/20 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm group-hover:scale-110 transition-transform duration-500">
                                        <i class="fa-solid fa-masks-theater text-budaya-accent text-4xl"></i>
                                    </div>
                                    <p class="text-budaya-accent font-serif text-3xl font-bold leading-tight">{{ $event->judul_event }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="lg:w-7/12 p-8 sm:p-12 flex flex-col justify-center">
                            <div class="mb-6">
                                @if($event->status == 'berjalan')
                                <span class="inline-block px-4 py-1.5 text-xs font-bold rounded-full bg-green-500 text-white shadow-lg animate-pulse mb-4">● Sedang Berlangsung</span>
                                @else
                                <span class="inline-block px-4 py-1.5 text-xs font-bold rounded-full bg-budaya-accent text-budaya-900 shadow-lg mb-4">{{ ucfirst($event->status) }}</span>
                                @endif
                                <h3 class="font-serif text-3xl sm:text-4xl font-bold text-budaya-900 group-hover:text-budaya-terracotta transition-colors leading-tight">{{ $event->judul_event }}</h3>
                            </div>
                            <p class="text-budaya-500 leading-relaxed mb-8 text-lg">{{ Str::limit($event->deskripsi, 180) }}</p>
                            
                            <div class="grid sm:grid-cols-2 gap-4 mb-10">
                                <div class="flex items-center gap-4 bg-budaya-50 p-4 rounded-2xl border border-budaya-100">
                                    <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-calendar-day text-budaya-accent text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-budaya-400 font-bold uppercase tracking-wider mb-1">Tanggal</p>
                                        <p class="text-budaya-800 font-semibold text-sm">{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 bg-budaya-50 p-4 rounded-2xl border border-budaya-100">
                                    <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-location-dot text-budaya-terracotta text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-budaya-400 font-bold uppercase tracking-wider mb-1">Lokasi</p>
                                        <p class="text-budaya-800 font-semibold text-sm">{{ $event->lokasi_area ?? 'Area Museum' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto pt-6 border-t border-budaya-100 flex flex-wrap items-center justify-between gap-4">
                                <span class="text-budaya-terracotta font-bold hover:text-budaya-800 transition-colors flex items-center gap-2">
                                    Lihat Detail Event <i class="fa-solid fa-arrow-right"></i>
                                </span>
                                <a href="{{ route('register') }}" onclick="event.stopPropagation()" class="bg-budaya-900 hover:bg-budaya-800 text-white px-8 py-3.5 rounded-xl font-bold text-sm transition-all shadow-xl hover:-translate-y-1 flex items-center gap-2">
                                    <i class="fa-solid fa-store"></i> Daftar Tenant
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="swiper-slide">
                    <div class="text-center py-24 bg-white rounded-[2.5rem] border border-budaya-200 shadow-xl mx-2">
                        <div class="w-24 h-24 mx-auto bg-budaya-50 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fa-regular fa-calendar-xmark text-budaya-300 text-5xl"></i>
                        </div>
                        <p class="font-serif text-3xl font-bold text-budaya-900 mb-2">Belum Ada Event Terdekat</p>
                        <p class="text-budaya-500 text-lg">Nantikan berbagai acara menarik dari kami selanjutnya!</p>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="swiper-pagination !bottom-0"></div>
            <div class="swiper-button-next !text-budaya-900 !w-14 !h-14 bg-white rounded-full shadow-lg border border-budaya-100 hidden md:flex after:!text-xl hover:bg-budaya-50 transition-colors !right-2"></div>
            <div class="swiper-button-prev !text-budaya-900 !w-14 !h-14 bg-white rounded-full shadow-lg border border-budaya-100 hidden md:flex after:!text-xl hover:bg-budaya-50 transition-colors !left-2"></div>
        </div>
    </div>
</section>

{{-- ============ TENTANG MUSEUM ============ --}}
<section class="py-24 bg-white relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-budaya-50/50 rounded-l-[100px] -z-10"></div>
    <div class="absolute -left-32 top-32 w-64 h-64 bg-budaya-accent/10 rounded-full blur-3xl -z-10"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="reveal-on-scroll order-2 lg:order-1">
                <span class="inline-flex items-center gap-2 bg-budaya-100 text-budaya-700 px-5 py-2 rounded-full text-xs font-bold tracking-wider uppercase mb-6 border border-budaya-200">
                    <i class="fa-solid fa-landmark text-budaya-terracotta"></i> Profil Museum
                </span>
                <h2 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-budaya-900 leading-[1.1] mb-8">
                    Merawat Ingatan,<br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-budaya-700 to-budaya-terracotta">Menjaga Warisan.</span>
                </h2>
                
                <div class="space-y-6 text-budaya-600 leading-relaxed text-lg mb-10">
                    <p class="font-medium text-budaya-800">
                        Museum Kota Lhokseumawe hadir sebagai pusat pelestarian sejarah dan budaya kebanggaan masyarakat Aceh, menyimpan jejak peradaban dari masa ke masa.
                    </p>
                    <p>
                        Jelajahi ratusan koleksi berharga mulai dari naskah kuno peninggalan ulama besar, artefak kesultanan, hingga saksi bisu perjuangan rakyat Aceh. Kami memadukan nilai historis dengan pendekatan digital interaktif untuk memberikan pengalaman edukasi yang tak terlupakan bagi generasi masa kini.
                    </p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-5">
                    <div class="bg-white p-5 rounded-2xl border border-budaya-200 shadow-sm flex-1 hover:shadow-md transition-shadow group">
                        <div class="w-12 h-12 bg-budaya-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-budaya-accent/20 transition-colors">
                            <i class="fa-solid fa-clock text-budaya-accent text-xl"></i>
                        </div>
                        <h4 class="font-bold text-budaya-900 mb-1">Jam Operasional</h4>
                        <p class="text-sm text-budaya-500">Senin - Sabtu<br/>08:00 - 16:00 WIB</p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-budaya-200 shadow-sm flex-1 hover:shadow-md transition-shadow group">
                        <div class="w-12 h-12 bg-budaya-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-budaya-accent/20 transition-colors">
                            <i class="fa-solid fa-ticket text-budaya-accent text-xl"></i>
                        </div>
                        <h4 class="font-bold text-budaya-900 mb-1">Tiket Kunjungan</h4>
                        <p class="text-sm text-budaya-500">Reguler: Rp 15.000<br/>Pelajar: Rp 10.000</p>
                    </div>
                </div>
            </div>
            
            <div class="reveal-on-scroll relative order-1 lg:order-2">
                <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white">
                    <img src="{{ asset('images/museum_2.jpg') }}" 
                         alt="Museum Kota Lhokseumawe" 
                         class="w-full h-[550px] object-cover hover:scale-110 transition-transform duration-1000">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-budaya-900/90 via-budaya-900/20 to-transparent"></div>
                    
                    <div class="absolute bottom-10 left-10 right-10">
                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-semibold mb-4">
                            <i class="fa-solid fa-camera"></i> Gedung Utama
                        </div>
                        <p class="text-white font-serif text-3xl font-bold mb-2">Museum Kota Lhokseumawe</p>
                        <p class="text-budaya-200 flex items-center gap-2 opacity-90">
                            <i class="fa-solid fa-map-pin text-budaya-accent"></i> Jl. Merdeka, Pusat Kota Lhokseumawe
                        </p>
                    </div>
                </div>
                
                <!-- Floating Stats Card -->
                <div class="absolute -left-8 top-12 bg-white p-6 rounded-3xl shadow-xl border border-budaya-100 animate-float hidden md:block">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-budaya-900 rounded-full flex items-center justify-center text-budaya-accent">
                            <i class="fa-solid fa-book-journal-whills text-xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-budaya-900 leading-none mb-1">500+</p>
                            <p class="text-xs font-bold text-budaya-500 uppercase tracking-wider">Koleksi Sejarah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ EVENT DETAIL MODAL ============ --}}
<div id="event-modal" class="fixed inset-0 z-[999] hidden">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-budaya-900/70 backdrop-blur-sm" onclick="closeEventModal()"></div>
    {{-- Modal content --}}
    <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
        <div id="event-modal-content" class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform scale-90 opacity-0 transition-all duration-300">
            {{-- Modal header flyer --}}
            <div id="modal-header-bg" class="relative h-64 bg-gradient-to-br from-budaya-700 via-budaya-800 to-budaya-900 rounded-t-3xl overflow-hidden flex items-center justify-center bg-cover bg-center">
                <div class="absolute inset-0 bg-budaya-900/50"></div>
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#D4AF37_1px,transparent_1px)] [background-size:16px_16px]"></div>
                <div class="relative text-center px-8">
                    <div class="w-20 h-20 mx-auto bg-budaya-accent/20 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-masks-theater text-budaya-accent text-3xl"></i>
                    </div>
                    <h2 id="modal-title" class="font-serif text-2xl sm:text-3xl font-bold text-white"></h2>
                    <div id="modal-status" class="mt-3"></div>
                </div>
                <button onclick="closeEventModal()" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/30 backdrop-blur rounded-xl flex items-center justify-center text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- Modal body --}}
            <div class="p-8">
                <div class="space-y-6">
                    {{-- Description --}}
                    <div>
                        <h3 class="font-bold text-budaya-800 text-sm uppercase tracking-wider mb-2">
                            <i class="fa-solid fa-align-left text-budaya-accent mr-1"></i> Deskripsi
                        </h3>
                        <p id="modal-desc" class="text-budaya-600 leading-relaxed"></p>
                    </div>

                    {{-- Details grid --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-budaya-50 rounded-xl p-4 border border-budaya-100">
                            <p class="text-[11px] text-budaya-400 font-bold uppercase tracking-wider">Tanggal Mulai</p>
                            <p id="modal-start" class="font-bold text-budaya-800 mt-1"></p>
                        </div>
                        <div class="bg-budaya-50 rounded-xl p-4 border border-budaya-100">
                            <p class="text-[11px] text-budaya-400 font-bold uppercase tracking-wider">Tanggal Selesai</p>
                            <p id="modal-end" class="font-bold text-budaya-800 mt-1"></p>
                        </div>
                        <div class="bg-budaya-50 rounded-xl p-4 border border-budaya-100">
                            <p class="text-[11px] text-budaya-400 font-bold uppercase tracking-wider">Lokasi</p>
                            <p id="modal-location" class="font-bold text-budaya-800 mt-1"></p>
                        </div>
                        <div class="bg-budaya-50 rounded-xl p-4 border border-budaya-100">
                            <p class="text-[11px] text-budaya-400 font-bold uppercase tracking-wider">Kuota Tenant</p>
                            <p id="modal-quota" class="font-bold text-budaya-800 mt-1"></p>
                        </div>
                    </div>

                    {{-- Pricing --}}
                    <div class="bg-gradient-to-r from-budaya-accent/10 via-budaya-100 to-budaya-accent/10 rounded-2xl p-6 border border-budaya-200 text-center">
                        <p class="text-xs text-budaya-500 font-bold uppercase tracking-wider">Harga Sewa Booth</p>
                        <p id="modal-price" class="font-serif text-3xl font-bold text-budaya-900 mt-2"></p>
                        <p class="text-sm text-budaya-400 mt-1">per booth selama event berlangsung</p>
                    </div>

                    {{-- Action --}}
                    <div class="flex gap-3">
                        <a href="{{ route('buku-tamu.create') }}" class="text-brand-700 hover:text-brand-900 font-medium text-sm transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-brand-gold after:transition-all hover:after:w-full">Buku Tamu</a>
                        <a href="{{ route('register') }}" class="flex-1 inline-flex items-center justify-center gap-2 bg-budaya-700 hover:bg-budaya-800 text-white py-3.5 rounded-xl font-bold text-sm transition-all shadow-lg hover:shadow-xl">
                            <i class="fa-solid fa-handshake"></i> Daftar Tenant Event Ini
                        </a>
                        <button onclick="closeEventModal()" class="px-6 py-3.5 bg-budaya-100 hover:bg-budaya-200 text-budaya-700 rounded-xl font-bold text-sm transition-all">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ INFO MUSEUM ============ --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['fa-clock', 'Jam Operasional', 'Senin - Sabtu: 08.00 - 16.00 WIB', 'Minggu & Libur: Tutup'],
                ['fa-ticket', 'Harga Tiket', 'Umum: Rp 15.000/orang', 'Rombongan: Rp 10.000/orang'],
                ['fa-map-pin', 'Lokasi Museum', 'Kota Lhokseumawe, Aceh', 'Nanggroe Aceh Darussalam'],
            ] as [$icon, $title, $line1, $line2])
            <div class="reveal-on-scroll text-center p-8 bg-budaya-50 rounded-2xl border border-budaya-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 mx-auto bg-budaya-accent/20 rounded-xl flex items-center justify-center mb-4">
                    <i class="fa-solid {{ $icon }} text-budaya-accent text-xl"></i>
                </div>
                <h3 class="font-serif font-bold text-budaya-900 text-lg">{{ $title }}</h3>
                <p class="text-sm text-budaya-500 mt-2">{{ $line1 }}</p>
                <p class="text-sm text-budaya-400">{{ $line2 }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── Event Data (Server-rendered) ──
const eventsData = @json($events->keyBy('id'));

// ── Loading Screen ──
window.addEventListener('load', () => {
    setTimeout(() => {
        const loader = document.getElementById('loading-screen');
        loader.style.opacity = '0';
        setTimeout(() => { loader.style.display = 'none'; }, 700);
    }, 1200);
});

// ── Scroll Reveal ──
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => e.target.classList.add('active'), i * 80);
        }
    });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal-on-scroll').forEach(el => revealObserver.observe(el));

// ── Event Modal ──
function openEventModal(id) {
    const ev = eventsData[id];
    if (!ev) return;

    document.getElementById('modal-title').textContent = ev.judul_event;
    document.getElementById('modal-desc').textContent = ev.deskripsi || 'Informasi event akan segera diperbarui.';
    document.getElementById('modal-start').textContent = formatDate(ev.tanggal_mulai);
    document.getElementById('modal-end').textContent = formatDate(ev.tanggal_selesai);
    document.getElementById('modal-location').textContent = ev.lokasi_area || 'Area Museum';
    document.getElementById('modal-quota').textContent = ev.kuota_tenant + ' Tenant';
    document.getElementById('modal-price').textContent = 'Rp ' + Number(ev.harga_sewa_booth).toLocaleString('id-ID');

    const statusEl = document.getElementById('modal-status');
    if (ev.status === 'berjalan') {
        statusEl.innerHTML = '<span class="px-3 py-1 text-xs font-bold rounded-full bg-green-500 text-white">● Sedang Berlangsung</span>';
    } else {
        statusEl.innerHTML = '<span class="px-3 py-1 text-xs font-bold rounded-full bg-budaya-accent text-budaya-900">' + capitalize(ev.status) + '</span>';
    }

    const headerBg = document.getElementById('modal-header-bg');
    if (ev.gambar_path) {
        headerBg.style.backgroundImage = `url('/storage/${ev.gambar_path}')`;
    } else {
        headerBg.style.backgroundImage = 'none';
    }

    const modal = document.getElementById('event-modal');
    const content = document.getElementById('event-modal-content');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    requestAnimationFrame(() => {
        content.style.transform = 'scale(1)';
        content.style.opacity = '1';
    });
}

function closeEventModal() {
    const modal = document.getElementById('event-modal');
    const content = document.getElementById('event-modal-content');
    content.style.transform = 'scale(0.9)';
    content.style.opacity = '0';
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }, 300);
}

// Keyboard ESC
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeEventModal(); });

function formatDate(d) {
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const dt = new Date(d);
    return dt.getDate() + ' ' + months[dt.getMonth()] + ' ' + dt.getFullYear();
}
function capitalize(s) { return s.charAt(0).toUpperCase() + s.slice(1); }

// Initialize Swiper
document.addEventListener('DOMContentLoaded', function() {
    const swiper = new Swiper('.eventSwiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
/* Swiper Customization */
.swiper-pagination-bullet {
    background: #D2B48C !important;
    opacity: 0.5;
}
.swiper-pagination-bullet-active {
    background: #C05C33 !important;
    opacity: 1;
    width: 24px;
    border-radius: 4px;
}
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
.animate-float {
    animation: float 3s ease-in-out infinite;
}
/* Kupiah Loader animations */
.kupiah-zigzag {
    stroke-dasharray: 200;
    stroke-dashoffset: 200;
    animation: zigzag-draw 1.5s ease-in-out infinite;
}
.kupiah-zigzag-2 {
    stroke-dasharray: 200;
    stroke-dashoffset: 200;
    animation: zigzag-draw 1.5s ease-in-out 0.3s infinite;
}
.kupiah-top-gem {
    animation: gem-pulse 1s ease-in-out infinite alternate;
}
@keyframes zigzag-draw {
    0% { stroke-dashoffset: 200; }
    50% { stroke-dashoffset: 0; }
    100% { stroke-dashoffset: -200; }
}
@keyframes gem-pulse {
    0% { r: 3; opacity: 0.6; }
    100% { r: 5; opacity: 1; }
}
.kupiah-loader {
    animation: kupiah-float 2s ease-in-out infinite;
}
@keyframes kupiah-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}

/* Event card hover glow */
.event-card::after {
    content: '';
    position: absolute;
    inset: -1px;
    border-radius: 1rem;
    background: linear-gradient(135deg, #D4AF37, #C05C33, #D4AF37);
    z-index: -1;
    opacity: 0;
    transition: opacity 0.4s;
}
.event-card:hover::after {
    opacity: 0.5;
}
</style>
@endpush
