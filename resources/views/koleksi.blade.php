@extends('layouts.app')

@section('title', 'Katalog Koleksi Museum — E-RTIFACT')

@section('content')

{{-- ============ LOADING SCREEN ============ --}}
<div id="loading-screen" class="fixed inset-0 z-[9999] bg-budaya-900 flex flex-col items-center justify-center transition-opacity duration-700">
    <div class="kupiah-loader mb-6">
        <svg width="100" height="90" viewBox="0 0 100 90" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="kupiah-gradient" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#1A0F06"/>
                    <stop offset="100%" stop-color="#321F0E"/>
                </linearGradient>
            </defs>
            <path d="M50 5 L85 35 L90 65 Q90 80 50 85 Q10 80 10 65 L15 35 Z" fill="url(#kupiah-gradient)" stroke="#C9963A" stroke-width="1.5"/>
            <polyline points="15,45 25,38 35,45 45,38 55,45 65,38 75,45 85,38" fill="none" stroke="#D4AF37" stroke-width="2.5" class="kupiah-zigzag"/>
            <polyline points="13,55 23,48 33,55 43,48 53,55 63,48 73,55 83,48 88,52" fill="none" stroke="#C05C33" stroke-width="2" class="kupiah-zigzag-2"/>
            <circle cx="50" cy="12" r="4" fill="#D4AF37" class="kupiah-top-gem"/>
        </svg>
    </div>
    <p class="text-budaya-accent font-serif text-lg animate-pulse tracking-wider">Memuat Koleksi...</p>
</div>

<div class="min-h-screen cultural-bg py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="reveal-on-scroll">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-sm text-budaya-500 hover:text-budaya-terracotta transition-colors mb-6">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-budaya-900">Katalog Koleksi Museum</h1>
            <p class="text-budaya-400 mt-2">Temukan ribuan koleksi dari berbagai kategori warisan budaya.</p>
        </div>

        {{-- Tabs & Search --}}
        <div class="mt-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 reveal-on-scroll">
            <div class="flex flex-wrap gap-2">
                @foreach([
                    ['artefak', 'fa-cube', 'Artefak'],
                    ['tokoh', 'fa-person-chalkboard', 'Tokoh Penting'],
                    ['arsip', 'fa-scroll', 'Arsip Sejarah'],
                    ['lokasi', 'fa-map-location-dot', 'Lokasi'],
                ] as [$val, $icon, $label])
                <a href="{{ route('landing.koleksi', ['type' => $val]) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200
                   {{ $type == $val ? 'bg-budaya-700 text-white shadow-lg' : 'bg-white text-budaya-600 border border-budaya-200 hover:bg-budaya-100 hover:border-budaya-300' }}">
                    <i class="fa-solid {{ $icon }}"></i> {{ $label }}
                </a>
                @endforeach
            </div>
            <form action="{{ route('landing.koleksi') }}" method="GET" class="w-full md:w-72">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="relative">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-budaya-400 text-sm"></i>
                    <input type="text" name="q" value="{{ $query }}" placeholder="Cari koleksi..."
                           class="w-full bg-white border border-budaya-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-budaya-800 focus:outline-none focus:ring-2 focus:ring-budaya-accent focus:border-budaya-accent placeholder:text-budaya-300">
                </div>
            </form>
        </div>

        {{-- Grid --}}
        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($data as $idx => $item)
            <div onclick="openModal('modal-{{$type}}-{{$idx}}')" class="cursor-pointer reveal-on-scroll group bg-white border border-budaya-200 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-500" style="transition-delay: {{ ($idx % 4) * 80 }}ms">
                @if($type == 'artefak')
                    <div class="relative overflow-hidden">
                        <img src="{{ $item->gambar_path && !str_starts_with($item->gambar_path, 'http') ? asset('storage/'.$item->gambar_path) : ($item->gambar_path ?: 'https://images.unsplash.com/photo-1595079676339-1534801ad6cf?auto=format&fit=crop&w=400&q=80') }}"
                             alt="{{ $item->nama_artefak }}" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-5">
                        <h3 class="font-serif font-bold text-budaya-900 text-lg leading-snug group-hover:text-budaya-terracotta transition-colors">{{ $item->nama_artefak }}</h3>
                        <div class="flex flex-wrap gap-1 mt-2">
                            <span class="text-[11px] bg-budaya-100 text-budaya-600 px-2 py-0.5 rounded-full font-semibold">{{ $item->kategori }}</span>
                            <span class="text-[11px] text-budaya-400">{{ $item->era_periodisasi }}</span>
                        </div>
                        <p class="text-sm text-budaya-500 mt-3 leading-relaxed">{{ Str::limit($item->deskripsi, 80) }}</p>
                    </div>
                @elseif($type == 'tokoh')
                    <div class="relative overflow-hidden">
                        <img src="{{ $item->gambar_path && !str_starts_with($item->gambar_path, 'http') ? asset('storage/'.$item->gambar_path) : ($item->gambar_path ?: 'https://images.unsplash.com/photo-1595079676339-1534801ad6cf?auto=format&fit=crop&w=400&q=80') }}"
                             alt="{{ $item->nama_tokoh }}" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-5">
                        <h3 class="font-serif font-bold text-budaya-900 text-lg leading-snug group-hover:text-budaya-terracotta transition-colors">{{ $item->nama_tokoh }}</h3>
                        <p class="text-sm text-budaya-accent font-semibold mt-1">{{ $item->gelar }}</p>
                        <p class="text-sm text-budaya-500 mt-2 leading-relaxed">{{ Str::limit($item->biografi, 80) }}</p>
                    </div>
                @elseif($type == 'arsip')
                    <div class="relative overflow-hidden">
                        <img src="{{ $item->gambar_thumbnail && !str_starts_with($item->gambar_thumbnail, 'http') ? asset('storage/'.$item->gambar_thumbnail) : ($item->gambar_thumbnail ?: 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=400&q=80') }}"
                             alt="{{ $item->judul_arsip }}" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-5">
                        <h3 class="font-serif font-bold text-budaya-900 text-lg leading-snug group-hover:text-budaya-terracotta transition-colors">{{ $item->judul_arsip }}</h3>
                        <span class="text-[11px] bg-budaya-100 text-budaya-600 px-2 py-0.5 rounded-full font-semibold">Tahun: {{ $item->tahun_dokumen }}</span>
                        <p class="text-sm text-budaya-500 mt-3 leading-relaxed">{{ Str::limit($item->deskripsi_isi, 80) }}</p>
                    </div>
                @elseif($type == 'lokasi')
                    <div class="relative overflow-hidden">
                        <img src="{{ $item->gambar_path && !str_starts_with($item->gambar_path, 'http') ? asset('storage/'.$item->gambar_path) : ($item->gambar_path ?: 'https://images.unsplash.com/photo-1548625361-185e78342416?auto=format&fit=crop&w=400&q=80') }}"
                             alt="{{ $item->nama_lokasi }}" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-5">
                        <h3 class="font-serif font-bold text-budaya-900 text-lg leading-snug group-hover:text-budaya-terracotta transition-colors">{{ $item->nama_lokasi }}</h3>
                        <span class="text-[11px] text-budaya-400"><i class="fa-solid fa-map-pin text-budaya-terracotta"></i> {{ $item->kabupaten_kota }}, {{ $item->provinsi }}</span>
                        <p class="text-sm text-budaya-500 mt-3 leading-relaxed">{{ Str::limit($item->deskripsi, 80) }}</p>
                    </div>
                @endif
            </div>

            <!-- Modals -->
            @if($type == 'artefak')
                <div id="modal-{{$type}}-{{$idx}}" class="fixed inset-0 z-[10000] items-center justify-center p-4 sm:p-6 text-left" style="display: none;">
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modal-{{$type}}-{{$idx}}')"></div>
                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto transform transition-all cursor-default">
                        <button onclick="closeModal('modal-{{$type}}-{{$idx}}')" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-black/50 hover:bg-black/70 text-white transition-colors z-10">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <img src="{{ $item->gambar_path && !str_starts_with($item->gambar_path, 'http') ? asset('storage/'.$item->gambar_path) : ($item->gambar_path ?: 'https://images.unsplash.com/photo-1595079676339-1534801ad6cf?auto=format&fit=crop&w=400&q=80') }}"
                             alt="{{ $item->nama_artefak }}" class="w-full h-64 sm:h-80 object-cover">
                        <div class="p-6 sm:p-8">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-xs bg-budaya-100 text-budaya-600 px-3 py-1 rounded-full font-semibold">{{ $item->kategori }}</span>
                                <span class="text-xs text-budaya-500 bg-gray-100 px-3 py-1 rounded-full">{{ $item->era_periodisasi }}</span>
                            </div>
                            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-budaya-900 mb-4">{{ $item->nama_artefak }}</h2>
                            <div class="prose prose-sm sm:prose-base text-budaya-600 max-w-none">
                                {!! nl2br(e($item->deskripsi)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($type == 'tokoh')
                <div id="modal-{{$type}}-{{$idx}}" class="fixed inset-0 z-[10000] items-center justify-center p-4 sm:p-6 text-left" style="display: none;">
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modal-{{$type}}-{{$idx}}')"></div>
                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto transform transition-all cursor-default">
                        <button onclick="closeModal('modal-{{$type}}-{{$idx}}')" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-black/50 hover:bg-black/70 text-white transition-colors z-10">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <img src="{{ $item->gambar_path && !str_starts_with($item->gambar_path, 'http') ? asset('storage/'.$item->gambar_path) : ($item->gambar_path ?: 'https://images.unsplash.com/photo-1595079676339-1534801ad6cf?auto=format&fit=crop&w=400&q=80') }}"
                             alt="{{ $item->nama_tokoh }}" class="w-full h-64 sm:h-80 object-cover">
                        <div class="p-6 sm:p-8">
                            <span class="text-xs text-budaya-500 bg-gray-100 px-3 py-1 rounded-full mb-3 inline-block font-semibold">{{ $item->gelar }}</span>
                            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-budaya-900 mb-4">{{ $item->nama_tokoh }}</h2>
                            <div class="prose prose-sm sm:prose-base text-budaya-600 max-w-none">
                                {!! nl2br(e($item->biografi)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($type == 'arsip')
                <div id="modal-{{$type}}-{{$idx}}" class="fixed inset-0 z-[10000] items-center justify-center p-4 sm:p-6 text-left" style="display: none;">
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modal-{{$type}}-{{$idx}}')"></div>
                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto transform transition-all cursor-default">
                        <button onclick="closeModal('modal-{{$type}}-{{$idx}}')" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-black/50 hover:bg-black/70 text-white transition-colors z-10">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <img src="{{ $item->gambar_thumbnail && !str_starts_with($item->gambar_thumbnail, 'http') ? asset('storage/'.$item->gambar_thumbnail) : ($item->gambar_thumbnail ?: 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=400&q=80') }}"
                             alt="{{ $item->judul_arsip }}" class="w-full h-64 sm:h-80 object-cover">
                        <div class="p-6 sm:p-8">
                            <span class="text-xs bg-budaya-100 text-budaya-600 px-3 py-1 rounded-full font-semibold mb-3 inline-block">Tahun: {{ $item->tahun_dokumen }}</span>
                            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-budaya-900 mb-4">{{ $item->judul_arsip }}</h2>
                            <div class="prose prose-sm sm:prose-base text-budaya-600 max-w-none">
                                {!! nl2br(e($item->deskripsi_isi)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($type == 'lokasi')
                <div id="modal-{{$type}}-{{$idx}}" class="fixed inset-0 z-[10000] items-center justify-center p-4 sm:p-6 text-left" style="display: none;">
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modal-{{$type}}-{{$idx}}')"></div>
                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto transform transition-all cursor-default">
                        <button onclick="closeModal('modal-{{$type}}-{{$idx}}')" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-black/50 hover:bg-black/70 text-white transition-colors z-10">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <img src="{{ $item->gambar_path && !str_starts_with($item->gambar_path, 'http') ? asset('storage/'.$item->gambar_path) : ($item->gambar_path ?: 'https://images.unsplash.com/photo-1548625361-185e78342416?auto=format&fit=crop&w=400&q=80') }}"
                             alt="{{ $item->nama_lokasi }}" class="w-full h-64 sm:h-80 object-cover">
                        <div class="p-6 sm:p-8">
                            <span class="text-xs text-budaya-500 bg-gray-100 px-3 py-1 rounded-full mb-3 inline-block"><i class="fa-solid fa-map-pin text-budaya-terracotta mr-1"></i> {{ $item->kabupaten_kota }}, {{ $item->provinsi }}</span>
                            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-budaya-900 mb-4">{{ $item->nama_lokasi }}</h2>
                            <div class="prose prose-sm sm:prose-base text-budaya-600 max-w-none">
                                {!! nl2br(e($item->deskripsi)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @empty
            <div class="col-span-4 text-center py-16">
                <div class="w-20 h-20 mx-auto bg-budaya-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-regular fa-folder-open text-budaya-300 text-3xl"></i>
                </div>
                <p class="font-serif text-xl text-budaya-400">Tidak ada data ditemukan</p>
                <p class="text-sm text-budaya-300 mt-1">Coba ubah kata kunci pencarian Anda.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $data->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Loading
window.addEventListener('load', () => {
    setTimeout(() => {
        const loader = document.getElementById('loading-screen');
        loader.style.opacity = '0';
        setTimeout(() => { loader.style.display = 'none'; }, 700);
    }, 800);
});

// Modal logic
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}
function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}
// Scroll reveal
const ro = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => e.target.classList.add('active'), i * 60);
        }
    });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal-on-scroll').forEach(el => ro.observe(el));
</script>
<style>
.kupiah-zigzag {
    stroke-dasharray: 200; stroke-dashoffset: 200;
    animation: zigzag-draw 1.5s ease-in-out infinite;
}
.kupiah-zigzag-2 {
    stroke-dasharray: 200; stroke-dashoffset: 200;
    animation: zigzag-draw 1.5s ease-in-out 0.3s infinite;
}
.kupiah-top-gem { animation: gem-pulse 1s ease-in-out infinite alternate; }
@keyframes zigzag-draw {
    0% { stroke-dashoffset: 200; } 50% { stroke-dashoffset: 0; } 100% { stroke-dashoffset: -200; }
}
@keyframes gem-pulse {
    0% { r: 3; opacity: 0.6; } 100% { r: 5; opacity: 1; }
}
.kupiah-loader { animation: kupiah-float 2s ease-in-out infinite; }
@keyframes kupiah-float {
    0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); }
}
</style>
@endpush
