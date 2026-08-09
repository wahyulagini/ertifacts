<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — E-RTIFACT</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:   '#FAF7F2',
                            100:  '#F2EBE0',
                            200:  '#E0CBAF',
                            300:  '#C9A87C',
                            400:  '#B08850',
                            500:  '#8B6330',
                            600:  '#6B4A22',
                            700:  '#4E3318',
                            800:  '#321F0E',
                            900:  '#1A0F06',
                            gold: '#C9963A',
                            rust: '#B54F2A',
                        }
                    },
                    fontFamily: {
                        sans:  ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar       { width: 5px; }
        ::-webkit-scrollbar-track { background: #F2EBE0; }
        ::-webkit-scrollbar-thumb { background: #C9A87C; border-radius: 99px; }

        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 10px;
            font-size: 0.8rem; font-weight: 500; color: #C9A87C;
            text-decoration: none; transition: all .18s;
        }
        .nav-link:hover { background: rgba(255,255,255,.08); color: #FAF7F2; }
        .nav-link.active { background: rgba(201,150,58,.2); color: #FAF7F2; font-weight: 700; }
        .nav-link i { width: 16px; text-align: center; font-size: 0.8rem; opacity: .85; }
        .nav-section { font-size: .65rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #6B4A22; padding: 14px 12px 4px; }

        .stat-card {
            background: white; border-radius: 14px;
            border: 1px solid #E0CBAF; padding: 18px 20px;
            transition: all .2s;
        }
        .stat-card:hover { box-shadow: 0 6px 20px rgba(139,99,48,.09); transform: translateY(-2px); }

        .table-th { font-size: .7rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: #B08850; padding: 10px 14px; background: #FAF7F2; }
        .table-td { font-size: .82rem; padding: 11px 14px; border-top: 1px solid #F2EBE0; color: #4E3318; }

        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:99px; font-size:.68rem; font-weight:700; }
        .badge-yellow  { background:#FEF9C3; color:#854D0E; }
        .badge-green   { background:#DCFCE7; color:#166534; }
        .badge-red     { background:#FEE2E2; color:#991B1B; }
        .badge-blue    { background:#DBEAFE; color:#1E40AF; }
        .badge-gray    { background:#F3F4F6; color:#374151; }

        .btn-primary {
            display:inline-flex; align-items:center; gap:6px;
            background: linear-gradient(135deg,#C9963A,#B08850);
            color:white; padding:8px 16px; border-radius:10px;
            font-size:.82rem; font-weight:700; border:none; cursor:pointer;
            transition:all .2s; text-decoration:none;
        }
        .btn-primary:hover { opacity:.9; box-shadow:0 4px 14px rgba(201,150,58,.3); transform:translateY(-1px); }

        .btn-outline {
            display:inline-flex; align-items:center; gap:6px;
            background: transparent; color:#8B6330;
            border: 1.5px solid #E0CBAF; padding:7px 14px; border-radius:10px;
            font-size:.82rem; font-weight:600; cursor:pointer; transition:all .2s; text-decoration:none;
        }
        .btn-outline:hover { background:#F2EBE0; border-color:#C9A87C; }
    </style>

    @stack('styles')
</head>
<body class="bg-brand-50 font-sans text-brand-800 antialiased">
<div class="flex min-h-screen">

    {{-- ====== SIDEBAR ====== --}}
    <aside id="sidebar" class="w-56 shrink-0 bg-brand-800 flex flex-col min-h-screen sticky top-0 z-40 transition-all duration-300">

        {{-- Brand --}}
        <a href="{{ route('landing') }}" class="block px-4 py-5 border-b border-brand-700/60 hover:bg-brand-700/30 transition-colors">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-brand-gold rounded-lg flex items-center justify-center shadow-lg shrink-0">
                    <i class="fa-solid fa-cube text-brand-900 text-xs"></i>
                </div>
                <div>
                    <p class="font-serif text-base font-bold text-white leading-none">E-RTIFACT</p>
                    <p class="text-[9px] text-brand-300 tracking-widest uppercase">Museum Digital</p>
                </div>
            </div>
        </a>

        {{-- User chip --}}
        <div class="px-3 py-3 border-b border-brand-700/60">
            <div class="flex items-center gap-2.5 bg-brand-700/40 rounded-xl px-2.5 py-2">
                <div class="w-7 h-7 rounded-full bg-brand-gold/30 flex items-center justify-center text-brand-gold font-bold text-xs shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white text-xs font-semibold truncate leading-tight">{{ auth()->user()->name ?? 'Pengguna' }}</p>
                    <p class="text-brand-300 text-[10px] capitalize">{{ auth()->user()->role ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-2 py-2 overflow-y-auto space-y-0.5">
            @yield('sidebar-nav')
        </nav>

        {{-- Logout --}}
        <div class="px-2 py-3 border-t border-brand-700/60">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-full hover:bg-red-500/20 hover:text-red-300">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ====== KONTEN UTAMA ====== --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Topbar --}}
        <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-brand-100 px-6 h-14 flex items-center justify-between gap-4">
            <div class="min-w-0 flex items-center gap-3">
                <button onclick="window.history.back()" title="Kembali ke halaman sebelumnya"
                    class="w-8 h-8 rounded-lg bg-brand-50 hover:bg-brand-100 border border-brand-200 text-brand-600 flex items-center justify-center transition shrink-0">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </button>
                <div class="min-w-0">
                    <h1 class="font-serif text-base font-bold text-brand-800 truncate">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-subtitle')
                        <p class="text-[11px] text-brand-400 truncate">@yield('page-subtitle')</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button onclick="window.history.back()"
                    class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-50 hover:bg-brand-100 border border-brand-200 text-brand-700 text-xs font-semibold transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
                </button>
                <button class="relative w-8 h-8 rounded-lg bg-brand-50 border border-brand-200 flex items-center justify-center text-brand-400 hover:bg-brand-100 transition-colors">
                    <i class="fa-regular fa-bell text-xs"></i>
                    <span class="absolute top-1 right-1 w-1.5 h-1.5 bg-brand-rust rounded-full ring-1 ring-white"></span>
                </button>
                <div class="hidden sm:block text-right">
                    <p class="text-[11px] font-semibold text-brand-600">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </header>

        {{-- Flash messages --}}
        <div class="px-6 pt-4">
            @if(session('success'))
            <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium mb-2">
                <i class="fa-solid fa-circle-check shrink-0"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium mb-2">
                <i class="fa-solid fa-circle-xmark shrink-0"></i> {{ session('error') }}
            </div>
            @endif
        </div>

        {{-- Main --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
