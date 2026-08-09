<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — E-RTIFACT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Urbanist:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: { brandCream:'#FCF8F2', brandBrown:'#3D2516', brandGold:'#D4AF37' },
                fontFamily: { sans:['"Plus Jakarta Sans"','sans-serif'], display:['"Urbanist"','sans-serif'] }
            }}
        }
    </script>
    <style>
        .neo-card  { border:4px solid #3D2516; box-shadow:8px 8px 0 #3D2516; }
        .neo-btn   { border:4px solid #3D2516; box-shadow:4px 4px 0 #3D2516; transition:all .15s; }
        .neo-btn:hover  { transform:translate(-2px,-2px); box-shadow:6px 6px 0 #3D2516; }
        .neo-btn:active { transform:translate(2px,2px);  box-shadow:2px 2px 0 #3D2516; }
        .neo-input { border:3px solid #3D2516; transition:all .15s; }
        .neo-input:focus { outline:none; border-color:#D4AF37; box-shadow:3px 3px 0 #3D2516; }
        .bg-grid {
            background-size:30px 30px;
            background-image:linear-gradient(to right,rgba(61,37,22,.04) 1px,transparent 1px),
                             linear-gradient(to bottom,rgba(61,37,22,.04) 1px,transparent 1px);
        }
        #Tenant-fields { display:none; }
    </style>
</head>
<body class="bg-[#FCF8F2] text-[#3D2516] font-sans bg-grid min-h-screen flex flex-col justify-center py-12 px-4">
<div class="max-w-md w-full mx-auto">

    {{-- LOGO --}}
    <div class="text-center mb-6">
        <div class="inline-flex w-16 h-16 bg-[#D4AF37] border-4 border-[#3D2516] items-center justify-center rotate-[-4deg] shadow-[4px_4px_0_#3D2516] mb-4">
            <i class="fa-solid fa-cube text-2xl text-[#3D2516]"></i>
        </div>
        <h1 class="font-display text-4xl font-black uppercase tracking-tight text-[#3D2516]">E-RTIFACT</h1>
        <p class="text-xs font-semibold uppercase tracking-wider text-[#8B5E3C] mt-1">Museum Digital Lhokseumawe</p>
    </div>

    {{-- CARD --}}
    <div class="neo-card bg-white overflow-hidden">

        {{-- ROLE TABS — value harus 'pengunjung' dan 'Tenant' --}}
        <div class="grid grid-cols-2 border-b-4 border-[#3D2516] text-center font-display font-black text-xs uppercase tracking-wider">
            <button type="button" onclick="selectRole('pengunjung')" id="tab-pengunjung"
                class="role-tab py-4 border-r-4 border-[#3D2516] bg-[#D4AF37] text-[#3D2516] flex flex-col items-center gap-1">
                <i class="fa-solid fa-ticket text-sm"></i> Pengunjung
            </button>
            <button type="button" onclick="selectRole('Tenant')" id="tab-Tenant"
                class="role-tab py-4 bg-[#FAF1E6] text-gray-400 flex flex-col items-center gap-1 hover:text-[#3D2516]">
                <i class="fa-solid fa-store text-sm"></i> nant
            </button>
        </div>

        {{-- HEADER --}}
        <div class="p-5 bg-[#FAF1E6] border-b-2 border-[#3D2516] text-center">
            <h2 id="welcome-text" class="font-display text-lg font-black uppercase text-[#3D2516]">Halo Pengunjung Baru! 👋</h2>
            <p id="welcome-desc" class="text-xs font-semibold text-[#8B5E3C] mt-0.5">Isi formulir untuk mendaftarkan akun kunjungan Anda.</p>
        </div>

        {{-- ERROR --}}
        @if($errors->any())
        <div class="bg-red-50 border-b-4 border-[#3D2516] p-4 flex items-start gap-2">
            <span class="text-lg shrink-0">🚨</span>
            <ul class="text-xs font-bold text-[#3D2516] space-y-0.5">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('register.post') }}" method="POST" class="p-7 space-y-4">
            @csrf

            {{-- ✅ KUNCI: value default 'pengunjung' bukan 'visitor' atau 'Tenant' --}}
            <input type="hidden" name="role" id="selected-role" value="{{ old('role','pengunjung') }}">

            {{-- Nama --}}
            <div>
                <label class="block text-xs font-display font-black uppercase tracking-wider mb-1">Nama Lengkap *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center"><i class="fa-solid fa-user text-sm"></i></span>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                        placeholder="Nama lengkap Anda" required>
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-display font-black uppercase tracking-wider mb-1">Email *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center"><i class="fa-solid fa-envelope text-sm"></i></span>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                        placeholder="nama@email.com" required>
                </div>
            </div>

            {{-- No HP --}}
            <div>
                <label class="block text-xs font-display font-black uppercase tracking-wider mb-1">No. WhatsApp <span class="font-normal normal-case text-gray-400">(opsional)</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center"><i class="fa-solid fa-phone text-sm"></i></span>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                        class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                        placeholder="08xxxxxxxxxx">
                </div>
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-xs font-display font-black uppercase tracking-wider mb-1">Kata Sandi *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center"><i class="fa-solid fa-lock text-sm"></i></span>
                    <input type="password" name="password" id="pw1"
                        class="neo-input w-full pl-10 pr-10 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                        placeholder="Minimal 8 karakter" required>
                    <button type="button" onclick="togglePw('pw1','eye1')"
                        class="absolute inset-y-0 right-3 flex items-center text-[#8B5E3C]">
                        <i id="eye1" class="fa-regular fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi --}}
            <div>
                <label class="block text-xs font-display font-black uppercase tracking-wider mb-1">Ulangi Kata Sandi *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center"><i class="fa-solid fa-circle-check text-sm"></i></span>
                    <input type="password" name="password_confirmation" id="pw2"
                        class="neo-input w-full pl-10 pr-10 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                        placeholder="Ulangi kata sandi" required>
                    <button type="button" onclick="togglePw('pw2','eye2')"
                        class="absolute inset-y-0 right-3 flex items-center text-[#8B5E3C]">
                        <i id="eye2" class="fa-regular fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- DATA Tenant (hidden by default) --}}
            <div id="Tenant-fields" class="space-y-3 border-t-2 border-dashed border-[#3D2516] pt-4">
                <p class="text-xs font-display font-black uppercase tracking-wider text-amber-700 flex items-center gap-1.5">
                    <i class="fa-solid fa-store"></i> Data Usaha Tenant
                </p>

                <div>
                    <label class="block text-xs font-display font-black uppercase tracking-wider mb-1">Nama Usaha *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center"><i class="fa-solid fa-store text-sm"></i></span>
                        <input type="text" name="nama_Tenant" value="{{ old('nama_Tenant') }}"
                            id="nama_Tenant_input"
                            class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold"
                            placeholder="Nama toko / kafe Anda">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-display font-black uppercase tracking-wider mb-1">Jenis Usaha *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center"><i class="fa-solid fa-tag text-sm"></i></span>
                        <select name="jenis_usaha" id="jenis_usaha_input"
                            class="neo-input w-full pl-10 pr-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold appearance-none">
                            <option value="">— Pilih jenis usaha —</option>
                            @foreach(['Kafe / Restoran','Toko Souvenir','Toko Buku','Pameran Tamu','Jasa Edukasi','Lainnya'] as $j)
                            <option value="{{ $j }}" {{ old('jenis_usaha') === $j ? 'selected':'' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-display font-black uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="2"
                        class="neo-input w-full px-4 py-2.5 bg-[#FCF8F2] text-sm font-semibold resize-none"
                        placeholder="Ceritakan singkat usaha Anda...">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="bg-amber-50 border-2 border-amber-200 rounded-lg p-3 flex gap-2 text-xs text-amber-800">
                    <i class="fa-solid fa-circle-info mt-0.5 shrink-0 text-amber-500"></i>
                    Tarif sewa & persentase pajak ditentukan admin setelah permohonan disetujui. Proses 1×24 jam kerja.
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" id="submit-btn"
                class="neo-btn w-full py-3.5 bg-[#D4AF37] text-[#3D2516] font-display font-black uppercase tracking-widest text-sm mt-2">
                Daftar Sebagai Pengunjung <i class="fa-solid fa-arrow-right-to-bracket ml-1.5"></i>
            </button>

            <p class="text-center text-xs font-semibold text-[#8B5E3C]">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="underline font-bold text-[#3D2516] hover:text-[#D4AF37]">Masuk Sekarang</a>
            </p>
        </form>
    </div>
</div>

<script>
// ✅ role value: 'pengunjung' atau 'Tenant' — sesuai enum di DB
function selectRole(role) {
    document.getElementById('selected-role').value = role;

    document.querySelectorAll('.role-tab').forEach(t => {
        t.classList.remove('bg-[#D4AF37]','text-[#3D2516]');
        t.classList.add('bg-[#FAF1E6]','text-gray-400');
    });
    const active = document.getElementById('tab-' + role);
    active.classList.remove('bg-[#FAF1E6]','text-gray-400');
    active.classList.add('bg-[#D4AF37]','text-[#3D2516]');

    const TenantFields = document.getElementById('Tenant-fields');
    const namaTenant  = document.getElementById('nama_Tenant_input');
    const jenisTenant = document.getElementById('jenis_usaha_input');
    const btn         = document.getElementById('submit-btn');
    const wText       = document.getElementById('welcome-text');
    const wDesc       = document.getElementById('welcome-desc');

    if (role === 'Tenant') {
        TenantFields.style.display = 'block';
        namaTenant.required  = true;
        jenisTenant.required = true;
        wText.innerHTML = 'Mari BerTenant! ☕';
        wDesc.innerHTML = 'Daftarkan usaha Anda sebagai Tenant di dalam museum.';
        btn.innerHTML   = 'Daftar Sebagai Tenant <i class="fa-solid fa-shop ml-1.5"></i>';
    } else {
        TenantFields.style.display = 'none';
        namaTenant.required  = false;
        jenisTenant.required = false;
        wText.innerHTML = 'Halo Pengunjung Baru! 👋';
        wDesc.innerHTML = 'Isi formulir untuk mendaftarkan akun kunjungan Anda.';
        btn.innerHTML   = 'Daftar Sebagai Pengunjung <i class="fa-solid fa-arrow-right-to-bracket ml-1.5"></i>';
    }
}

function togglePw(id, iconId) {
    const el = document.getElementById(id);
    const ic = document.getElementById(iconId);
    el.type = el.type === 'password' ? 'text' : 'password';
    ic.className = el.type === 'password' ? 'fa-regular fa-eye text-sm' : 'fa-regular fa-eye-slash text-sm';
}

document.addEventListener('DOMContentLoaded', () => {
    selectRole('{{ old("role","pengunjung") }}');
});
</script>
</body>
</html>