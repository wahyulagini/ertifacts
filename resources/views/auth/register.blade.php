<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Tenant — E-RTIFACT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Urbanist:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandCream: '#FCF8F2',
                        brandBrown: '#3D2516',
                        brandGold: '#D4AF37',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Urbanist"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .neo-card { border: 4px solid #3D2516; box-shadow: 8px 8px 0px 0px #3D2516; }
        .neo-btn { border: 4px solid #3D2516; box-shadow: 4px 4px 0px 0px #3D2516; transition: all 0.15s ease; }
        .neo-btn:hover { transform: translate(-2px, -2px); box-shadow: 6px 6px 0px 0px #3D2516; }
        .neo-btn:active { transform: translate(2px, 2px); box-shadow: 2px 2px 0px 0px #3D2516; }
        .neo-input { border: 3px solid #3D2516; transition: all 0.15s ease; }
        .neo-input:focus { outline: none; border-color: #D4AF37; box-shadow: 3px 3px 0px 0px #3D2516; }
        .bg-grid {
            background-size: 30px 30px;
            background-image:
                linear-gradient(to right, rgba(61, 37, 22, 0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(61, 37, 22, 0.04) 1px, transparent 1px);
        }
    </style>
</head>
<body class="bg-[#FCF8F2] text-[#3D2516] font-sans bg-grid min-h-screen flex flex-col justify-center py-12 px-4">

    <div class="max-w-md w-full mx-auto">

        <!-- LOGO -->
        <a href="{{ route('landing') }}" class="block text-center mb-6 hover:opacity-90 transition-opacity">
            <div class="inline-flex w-16 h-16 bg-[#D4AF37] border-4 border-[#3D2516] items-center justify-center rotate-[-4deg] shadow-[4px_4px_0px_0px_#3D2516] mb-4">
                <i class="fa-solid fa-cube text-2xl text-[#3D2516]"></i>
            </div>
            <h1 class="font-display text-4xl font-black uppercase tracking-tight leading-none text-[#3D2516]">E-RTIFACT</h1>
            <p class="text-xs font-semibold uppercase tracking-wider text-[#8B5E3C] mt-2">Daftar Akun Baru</p>
        </a>

        <!-- CARD -->
        <div class="neo-card bg-white overflow-hidden">

            <!-- HEADER -->
            <div class="p-6 bg-[#D4AF37] border-b-4 border-[#3D2516] text-center">
                <h2 class="font-display text-lg font-black uppercase text-[#3D2516]"><i class="fa-solid fa-store mr-2"></i> Pendaftaran Tenant</h2>
                <p class="text-xs font-bold text-[#8B5E3C] mt-1">Daftarkan usaha Anda pada event museum</p>
            </div>

            <!-- ERROR -->
            @if($errors->any())
            <div class="bg-[#FF6B6B]/20 border-b-4 border-[#3D2516] p-4 flex items-start gap-2">
                <span class="text-lg shrink-0">🚨</span>
                <ul class="text-xs font-bold text-[#3D2516] space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- FORM -->
            <form action="{{ route('register.post') }}" method="POST" class="p-8 space-y-4">
                @csrf
                <input type="hidden" name="role" value="Tenant">

                <!-- Nama -->
                <div class="space-y-1">
                    <label class="block text-xs font-display font-black uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                            placeholder="Nama pemilik usaha" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label class="block text-xs font-display font-black uppercase tracking-wider">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                            placeholder="nama@email.com" required>
                    </div>
                </div>

                <!-- No HP -->
                <div class="space-y-1">
                    <label class="block text-xs font-display font-black uppercase tracking-wider">No. WhatsApp <span class="text-gray-400 font-normal normal-case">(opsional)</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fa-solid fa-phone"></i></span>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                            placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label class="block text-xs font-display font-black uppercase tracking-wider">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password"
                            class="neo-input w-full pl-10 pr-10 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                            placeholder="Minimal 8 karakter" required id="pw1">
                        <button type="button" onclick="togglePw('pw1','eye1')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#8B5E3C]">
                            <i id="eye1" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="space-y-1">
                    <label class="block text-xs font-display font-black uppercase tracking-wider">Ulangi Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fa-solid fa-circle-check"></i></span>
                        <input type="password" name="password_confirmation"
                            class="neo-input w-full pl-10 pr-10 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                            placeholder="Ulangi kata sandi" required id="pw2">
                        <button type="button" onclick="togglePw('pw2','eye2')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#8B5E3C]">
                            <i id="eye2" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="space-y-4 border-t-2 border-dashed border-[#3D2516] pt-4 mt-4">
                    <p class="text-xs font-display font-black uppercase tracking-wider text-[#D4AF37]">
                        <i class="fa-solid fa-store mr-1"></i> Data Usaha Tenant
                    </p>

                    <!-- Event -->
                    <div class="space-y-1">
                        <label class="block text-xs font-display font-black uppercase tracking-wider">Event / Acara</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#3D2516]"><i class="fa-solid fa-calendar-star"></i></span>
                            <select name="event_id" required
                                class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold appearance-none">
                                <option value="">— Pilih Event —</option>
                                @if(isset($events) && $events->count() > 0)
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                            {{ $event->judul_event }} ({{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @if(isset($events) && $events->isEmpty())
                            <p class="text-xs text-[#FF6B6B] font-bold mt-1"><i class="fa-solid fa-circle-exclamation"></i> Saat ini tidak ada event yang tersedia.</p>
                        @endif
                    </div>

                    <!-- Nama Usaha -->
                    <div class="space-y-1">
                        <label class="block text-xs font-display font-black uppercase tracking-wider">Nama Usaha</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fa-solid fa-store"></i></span>
                            <input type="text" name="nama_Tenant" value="{{ old('nama_Tenant') }}" required
                                class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                                placeholder="Nama toko / kafe Anda">
                        </div>
                    </div>

                    <!-- Jenis Usaha -->
                    <div class="space-y-1">
                        <label class="block text-xs font-display font-black uppercase tracking-wider">Jenis Usaha</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fa-solid fa-tag"></i></span>
                            <select name="jenis_usaha" required
                                class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold appearance-none">
                                <option value="">— Pilih jenis usaha —</option>
                                @foreach(['Kafe / Restoran','Toko Souvenir','Toko Buku','Pameran Tamu','Jasa Edukasi','Lainnya'] as $j)
                                    <option value="{{ $j }}" {{ old('jenis_usaha') === $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-1">
                        <label class="block text-xs font-display font-black uppercase tracking-wider">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="2"
                            class="neo-input w-full px-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold resize-none"
                            placeholder="Ceritakan singkat usaha Anda...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="bg-[#FEF3C7] border-2 border-[#3D2516] p-3 text-xs font-semibold text-[#3D2516] flex gap-2">
                        <i class="fa-solid fa-circle-info shrink-0 mt-0.5 text-[#D4AF37]"></i>
                        Tarif sewa & persentase pajak ditentukan admin setelah permohonan disetujui. Proses 1×24 jam kerja.
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="neo-btn w-full py-3.5 bg-[#3D2516] text-[#D4AF37] font-display font-black uppercase tracking-widest text-sm mt-2">
                    Daftar Sebagai Tenant <i class="fa-solid fa-arrow-right-to-bracket ml-1.5"></i>
                </button>

                <div class="text-center pt-2">
                    <p class="text-xs font-semibold text-[#8B5E3C]">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="underline font-bold text-[#3D2516] hover:text-[#D4AF37]">Masuk Sekarang</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

<script>
function togglePw(inputId, iconId) {
    const el   = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    el.type    = el.type === 'password' ? 'text' : 'password';
    icon.className = el.type === 'password' ? 'fa-regular fa-eye text-sm' : 'fa-regular fa-eye-slash text-sm';
}
</script>
</body>
</html>