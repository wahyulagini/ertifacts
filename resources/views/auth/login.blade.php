<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — E-RTIFACT Museum Digital</title>

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
        body { min-height: 100vh; }

        /* Batik-inspired dot pattern */
        .batik-bg {
            background-color: #321F0E;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(201,150,58,0.12) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(181,79,42,0.10) 0%, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23C9963A' fill-opacity='0.06'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='0' cy='0' r='1'/%3E%3Ccircle cx='40' cy='0' r='1'/%3E%3Ccircle cx='0' cy='40' r='1'/%3E%3Ccircle cx='40' cy='40' r='1'/%3E%3C/g%3E%3C/svg%3E");
        }

        .input-field {
            width: 100%;
            padding: 11px 16px 11px 42px;
            background: #FAF7F2;
            border: 1.5px solid #E0CBAF;
            border-radius: 12px;
            font-size: 0.875rem;
            color: #321F0E;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #C9963A;
            box-shadow: 0 0 0 3px rgba(201,150,58,0.15);
        }
        .input-field::placeholder { color: #C9A87C; }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #C9963A, #B08850);
            color: white;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.02em;
            border: none;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #B08850, #8B6330);
            box-shadow: 0 6px 20px rgba(201,150,58,0.35);
            transform: translateY(-1px);
        }
        .btn-login:active { transform: translateY(0); }

        .ornament-line {
            display: flex; align-items: center; gap: 12px;
        }
        .ornament-line::before, .ornament-line::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #E0CBAF, transparent);
        }
    </style>
</head>
<body class="font-sans">
<div class="min-h-screen flex">

    {{-- ===== PANEL KIRI — Branding ===== --}}
    <div class="hidden lg:flex lg:w-1/2 batik-bg flex-col justify-between p-12 relative overflow-hidden">

        {{-- Decorative circles --}}
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-brand-gold/5 -translate-y-1/2 translate-x-1/2 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full bg-brand-rust/10 translate-y-1/3 -translate-x-1/3 blur-2xl pointer-events-none"></div>

        {{-- Logo --}}
        <a href="{{ route('landing') }}" class="flex items-center gap-3 relative z-10 hover:opacity-90 transition-opacity">
            <div class="w-10 h-10 bg-brand-gold rounded-xl flex items-center justify-center shadow-xl">
                <i class="fa-solid fa-cube text-brand-900 text-base"></i>
            </div>
            <div>
                <span class="font-serif text-xl font-bold text-white leading-none block">E-RTIFACT</span>
                <span class="text-[10px] text-brand-300 tracking-widest uppercase">Museum Digital Lhokseumawe</span>
            </div>
        </a>

        {{-- Center content --}}
        <div class="relative z-10 space-y-8">
            <div class="space-y-4">
                <span class="text-brand-gold text-xs font-bold tracking-widest uppercase">
                    ✦ Platform Pelestarian Budaya Aceh
                </span>
                <h2 class="font-serif text-4xl font-bold text-white leading-tight">
                    Jelajahi Warisan<br>
                    <em class="text-brand-gold not-italic">Lhokseumawe</em><br>
                    Secara Digital.
                </h2>
                <p class="text-brand-300 text-sm leading-relaxed max-w-sm">
                    Platform terintegrasi untuk mengelola koleksi museum, reservasi kunjungan, ketenantan tenant, dan keuangan operasional museum.
                </p>
            </div>

            {{-- Feature pills --}}
            <div class="flex flex-wrap gap-2">
                @foreach([
                    ['fa-cube',        'Koleksi 3D'],
                    ['fa-calendar',    'Reservasi'],
                    ['fa-handshake',   'nant'],
                    ['fa-chart-line',  'Keuangan'],
                    ['fa-map-pin',     'Peta Lokasi'],
                ] as [$icon, $label])
                <span class="inline-flex items-center gap-1.5 bg-white/10 text-brand-200 text-xs px-3 py-1.5 rounded-full border border-white/10">
                    <i class="fa-solid {{ $icon }} text-brand-gold text-[10px]"></i>
                    {{ $label }}
                </span>
                @endforeach
            </div>
        </div>

        {{-- Footer quote --}}
        <div class="relative z-10">
            <p class="text-brand-400 text-xs italic leading-relaxed">
                "Bangsa yang besar adalah bangsa yang menghargai sejarahnya."<br>
                <span class="text-brand-300 not-italic font-semibold">— Ir. Soekarno</span>
            </p>
        </div>
    </div>

    {{-- ===== PANEL KANAN — Form Login ===== --}}
    <div class="w-full lg:w-1/2 bg-brand-50 flex flex-col justify-center px-8 sm:px-16 lg:px-20 py-12">

        {{-- Mobile logo --}}
        <a href="{{ route('landing') }}" class="flex items-center gap-3 mb-10 lg:hidden hover:opacity-90 transition-opacity">
            <div class="w-9 h-9 bg-brand-gold rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-cube text-brand-900 text-sm"></i>
            </div>
            <span class="font-serif text-lg font-bold text-brand-800">E-RTIFACT</span>
        </a>

        <div class="max-w-sm w-full mx-auto space-y-8">

            {{-- Heading --}}
            <div class="space-y-2">
                <h1 class="font-serif text-3xl font-bold text-brand-900">Selamat Datang</h1>
                <p class="text-brand-400 text-sm">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            {{-- Error / success alerts --}}
            @if ($errors->any())
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    <i class="fa-solid fa-circle-xmark mt-0.5 shrink-0"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                    <i class="fa-solid fa-circle-check shrink-0"></i>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-brand-300 text-sm pointer-events-none"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="input-field"
                            placeholder="nama@email.com"
                            required
                            autofocus
                            autocomplete="email"
                        >
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative">
                        <i class="fa-regular fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-brand-300 text-sm pointer-events-none"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="input-field pr-10"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        >
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-brand-300 hover:text-brand-500 transition-colors"
                        >
                            <i id="eye-icon" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="w-4 h-4 rounded accent-brand-gold cursor-pointer"
                    >
                    <label for="remember" class="text-sm text-brand-500 cursor-pointer select-none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>
                    Masuk Sekarang
                </button>
            </form>

            {{-- Divider --}}
            <div class="ornament-line">
                <span class="text-xs text-brand-300 font-medium whitespace-nowrap">Belum punya akun?</span>
            </div>

            {{-- Register link --}}
            <a href="{{ route('register') }}"
               class="flex items-center justify-center gap-2 w-full py-3 rounded-xl border-2 border-brand-200 text-brand-600 text-sm font-semibold hover:bg-brand-100 hover:border-brand-300 transition-all">
                <i class="fa-solid fa-user-plus text-brand-gold"></i>
                Daftar Akun Baru
            </a>
        </div>
    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa-regular fa-eye-slash text-sm';
    } else {
        input.type = 'password';
        icon.className = 'fa-regular fa-eye text-sm';
    }
}
</script>
</body>
</html>
