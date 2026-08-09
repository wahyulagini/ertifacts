<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-RTIFACT — Sistem Informasi Kearsipan Budaya Lhokseumawe')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        budaya: {
                            50: '#FAF6F0', 100: '#F4ECE1', 200: '#E6D5C3',
                            300: '#D2B48C', 400: '#C19A6B', 500: '#8B5A2B',
                            600: '#6E4720', 700: '#4A2E14', 800: '#2F1E0D',
                            900: '#1D1308',
                            accent: '#D4AF37',
                            terracotta: '#C05C33'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .cultural-bg {
            background-color: #FAF6F0;
            background-image: radial-gradient(#8b5a2b22 0.5px, transparent 0.5px),
                              radial-gradient(#8b5a2b22 0.5px, #faf6f0 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }
        .reveal-on-scroll { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.25,1,0.5,1); }
        .reveal-on-scroll.active { opacity: 1; transform: translateY(0); }
        .pulse-spot { box-shadow: 0 0 0 0 rgba(212,175,55,0.7); animation: pulse 2s infinite; }
        @keyframes pulse {
            0%   { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(212,175,55,0.7); }
            70%  { transform: scale(1);    box-shadow: 0 0 0 10px rgba(212,175,55,0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(212,175,55,0); }
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #F4ECE1; }
        ::-webkit-scrollbar-thumb { background: #8B5A2B; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #6E4720; }

        /* ============================================================
           FIX: 3D Canvas — pastikan container punya fixed height dan
           canvas Three.js mengisi penuh tanpa ketimpa overlay element
           ============================================================ */
        #visualizer-wrapper {
            position: relative;
            width: 100%;
            height: 500px;    /* tinggi tetap, tidak bergantung konten child */
            border-radius: 1.5rem;
            overflow: hidden;
            background: #F4ECE1;
            border: 1px solid #E6D5C3;
        }
        #three-canvas-container {
            position: absolute;
            inset: 0;          /* mengisi 100% parent */
            width: 100%;
            height: 100%;
            cursor: grab;
        }
        #three-canvas-container:active { cursor: grabbing; }
        #three-canvas-container canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }
        /* Overlay elemen (instruksi & info panel) berada di ATAS canvas */
        .canvas-overlay {
            position: absolute;
            z-index: 10;
            pointer-events: none;   /* biarkan klik tembus ke canvas */
        }
        .canvas-overlay button,
        .canvas-overlay a { pointer-events: auto; } /* kecuali tombol */
    </style>
</head>
<body class="bg-budaya-50 font-sans text-budaya-800 antialiased selection:bg-budaya-200 selection:text-budaya-900">

    {{-- ====== NAVBAR ====== --}}
    <header class="sticky top-0 z-50 bg-budaya-50/80 backdrop-blur-md border-b border-budaya-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center space-x-3 hover:opacity-90 transition-opacity">
                <div class="bg-budaya-700 text-budaya-accent p-2.5 rounded-xl shadow-lg flex items-center justify-center hover:rotate-6 transition-transform duration-300">
                    <i class="fa-solid fa-cube text-xl"></i>
                </div>
                <div>
                    <span class="font-serif text-2xl font-bold tracking-tight text-budaya-800">
                        E-<span class="text-budaya-terracotta">RTIFACT</span>
                    </span>
                    <p class="text-[10px] tracking-widest uppercase font-semibold text-budaya-400">Lhokseumawe Digital Heritage</p>
                </div>
            </a>
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('landing') }}" class="text-sm font-medium text-budaya-600 hover:text-budaya-terracotta transition-colors">Beranda</a>
                <a href="{{ route('landing') }}#event" class="text-sm font-medium text-budaya-600 hover:text-budaya-terracotta transition-colors">Event</a>
                <a href="{{ route('landing.koleksi') }}" class="text-sm font-medium text-budaya-600 hover:text-budaya-terracotta transition-colors">Koleksi</a>
                <a href="{{ route('buku-tamu.create') }}" class="text-sm font-medium text-budaya-600 hover:text-budaya-terracotta transition-colors">Tiket & Buku Tamu</a>
                <a href="{{ route('bantuan-publik.index') }}" class="text-sm font-medium text-budaya-600 hover:text-budaya-terracotta transition-colors">Bantuan & FAQ</a>
            </nav>
            @auth
            <a href="{{ route('home') }}" class="bg-budaya-700 hover:bg-budaya-600 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                Dashboard Saya
            </a>
            @else
            <a href="{{ route('login') }}" class="bg-budaya-700 hover:bg-budaya-600 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                Masuk / Login
            </a>
            @endauth
        </div>
    </header>

    @yield('content')

    {{-- ====== FOOTER ====== --}}
    <footer class="bg-budaya-900 text-budaya-200 pt-16 pb-8 border-t border-budaya-800 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.02] bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-12">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-12 border-b border-budaya-800">
                <div class="md:col-span-5 space-y-4">
                    <a href="{{ route('landing') }}" class="flex items-center space-x-3 hover:opacity-90 transition-opacity">
                        <div class="bg-budaya-accent text-budaya-900 p-2.5 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-cube text-xl"></i>
                        </div>
                        <span class="font-serif text-2xl font-bold tracking-tight text-white">E-<span class="text-budaya-accent">RTIFACT</span></span>
                    </a>
                    <p class="text-sm text-budaya-400 leading-relaxed max-w-sm">
                        E-RTIFACT berkomitmen melestarikan sejarah Lhokseumawe & Aceh melalui teknologi web modern. Sistem informasi kearsipan budaya berbasis Laravel.
                    </p>
                </div>
                <div class="md:col-span-3 space-y-3">
                    <h4 class="font-bold text-sm text-white uppercase tracking-wider">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-budaya-400">
                        <li><a href="{{ route('landing') }}#event" class="hover:text-budaya-accent transition-colors">Event</a></li>
                        <li><a href="{{ route('landing.koleksi') }}" class="hover:text-budaya-accent transition-colors">Katalog Koleksi</a></li>
                        <li><a href="{{ route('buku-tamu.create') }}" class="hover:text-budaya-accent transition-colors">Buku Tamu</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-budaya-accent transition-colors">Pendaftaran Tenant</a></li>
                    </ul>
                </div>
                <div class="md:col-span-4 space-y-3">
                    <h4 class="font-bold text-sm text-white uppercase tracking-wider">Amanah Pelestarian</h4>
                    <p class="text-sm italic text-budaya-400 leading-relaxed">
                        "Bangsa yang besar adalah bangsa yang menghargai sejarahnya. E-RTIFACT hadir menyatukan nilai sejarah klasik dengan teknologi modern masa kini."
                    </p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-budaya-500">
                <p>&copy; {{ date('Y') }} E-RTIFACT Lhokseumawe. Dikembangkan dengan dedikasi budaya & teknologi Laravel.</p>
            </div>
        </div>
    </footer>

    {{-- Scroll reveal script --}}
    <script>
        const reveals = document.querySelectorAll('.reveal-on-scroll');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('active'); });
        }, { threshold: 0.1 });
        reveals.forEach(el => observer.observe(el));
    </script>

    @stack('scripts')
</body>
</html>
