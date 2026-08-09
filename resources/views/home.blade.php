<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Fonts: Urbanist & Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Urbanist:wght@700;800;900&display=swap" rel="stylesheet">

<!-- FontAwesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    display: ['"Urbanist"', 'sans-serif'],
                }
            }
        }
    }
</script>

<style>
    .neo-card {
        border: 4px solid #3D2516;
        box-shadow: 6px 6px 0px 0px #3D2516;
        transition: all 0.2s ease;
    }
    .neo-card:hover {
        transform: translate(-2px, -2px);
        box-shadow: 8px 8px 0px 0px #3D2516;
    }
    .neo-btn {
        border: 4px solid #3D2516;
        box-shadow: 4px 4px 0px 0px #3D2516;
        transition: all 0.15s ease;
    }
    .neo-btn:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0px 0px #3D2516;
    }
    .neo-btn:active {
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0px 0px #3D2516;
    }
    .neo-input {
        border: 3px solid #3D2516;
        transition: all 0.15s ease;
    }
    .neo-input:focus {
        outline: none;
        border-color: #D4AF37;
        box-shadow: 3px 3px 0px 0px #3D2516;
    }
    .bg-grid {
        background-size: 30px 30px;
        background-image: 
            linear-gradient(to right, rgba(61, 37, 22, 0.04) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(61, 37, 22, 0.04) 1px, transparent 1px);
    }
</style>


<!-- HEADER BRANDING -->
<header class="max-w-7xl mx-auto px-4 pt-8 pb-4">
    <div class="neo-card bg-[#F5EBE0] p-6 flex flex-col md:flex-row items-center justify-between gap-6">
        
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-[#D4AF37] border-4 border-[#3D2516] flex items-center justify-center shrink-0 rotate-[-3deg] shadow-[3px_3px_0px_0px_#3D2516]">
                <svg viewBox="0 0 100 100" class="w-10 h-10 text-[#3D2516]" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M25,90 L25,30 L40,15 L40,90" />
                    <path d="M75,90 L75,30 L60,15 L60,90" />
                    <path d="M40,55 L60,55" />
                    <path d="M15,90 L85,90" />
                    <rect x="44" y="30" width="12" height="12" fill="currentColor" />
                </svg>
            </div>
            <div>
                <h1 class="font-display text-2xl md:text-3xl font-extrabold tracking-tight leading-none uppercase">
                    MUSEUM & PERPUSTAKAAN <span class="bg-[#D4AF37] px-2 py-0.5 border-2 border-[#3D2516] inline-block rotate-[1deg]">NUSANTARA</span>
                </h1>
                <p class="text-xs md:text-sm font-semibold tracking-wider uppercase mt-1.5 text-[#8B5E3C]">
                    <i class="fa-solid fa-hotel text-[#D4AF37]"></i> Portal Manajemen Terpadu • E-Rtifact Sub-System
                </p>
            </div>
        </div>

        <!-- Role Simulator Tab (Sangat berguna untuk pengujian tugas kuliah!) -->
        <div class="flex items-center gap-2 bg-[#FAF1E6] p-2 border-4 border-[#3D2516] shadow-[3px_3px_0px_0px_#3D2516]">
            <span class="text-xs font-black uppercase px-2">Akses Simulator:</span>
            <button onclick="switchRole('visitor')" id="btn-role-visitor" class="px-3 py-1 bg-[#D4AF37] border-2 border-[#3D2516] font-display font-extrabold text-xs uppercase">Visitor</button>
            <button onclick="switchRole('tenant')" id="btn-role-tenant" class="px-3 py-1 bg-white border-2 border-[#3D2516] font-display font-extrabold text-xs uppercase">tenant</button>
            <button onclick="switchRole('admin')" id="btn-role-admin" class="px-3 py-1 bg-white border-2 border-[#3D2516] font-display font-extrabold text-xs uppercase">Admin</button>
        </div>

    </div>
</header>

<!-- MAIN DASHBOARD CONTENT -->
<main class="max-w-7xl mx-auto px-4 mt-6">

    <!-- Top Notification Status -->
    @if(session('success'))
        <div class="neo-card bg-[#D4AF37]/20 border-l-8 border-l-[#D4AF37] p-4 mb-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#D4AF37] flex items-center justify-center text-[#3D2516] font-bold border-2 border-[#3D2516] shrink-0">
                    ✨
                </div>
                <div>
                    <h4 class="font-display font-bold uppercase text-[#3D2516] text-sm">Transaksi Berhasil!</h4>
                    <p class="text-[#3D2516] text-xs font-semibold">{{ session('success') }}</p>
                </div>
            </div>
            <form action="{{ route('museum.reset') }}" method="POST">
                @csrf
                <button class="text-xs font-bold uppercase underline text-red-600 hover:text-red-800">Reset Simulasi</button>
            </form>
        </div>
    @endif

    <!-- ==================== PART 1: VISITOR VIEW ==================== -->
    <div id="view-visitor" class="space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Card 1: Reservasi Tiket Kunjungan -->
            <div class="neo-card bg-white p-6 flex flex-col justify-between">
                <div>
                    <span class="bg-[#3D2516] text-white font-display font-black text-xs uppercase px-2 py-1 inline-block mb-3">Reservasi Tiket</span>
                    <h3 class="font-display text-2xl font-black uppercase mb-2">Kunjungan Museum</h3>
                    <p class="text-xs text-[#8B5E3C] font-semibold mb-6">Pesan tiket reservasi kunjungan fisik ke kompleks pameran.</p>
                    
                    <form action="{{ route('ticket.reserve') }}" method="POST" class="space-y-4">
                        @csrf
                        <!-- Anggap User ID 2 adalah Akun Pengunjung -->
                        <input type="hidden" name="user_id" value="2">
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Tanggal Rencana Datang</label>
                            <input type="date" name="tanggal_kunjungan" class="neo-input w-full p-2.5 bg-[#FCF8F2] text-xs font-semibold" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Jumlah Anggota Rombongan</label>
                            <input type="number" name="jumlah_tiket" min="1" max="10" placeholder="Contoh: 3 orang" class="neo-input w-full p-2.5 bg-[#FCF8F2] text-xs font-semibold" required>
                        </div>
                        <button type="submit" class="neo-btn w-full py-3 bg-[#D4AF37] font-display font-black text-xs uppercase tracking-wider">
                            Booking Tiket Kunjungan <i class="fa-solid fa-ticket ml-1"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card 2: Pengajuan Peminjaman Buku Perpustakaan -->
            <div class="neo-card bg-white p-6 flex flex-col justify-between">
                <div>
                    <span class="bg-[#3D2516] text-white font-display font-black text-xs uppercase px-2 py-1 inline-block mb-3">Pustaka Kuno</span>
                    <h3 class="font-display text-2xl font-black uppercase mb-2">Pinjam Buku & Arsip</h3>
                    <p class="text-xs text-[#8B5E3C] font-semibold mb-6">Pilih salah satu koleksi buku sejarah nusantara untuk dipinjam.</p>
                    
                    <form action="{{ route('book.loan') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="user_id" value="2">
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Pilih Buku / Arsip</label>
                            <select name="location_id" class="neo-input w-full p-2.5 bg-[#FCF8F2] text-xs font-semibold" required>
                                <option value="" disabled selected>Pilih Buku Koleksi</option>
                                @foreach($collections as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_lokasi }} ({{ $item->kecamatan }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold uppercase mb-1">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" class="neo-input w-full p-2 bg-[#FCF8F2] text-xs font-semibold" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase mb-1">Batas Kembali</label>
                                <input type="date" name="tanggal_kembali" class="neo-input w-full p-2 bg-[#FCF8F2] text-xs font-semibold" required>
                            </div>
                        </div>
                        <button type="submit" class="neo-btn w-full py-3 bg-[#D4AF37] font-display font-black text-xs uppercase tracking-wider">
                            Ajukan Pinjam Pustaka <i class="fa-solid fa-book-reader ml-1"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card 3: Info tenant / UMKM tenant Kompleks Museum -->
            <div class="neo-card bg-[#3D2516] text-white p-6 flex flex-col justify-between">
                <div>
                    <span class="bg-[#D4AF37] text-[#3D2516] font-display font-black text-xs uppercase px-2 py-1 inline-block mb-3">tenant Museum</span>
                    <h3 class="font-display text-2xl font-black uppercase text-[#D4AF37] mb-2">tenant & Kuliner</h3>
                    <p class="text-xs text-gray-300 font-semibold mb-6">Nikmati kuliner khas nusantara dan souvenir dari stan UMKM binaan kami.</p>
                    
                    <div class="space-y-3">
                        @forelse($tenants as $ten)
                            <div class="bg-white/10 p-3 border-2 border-white/20 flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-sm text-white">{{ $ten->nama_tenant }}</h4>
                                    <p class="text-[10px] text-gray-300 uppercase font-bold">Kategori: {{ $ten->jenis_usaha }}</p>
                                </div>
                                <span class="text-xs bg-[#D4AF37] text-black font-black px-2 py-0.5 border border-black rotate-[-1deg]">
                                    PAJAK 10%
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic">Belum ada nant yang terdaftar.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <!-- E-Rtifact / Exhibition List -->
        <div class="neo-card bg-white p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-display text-2xl font-black uppercase">E-Rtifact — Galeri Koleksi Cagar Budaya</h3>
                    <p class="text-xs text-[#8B5E3C] font-semibold">Tabel digitalisasi seluruh artefak purbakala dan buku sejarah museum.</p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#FAF1E6] border-b-4 border-[#3D2516] text-xs font-black uppercase">
                            <th class="p-3 w-12 text-center border-r-2 border-[#3D2516]">No</th>
                            <th class="p-3 border-r-2 border-[#3D2516]">Nama Koleksi Artefak</th>
                            <th class="p-3 w-48 border-r-2 border-[#3D2516]">Kategori / Provinsi</th>
                            <th class="p-3">Riwayat & Catatan Sejarah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#3D2516] text-xs font-semibold">
                        @forelse($collections as $index => $item)
                            <tr class="hover:bg-[#FCF8F2]">
                                <td class="p-3 text-center border-r-2 border-[#3D2516]">{{ $index + 1 }}</td>
                                <td class="p-3 border-r-2 border-[#3D2516]">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-landmark text-[#D4AF37] text-sm"></i>
                                        <span class="font-bold text-[#3D2516] text-sm">{{ $item->nama_lokasi }}</span>
                                    </div>
                                </td>
                                <td class="p-3 border-r-2 border-[#3D2516]">
                                    <span class="bg-[#D4AF37]/30 border border-[#3D2516] px-2 py-0.5 text-[10px] font-black uppercase">
                                        {{ $item->kecamatan }}
                                    </span>
                                </td>
                                <td class="p-3 text-gray-600 line-clamp-2 leading-relaxed">
                                    {{ $item->deskripsi ?? 'Informasi arsip belum dilengkapi.' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400 italic">Database E-Rtifact kosong. Gunakan fitur Admin untuk menambahkan koleksi!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== PART 2: tenant VIEW ==================== -->
    <div id="view-tenant" class="hidden space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Input Pendapatan Harian tenant -->
            <div class="neo-card bg-white p-6 lg:col-span-1">
                <span class="bg-[#3D2516] text-white font-display font-black text-xs uppercase px-2 py-1 inline-block mb-3">Laporan Omset</span>
                <h3 class="font-display text-2xl font-black uppercase mb-2">Input Kas Harian</h3>
                <p class="text-xs text-[#8B5E3C] font-semibold mb-6">Isi omset kotor penjualan harian kamu untuk dihitung pajaknya secara otomatis.</p>
                
                <form action="{{ route('tenant.sales') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1">Pilih Lapak tenant Kamu</label>
                        <select name="tenant_id" class="neo-input w-full p-2.5 bg-[#FCF8F2] text-xs font-semibold" required>
                            @foreach($tenants as $ten)
                                <option value="{{ $ten->id }}">{{ $ten->nama_tenant }} (Milik: {{ $ten->owner_name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1">Total Omset Kotor Hari Ini (Rp)</label>
                        <input type="number" name="total_omset" min="1000" placeholder="Contoh: 150000" class="neo-input w-full p-2.5 bg-[#FCF8F2] text-xs font-semibold" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" class="neo-input w-full p-2.5 bg-[#FCF8F2] text-xs font-semibold" required>
                    </div>
                    <button type="submit" class="neo-btn w-full py-3 bg-[#D4AF37] font-display font-black text-xs uppercase tracking-wider">
                        Setor & Hitung Pajak <i class="fa-solid fa-wallet ml-1"></i>
                    </button>
                </form>
            </div>

            <!-- Rekap Data Keuangan Seluruh tenant (Bagi Hasil Transparan) -->
            <div class="neo-card bg-white p-6 lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-display text-2xl font-black uppercase">Arus Kas & Pajak Operasional</h3>
                        <p class="text-xs text-[#8B5E3C] font-semibold">Semua tenant menyetor 10% dari omset harian untuk biaya pemeliharaan & kebersihan gedung museum.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#FAF1E6] border-b-4 border-[#3D2516] text-xs font-black uppercase">
                                <th class="p-3 w-12 text-center border-r-2 border-[#3D2516]">No</th>
                                <th class="p-3 border-r-2 border-[#3D2516]">Nama tenant</th>
                                <th class="p-3 border-r-2 border-[#3D2516]">Omset Kotor</th>
                                <th class="p-3 border-r-2 border-[#3D2516]">Pajak Operasional (10%)</th>
                                <th class="p-3 border-r-2 border-[#3D2516]">Bersih tenant</th>
                                <th class="p-3">Tanggal Setor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-[#3D2516] text-xs font-semibold">
                            @forelse($sales as $index => $sal)
                                <tr class="hover:bg-[#FCF8F2]">
                                    <td class="p-3 text-center border-r-2 border-[#3D2516]">{{ $index + 1 }}</td>
                                    <td class="p-3 border-r-2 border-[#3D2516] font-bold">{{ $sal->nama_tenant }}</td>
                                    <td class="p-3 border-r-2 border-[#3D2516] text-gray-500">Rp {{ number_format($sal->total_omset, 0, ',', '.') }}</td>
                                    <td class="p-3 border-r-2 border-[#3D2516] text-red-600 font-bold">Rp {{ number_format($sal->jumlah_pajak, 0, ',', '.') }}</td>
                                    <td class="p-3 border-r-2 border-[#3D2516] text-emerald-600 font-bold">Rp {{ number_format($sal->pendapatan_bersih, 0, ',', '.') }}</td>
                                    <td class="p-3 text-gray-500">{{ $sal->tanggal_transaksi }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400 italic">Belum ada laporan setoran keuangan hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- ==================== PART 3: ADMIN VIEW ==================== -->
    <div id="view-admin" class="hidden space-y-8">
        
        <!-- Dashboard Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="neo-card bg-[#D4AF37] text-black p-6">
                <span class="text-xs uppercase font-black">Pendapatan Operasional Museum</span>
                <h3 class="font-display text-4xl font-black mt-2">Rp {{ number_format($totalTaxCollected, 0, ',', '.') }}</h3>
                <p class="text-[10px] uppercase font-bold mt-1 text-[#3D2516]">Sumber Dana: 10% Pajak Bagi Hasil tenant Lapak UMKM</p>
            </div>

            <div class="neo-card bg-[#FAF1E6] p-6">
                <span class="text-xs uppercase font-black">Antrean Tiket Visitor</span>
                <h3 class="font-display text-4xl font-black mt-2">{{ count($tickets) }} Pengunjung</h3>
                <p class="text-[10px] uppercase font-bold mt-1 text-[#8B5E3C]">Total Reservasi Tiket Terdaftar di Database</p>
            </div>

            <div class="neo-card bg-[#FAF1E6] p-6">
                <span class="text-xs uppercase font-black">Peminjaman Buku Aktif</span>
                <h3 class="font-display text-4xl font-black mt-2">{{ count($bookLoans) }} Buku</h3>
                <p class="text-[10px] uppercase font-bold mt-1 text-[#8B5E3C]">Total Arsip Sejarah yang Sedang Dipinjam</p>
            </div>

        </div>

        <!-- Approval Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Ticket Reservation Log -->
            <div class="neo-card bg-white p-6">
                <h3 class="font-display text-xl font-black uppercase mb-4">Log Reservasi Tiket Masuk</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-semibold">
                        <thead>
                            <tr class="bg-[#FAF1E6] border-b-2 border-[#3D2516] uppercase">
                                <th class="p-2 border-r-2 border-[#3D2516]">Pengunjung</th>
                                <th class="p-2 border-r-2 border-[#3D2516]">Tgl Kedatangan</th>
                                <th class="p-2 border-r-2 border-[#3D2516]">Jumlah</th>
                                <th class="p-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $tick)
                                <tr class="border-b border-gray-100">
                                    <td class="p-2 border-r-2 border-[#3D2516] font-bold">{{ $tick->visitor_name ?? 'Pengunjung Umum' }}</td>
                                    <td class="p-2 border-r-2 border-[#3D2516]">{{ $tick->tanggal_kunjungan }}</td>
                                    <td class="p-2 border-r-2 border-[#3D2516] text-center">{{ $tick->jumlah_tiket }} orang</td>
                                    <td class="p-2">
                                        <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                                            Approved
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-400 italic">Tidak ada log pemesanan tiket.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Book Loan Log -->
            <div class="neo-card bg-white p-6">
                <h3 class="font-display text-xl font-black uppercase mb-4">Log Peminjaman Buku Perpustakaan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-semibold">
                        <thead>
                            <tr class="bg-[#FAF1E6] border-b-2 border-[#3D2516] uppercase">
                                <th class="p-2 border-r-2 border-[#3D2516]">Nama Peminjam</th>
                                <th class="p-2 border-r-2 border-[#3D2516]">Judul Buku/Arsip</th>
                                <th class="p-2 border-r-2 border-[#3D2516]">Durasi Pinjam</th>
                                <th class="p-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookLoans as $loan)
                                <tr class="border-b border-gray-100">
                                    <td class="p-2 border-r-2 border-[#3D2516] font-bold">{{ $loan->borrower_name ?? 'Anggota Perpustakaan' }}</td>
                                    <td class="p-2 border-r-2 border-[#3D2516]">{{ $loan->book_title }}</td>
                                    <td class="p-2 border-r-2 border-[#3D2516]">{{ $loan->tanggal_pinjam }} s/d {{ $loan->tanggal_kembali }}</td>
                                    <td class="p-2">
                                        <span class="bg-indigo-100 text-indigo-800 border border-indigo-300 px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                                            Borrowed
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-400 italic">Tidak ada transaksi peminjam buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</main>

<!-- FOOTER -->
<footer class="max-w-7xl mx-auto px-4 mt-16 text-center">
    <div class="neo-card bg-[#3D2516] text-[#F5EBE0] py-8 px-6">
        <p class="font-display font-bold text-sm uppercase tracking-widest text-[#D4AF37]">© 2026 E-RTIFACT CORE SYSTEM</p>
        <p class="text-xs font-semibold text-gray-400 mt-1">Direktorat Pengelolaan Museum & Perpustakaan Digital Nusantara • Terelasi Database</p>
    </div>
</footer>

<!-- INTERACTIVE JAVASCRIPT FOR SIMULATION SANS ERROR -->
<script>
    function switchRole(role) {
        // Sembunyikan semua views
        document.getElementById('view-visitor').classList.add('hidden');
        document.getElementById('view-tenant').classList.add('hidden');
        document.getElementById('view-admin').classList.add('hidden');

        // Reset warna tombol tab
        document.getElementById('btn-role-visitor').className = 'px-3 py-1 bg-white border-2 border-[#3D2516] font-display font-extrabold text-xs uppercase';
        document.getElementById('btn-role-tenant').className = 'px-3 py-1 bg-white border-2 border-[#3D2516] font-display font-extrabold text-xs uppercase';
        document.getElementById('btn-role-admin').className = 'px-3 py-1 bg-white border-2 border-[#3D2516] font-display font-extrabold text-xs uppercase';

        // Tampilkan view yang aktif & ubah warna tombolnya
        if (role === 'visitor') {
            document.getElementById('view-visitor').classList.remove('hidden');
            document.getElementById('btn-role-visitor').className = 'px-3 py-1 bg-[#D4AF37] border-2 border-[#3D2516] font-display font-extrabold text-xs uppercase';
        } else if (role === 'tenant') {
            document.getElementById('view-tenant').classList.remove('hidden');
            document.getElementById('btn-role-tenant').className = 'px-3 py-1 bg-[#D4AF37] border-2 border-[#3D2516] font-display font-extrabold text-xs uppercase';
        } else if (role === 'admin') {
            document.getElementById('view-admin').classList.remove('hidden');
            document.getElementById('btn-role-admin').className = 'px-3 py-1 bg-[#D4AF37] border-2 border-[#3D2516] font-display font-extrabold text-xs uppercase';
        }
    }
</script>
