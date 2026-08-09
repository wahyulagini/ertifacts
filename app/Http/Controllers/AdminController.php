<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Reservasi;
use App\Models\tenant;
use App\Models\Transaksi;
use App\Models\Pajaktenant;
use App\Models\User;
use App\Models\Artefak;
use App\Models\TokohPenting;
use App\Models\ArsipSejarah;
use App\Models\LokasiGeografis;
use App\Models\TiketBantuan;
use App\Models\BukuTamu;

class AdminController extends Controller
{
    // ── Reservasi ─────────────────────────────────────────────
    public function reservasi()
    {
        $reservasi = Reservasi::with('user')
            ->latest()->paginate(15);
        $stats = [
            'menunggu'  => Reservasi::where('status','menunggu')->count(),
            'disetujui' => Reservasi::where('status','disetujui')->count(),
            'ditolak'   => Reservasi::where('status','ditolak')->count(),
            'selesai'   => Reservasi::where('status','selesai')->count(),
        ];
        return view('admin.reservasi', compact('reservasi','stats'));
    }
    

    public function setujuReservasi(Request $request, $id)
    {
        $r = Reservasi::findOrFail($id);
        $r->update([
            'status'         => 'disetujui',
            'catatan_admin'  => $request->catatan,
            'disetujui_pada' => now(),
        ]);
        return back()->with('success', "Reservasi #{$r->kode_booking} disetujui.");
    }

   public function selesaiReservasi(Request $request, $id)
    {
    $r = Reservasi::findOrFail($id);

    if ($r->status !== 'disetujui') {
        return back()->with('error', 'Hanya reservasi berstatus "Disetujui" yang bisa ditandai selesai.');
    }

    $r->update(['status' => 'selesai']);
    return back()->with('success', "Reservasi #{$r->kode_booking} ditandai selesai.");
    }

    // ── tenant ─────────────────────────────────────────────────
   public function tenant()
{
    $tenants = tenant::with('user')->latest()->paginate(15);
    $stats = [
        'menunggu' => tenant::where('status','menunggu')->count(),
        'aktif'    => tenant::where('status','aktif')->count(),
        'ditolak'  => tenant::where('status','ditolak')->count(),
    ];
    return view('admin.tenant', compact('tenants','stats'));  // ✅
}

    public function setujutenant(Request $request, $id)
    {
        $request->validate([
            'tarif_sewa'       => ['required','numeric','min:0'],
            'persentase_pajak' => ['required','numeric','min:0','max:100'],
        ]);

        $tenant = tenant::findOrFail($id);
        $tenant->update([
            'status'           => 'aktif',
            'tarif_sewa'       => $request->tarif_sewa,
            'persentase_pajak' => $request->persentase_pajak,
            'catatan_admin'    => $request->catatan,
            'disetujui_pada'   => now(),
        ]);
        // Ubah role user jadi tenant
        $tenant->user->update(['role' => 'tenant']);

        // Generate tagihan sewa pertama
        \App\Models\PajakTenant::create([
            'tenant_id'         => $tenant->id,
            'transaksi_id'      => null,
            'pendapatan_kotor'  => 0,
            'persentase_pajak'  => 0,
            'nominal_pajak'     => $request->tarif_sewa,
            'pendapatan_bersih' => 0,
            'periode'           => now()->format('Y-m'),
            'status_bayar'      => 'belum_bayar',
            'catatan'           => 'Tagihan sewa booth event bulan ' . now()->translatedFormat('F Y'),
        ]);

        return back()->with('success', "tenant {$tenant->nama_tenant} disetujui dan tagihan sewa telah dibuat.");
    }

    public function tolaktenant(Request $request, $id)
    {
        $tenant = tenant::findOrFail($id);
        $tenant->update([
            'status'        => 'ditolak',
            'catatan_admin' => $request->catatan ?? 'Permohonan ditolak.',
        ]);
        return back()->with('success', "tenant {$tenant->nama_tenant} ditolak.");
    }

    // ── Pajak Tenant ──────────────────────────────────────────
public function pajak(Request $request)
{
    $query = PajakTenant::with('tenant.user');

    if ($request->filled('status')) {
        $query->where('status_bayar', $request->status);
    }

    $pajak = $query->latest()->paginate(15)->withQueryString();

    $stats = [
        'belum_bayar'         => PajakTenant::where('status_bayar','belum_bayar')->count(),
        'menunggu_konfirmasi' => PajakTenant::where('status_bayar','menunggu_konfirmasi')->count(),
        'sudah_bayar'         => PajakTenant::where('status_bayar','sudah_bayar')->count(),
        'total_terkumpul'     => PajakTenant::where('status_bayar','sudah_bayar')
                                    ->whereMonth('created_at', now()->month)->sum('nominal_pajak'),
    ];

    return view('admin.pajak', compact('pajak','stats'));
}

public function konfirmasiPajak(Request $request, $id)
{
    $pajak = PajakTenant::findOrFail($id);

    if ($pajak->status_bayar !== 'menunggu_konfirmasi') {
        return back()->with('error', 'Hanya tagihan berstatus "Menunggu Konfirmasi" yang bisa dikonfirmasi.');
    }

    $pajak->update([
        'status_bayar'  => 'sudah_bayar',
        'dibayar_pada'  => now(),
        'catatan'       => $request->catatan ?? $pajak->catatan,
    ]);

    return back()->with('success', "Pembayaran pajak periode {$pajak->periode} dikonfirmasi lunas.");
}

    public function tolakPajak(Request $request, $id)
    {
         $pajak = PajakTenant::findOrFail($id);

         $pajak->update([
                'status_bayar' => 'belum_bayar',
                'catatan'      => $request->catatan ?? 'Bukti pembayaran tidak valid, silakan upload ulang.',
    ]);

    return back()->with('success', "Bukti pembayaran ditolak, tenant diminta upload ulang.");
    }

    // ── Koleksi E-RTIFACT ─────────────────────────────────────
    public function artefak()
    {
        $artefak = Artefak::latest()->paginate(12);
        return view('admin.artefak', compact('artefak'));
    }

    public function tokoh()
    {
        $tokoh = \App\Models\TokohPenting::latest()->paginate(12);
        return view('admin.tokoh', compact('tokoh'));
    }

    public function arsip()
    {
        $arsip = \App\Models\ArsipSejarah::latest()->paginate(12);
        return view('admin.arsip', compact('arsip'));
    }

    public function lokasi()
    {
        $lokasi = LokasiGeografis::latest()->paginate(12);
        return view('admin.lokasi', compact('lokasi'));
    }

    // ── Create & Store: Artefak ───────────────────────────────
    public function createArtefak()
    {
        return view('admin.artefak_create');
    }

    public function storeArtefak(Request $request)
    {
        $validated = $request->validate([
            'nama_artefak'    => ['required','string','max:150','unique:artefak,nama_artefak'],
            'nama_lokal'      => ['nullable','string','max:150'],
            'era_periodisasi' => ['nullable','string','max:100'],
            'periode_abad'    => ['nullable','string','max:100'],
            'kategori'        => ['nullable','string','max:100'],
            'asal_daerah'     => ['nullable','string','max:100'],
            'bahan_utama'     => ['nullable','string','max:100'],
            'deskripsi'       => ['nullable','string','max:2000'],
            'gambar'          => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'persentase_keutuhan' => ['nullable','numeric','min:0','max:100'],
            'bisa_dipinjam'   => ['nullable','boolean'],
        ]);

        // Auto-generate kode registrasi unik: ART-YYYYMM-NNN
        $prefix = 'ART-' . now()->format('Ym') . '-';
        $count  = Artefak::where('kode_registrasi', 'like', $prefix . '%')->count() + 1;
        $validated['kode_registrasi'] = $prefix . str_pad($count, 3, '0', STR_PAD_LEFT);

        if ($request->hasFile('gambar')) {
            $validated['gambar_path'] = $request->file('gambar')->store('artefak', 'public');
        }
        $validated['bisa_dipinjam'] = $request->has('bisa_dipinjam');

        Artefak::create($validated);

        return redirect()->route('admin.artefak')->with('success', 'Artefak berhasil ditambahkan.');
    }

    // ── Create & Store: Tokoh Penting ─────────────────────────
    public function createTokoh()
    {
        return view('admin.tokoh_create');
    }

    public function storeTokoh(Request $request)
    {
        $validated = $request->validate([
            'nama_tokoh'      => ['required','string','max:150','unique:tokoh_penting,nama_tokoh'],
            'nama_julukan'    => ['nullable','string','max:150'],
            'gelar'           => ['nullable','string','max:150'],
            'peran'           => ['nullable','string','max:150'],
            'era_aktif'       => ['nullable','string','max:100'],
            'tahun_lahir'     => ['nullable','string','max:20'],
            'tahun_wafat'     => ['nullable','string','max:20'],
            'tempat_asal'     => ['nullable','string','max:150'],
            'biografi'        => ['nullable','string','max:5000'],
            'kontribusi'      => ['nullable','string','max:2000'],
            'gambar'          => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'sumber_referensi'=> ['nullable','string','max:500'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar_path'] = $request->file('gambar')->store('tokoh', 'public');
        }

        TokohPenting::create($validated);

        return redirect()->route('admin.tokoh')->with('success', 'Tokoh penting berhasil ditambahkan.');
    }

    // ── Create & Store: Arsip Sejarah ─────────────────────────
    public function createArsip()
    {
        return view('admin.arsip_create');
    }

    public function storeArsip(Request $request)
    {
        $validated = $request->validate([
            'judul_arsip'        => ['required','string','max:200','unique:arsip_sejarah,judul_arsip'],
            'jenis_koleksi'      => ['required','in:Naskah Kuno,Foto Bersejarah,Peta Kuno,Surat / Dokumen Resmi,Rekaman Audio,Rekaman Video,Laporan Arkeologi,Lainnya'],
            'bahasa'             => ['nullable','string','max:50'],
            'tahun_dokumen'      => ['nullable','string','max:20'],
            'asal_instansi'      => ['nullable','string','max:150'],
            'deskripsi_isi'      => ['nullable','string','max:3000'],
            'kondisi_fisik'      => ['nullable','string','max:100'],
            'lokasi_penyimpanan' => ['nullable','string','max:150'],
            'gambar'             => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'tersedia_publik'    => ['nullable','boolean'],
        ]);

        // Auto-generate kode arsip unik: ARS-YYYYMM-NNN
        $prefix = 'ARS-' . now()->format('Ym') . '-';
        $count  = ArsipSejarah::where('kode_arsip', 'like', $prefix . '%')->count() + 1;
        $validated['kode_arsip'] = $prefix . str_pad($count, 3, '0', STR_PAD_LEFT);

        if ($request->hasFile('gambar')) {
            $validated['gambar_thumbnail'] = $request->file('gambar')->store('arsip', 'public');
        }
        $validated['tersedia_publik'] = $request->has('tersedia_publik');

        ArsipSejarah::create($validated);

        return redirect()->route('admin.arsip')->with('success', 'Arsip sejarah berhasil ditambahkan.');
    }

    // ── Create & Store: Lokasi Geografis ──────────────────────
    public function createLokasi()
    {
        return view('admin.lokasi_create');
    }

    public function storeLokasi(Request $request)
    {
        if ($request->has('latitude') && $request->latitude !== null) {
            $request->merge(['latitude' => str_replace(',', '.', $request->latitude)]);
        }
        if ($request->has('longitude') && $request->longitude !== null) {
            $request->merge(['longitude' => str_replace(',', '.', $request->longitude)]);
        }

        $validated = $request->validate([
            'nama_lokasi'     => ['required','string','max:150','unique:lokasi_geografis,nama_lokasi'],
            'jenis_lokasi'    => ['required','in:Situs Arkeologi,Museum,Cagar Budaya,Makam Bersejarah,Masjid Bersejarah,Benteng,Istana / Keraton,Lainnya'],
            'kecamatan'       => ['nullable','string','max:100'],
            'kabupaten_kota'  => ['nullable','string','max:100'],
            'provinsi'        => ['nullable','string','max:100'],
            'latitude'        => ['nullable','numeric'],
            'longitude'       => ['nullable','numeric'],
            'deskripsi'       => ['nullable','string','max:3000'],
            'periode_sejarah' => ['nullable','string','max:100'],
            'status_kelola'   => ['required','in:Aktif Dijaga,Terbengkalai,Renovasi,Tertutup'],
            'pengelola'       => ['nullable','string','max:150'],
            'jam_operasional' => ['nullable','string','max:100'],
            'gambar'          => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar_path'] = $request->file('gambar')->store('lokasi', 'public');
        }

        LokasiGeografis::create($validated);

        return redirect()->route('admin.lokasi')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function keuangan(Request $request)
    {
        $bulan = now()->month;
        $tahun = now()->year;

        // ── Query tabel transaksi (sewa, pajak tenant, dll) ──────────────
        $queryTransaksi = Transaksi::with(['user','tenant']);
        if ($request->filled('jenis') && $request->jenis !== 'Tiket Pengunjung') {
            $queryTransaksi->where('jenis_transaksi', $request->jenis);
        }
        if ($request->filled('dari')) {
            $queryTransaksi->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $queryTransaksi->whereDate('created_at', '<=', $request->sampai);
        }
        // Jika filter jenis = Tiket Pengunjung, kosongkan query transaksi
        if ($request->jenis === 'Tiket Pengunjung') {
            $queryTransaksi->whereRaw('1=0');
        }
        $transaksiRows = $queryTransaksi->latest()->get();

        // ── Query tabel buku_tamu (tiket pengunjung) ─────────────────────
        $queryTiket = BukuTamu::query();
        if ($request->filled('dari')) {
            $queryTiket->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $queryTiket->whereDate('created_at', '<=', $request->sampai);
        }
        // Jika filter jenis diisi dan bukan Tiket Pengunjung, kosongkan query tiket
        if ($request->filled('jenis') && $request->jenis !== 'Tiket Pengunjung') {
            $queryTiket->whereRaw('1=0');
        }
        $tiketRows = $queryTiket->latest()->get();

        // ── Gabungkan & mapping ke format seragam, lalu paginate manual ──
        $tiketMapped = $tiketRows->map(fn($b) => (object)[
            'kode_transaksi'  => $b->kode_tiket,
            'jenis_transaksi' => 'Tiket Pengunjung (' . ucfirst($b->jenis_tiket) . ')',
            'sumber'          => $b->nama_pengunjung,
            'created_at'      => $b->created_at,
            'status_bayar'    => $b->status_bayar,
            'jumlah'          => $b->total_harga,
            'jumlah_rp'       => 'Rp ' . number_format($b->total_harga, 0, ',', '.'),
            'is_tiket'        => true,
        ]);

        $transaksiMapped = $transaksiRows->map(fn($t) => (object)[
            'kode_transaksi'  => $t->kode_transaksi,
            'jenis_transaksi' => $t->jenis_transaksi,
            'sumber'          => $t->tenant->nama_tenant ?? $t->user->name ?? '-',
            'created_at'      => $t->created_at,
            'status_bayar'    => $t->status_bayar,
            'jumlah'          => $t->jumlah,
            'jumlah_rp'       => $t->jumlah_rp,
            'is_tiket'        => false,
        ]);

        $allRows    = $tiketMapped->merge($transaksiMapped)->sortByDesc('created_at')->values();
        $perPage    = 20;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $transaksi  = new \Illuminate\Pagination\LengthAwarePaginator(
            $allRows->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $allRows->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // ── Statistik bulan ini ──────────────────────────────────────────
        $tiket_bulan = BukuTamu::where('status_bayar', 'lunas')
            ->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)
            ->sum('total_harga');

        $sewa_bulan = Transaksi::where('jenis_transaksi','Sewa Tempat tenant')
            ->where('status_bayar','lunas')
            ->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->sum('jumlah');

        $pajak_bulan = PajakTenant::where('status_bayar','sudah_bayar')
            ->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->sum('nominal_pajak');

        $pendapatan_tenant_kotor = Transaksi::where('jenis_transaksi','Pendapatan tenant')
            ->where('status_bayar','lunas')
            ->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->sum('jumlah');

        $stats = [
            'tiket_bulan'             => $tiket_bulan,
            'sewa_bulan'              => $sewa_bulan,
            'pajak_bulan'             => $pajak_bulan,
            'total_bulan'             => $tiket_bulan + $sewa_bulan + $pajak_bulan,
            'pendapatan_tenant_kotor' => $pendapatan_tenant_kotor,
        ];

        // ── Tren 6 bulan terakhir ────────────────────────────────────────
        $tren = collect(range(5, 0))->map(function ($i) {
            $bln = now()->subMonths($i);

            $tiket = BukuTamu::where('status_bayar', 'lunas')
                ->whereMonth('created_at', $bln->month)->whereYear('created_at', $bln->year)
                ->sum('total_harga');
            $sewa  = Transaksi::where('jenis_transaksi','Sewa Tempat tenant')->where('status_bayar','lunas')
                ->whereMonth('created_at', $bln->month)->whereYear('created_at', $bln->year)->sum('jumlah');
            $pajak = PajakTenant::where('status_bayar','sudah_bayar')
                ->whereMonth('created_at', $bln->month)->whereYear('created_at', $bln->year)->sum('nominal_pajak');

            return [
                'label' => $bln->translatedFormat('M Y'),
                'total' => (float) ($tiket + $sewa + $pajak),
            ];
        });

        return view('admin.keuangan', compact('transaksi', 'stats', 'tren'));
    }

    public function users(Request $request)
    {
        $users = \App\Models\User::with('tenant')->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function bukuTamu()
    {
        $buku_tamu = \App\Models\BukuTamu::latest()->paginate(20);
        return view('admin.buku_tamu', compact('buku_tamu'));
    }

    // ── Events ────────────────────────────────────────────────
    public function events()
    {
        $events = \App\Models\Event::latest()->paginate(10);
        return view('admin.events', compact('events'));
    }

    public function createEvent()
    {
        return view('admin.events_create');
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'judul_event' => ['required','string','max:150'],
            'deskripsi' => ['nullable','string'],
            'tanggal_mulai' => ['required','date'],
            'tanggal_selesai' => ['required','date','after_or_equal:tanggal_mulai'],
            'lokasi_area' => ['nullable','string','max:100'],
            'kuota_tenant' => ['required','integer','min:0'],
            'harga_sewa_booth' => ['required','numeric','min:0'],
            'status' => ['required','in:mendatang,berjalan,selesai,dibatalkan'],
            'gambar' => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar_path'] = $request->file('gambar')->store('events', 'public');
        }

        \App\Models\Event::create($validated);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    // ── Edit & Update: Artefak ────────────────────────────────
    public function editArtefak($id)
    {
        $item = Artefak::findOrFail($id);
        return view('admin.artefak_edit', compact('item'));
    }

    public function updateArtefak(Request $request, $id)
    {
        $item = Artefak::findOrFail($id);
        $validated = $request->validate([
            'nama_artefak'        => ['required','string','max:150','unique:artefak,nama_artefak,'.$id],
            'nama_lokal'          => ['nullable','string','max:150'],
            'era_periodisasi'     => ['nullable','string','max:100'],
            'periode_abad'        => ['nullable','string','max:100'],
            'kategori'            => ['nullable','string','max:100'],
            'asal_daerah'         => ['nullable','string','max:100'],
            'bahan_utama'         => ['nullable','string','max:100'],
            'deskripsi'           => ['nullable','string','max:2000'],
            'gambar'              => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'persentase_keutuhan' => ['nullable','numeric','min:0','max:100'],
            'bisa_dipinjam'       => ['nullable','boolean'],
        ]);
        if ($request->hasFile('gambar')) {
            if ($item->gambar_path) \Storage::disk('public')->delete($item->gambar_path);
            $validated['gambar_path'] = $request->file('gambar')->store('artefak', 'public');
        }
        $validated['bisa_dipinjam'] = $request->has('bisa_dipinjam');
        $item->update($validated);
        return redirect()->route('admin.artefak')->with('success', 'Artefak berhasil diperbarui.');
    }

    public function destroyArtefak($id)
    {
        $item = Artefak::findOrFail($id);
        if ($item->gambar_path) \Storage::disk('public')->delete($item->gambar_path);
        $item->delete();
        return redirect()->route('admin.artefak')->with('success', 'Artefak berhasil dihapus.');
    }

    // ── Edit & Update: Tokoh Penting ─────────────────────────
    public function editTokoh($id)
    {
        $item = \App\Models\TokohPenting::findOrFail($id);
        return view('admin.tokoh_edit', compact('item'));
    }

    public function updateTokoh(Request $request, $id)
    {
        $item = \App\Models\TokohPenting::findOrFail($id);
        $validated = $request->validate([
            'nama_tokoh'       => ['required','string','max:150','unique:tokoh_penting,nama_tokoh,'.$id],
            'nama_julukan'     => ['nullable','string','max:150'],
            'gelar'            => ['nullable','string','max:150'],
            'peran'            => ['nullable','string','max:150'],
            'era_aktif'        => ['nullable','string','max:100'],
            'tahun_lahir'      => ['nullable','string','max:20'],
            'tahun_wafat'      => ['nullable','string','max:20'],
            'tempat_asal'      => ['nullable','string','max:150'],
            'biografi'         => ['nullable','string','max:5000'],
            'kontribusi'       => ['nullable','string','max:2000'],
            'gambar'           => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'sumber_referensi' => ['nullable','string','max:500'],
        ]);
        if ($request->hasFile('gambar')) {
            if ($item->gambar_path) \Storage::disk('public')->delete($item->gambar_path);
            $validated['gambar_path'] = $request->file('gambar')->store('tokoh', 'public');
        }
        $item->update($validated);
        return redirect()->route('admin.tokoh')->with('success', 'Tokoh berhasil diperbarui.');
    }

    public function destroyTokoh($id)
    {
        $item = \App\Models\TokohPenting::findOrFail($id);
        if ($item->gambar_path) \Storage::disk('public')->delete($item->gambar_path);
        $item->delete();
        return redirect()->route('admin.tokoh')->with('success', 'Tokoh berhasil dihapus.');
    }

    // ── Edit & Update: Arsip Sejarah ──────────────────────────
    public function editArsip($id)
    {
        $item = \App\Models\ArsipSejarah::findOrFail($id);
        return view('admin.arsip_edit', compact('item'));
    }

    public function updateArsip(Request $request, $id)
    {
        $item = \App\Models\ArsipSejarah::findOrFail($id);
        $validated = $request->validate([
            'judul_arsip'        => ['required','string','max:200','unique:arsip_sejarah,judul_arsip,'.$id],
            'jenis_koleksi'      => ['required','in:Naskah Kuno,Foto Bersejarah,Peta Kuno,Surat / Dokumen Resmi,Rekaman Audio,Rekaman Video,Laporan Arkeologi,Lainnya'],
            'bahasa'             => ['nullable','string','max:50'],
            'tahun_dokumen'      => ['nullable','string','max:20'],
            'asal_instansi'      => ['nullable','string','max:150'],
            'deskripsi_isi'      => ['nullable','string','max:3000'],
            'kondisi_fisik'      => ['nullable','string','max:100'],
            'lokasi_penyimpanan' => ['nullable','string','max:150'],
            'gambar'             => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'tersedia_publik'    => ['nullable','boolean'],
        ]);
        if ($request->hasFile('gambar')) {
            if ($item->gambar_thumbnail) \Storage::disk('public')->delete($item->gambar_thumbnail);
            $validated['gambar_thumbnail'] = $request->file('gambar')->store('arsip', 'public');
        }
        $validated['tersedia_publik'] = $request->has('tersedia_publik');
        $item->update($validated);
        return redirect()->route('admin.arsip')->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroyArsip($id)
    {
        $item = \App\Models\ArsipSejarah::findOrFail($id);
        if ($item->gambar_thumbnail) \Storage::disk('public')->delete($item->gambar_thumbnail);
        $item->delete();
        return redirect()->route('admin.arsip')->with('success', 'Arsip berhasil dihapus.');
    }

    // ── Edit & Update: Lokasi Geografis ───────────────────────
    public function editLokasi($id)
    {
        $item = LokasiGeografis::findOrFail($id);
        return view('admin.lokasi_edit', compact('item'));
    }

    public function updateLokasi(Request $request, $id)
    {
        $item = LokasiGeografis::findOrFail($id);

        if ($request->has('latitude') && $request->latitude !== null) {
            $request->merge(['latitude' => str_replace(',', '.', $request->latitude)]);
        }
        if ($request->has('longitude') && $request->longitude !== null) {
            $request->merge(['longitude' => str_replace(',', '.', $request->longitude)]);
        }

        $validated = $request->validate([
            'nama_lokasi'     => ['required','string','max:150','unique:lokasi_geografis,nama_lokasi,'.$id],
            'jenis_lokasi'    => ['required','in:Situs Arkeologi,Museum,Cagar Budaya,Makam Bersejarah,Masjid Bersejarah,Benteng,Istana / Keraton,Lainnya'],
            'kecamatan'       => ['nullable','string','max:100'],
            'kabupaten_kota'  => ['nullable','string','max:100'],
            'provinsi'        => ['nullable','string','max:100'],
            'latitude'        => ['nullable','numeric'],
            'longitude'       => ['nullable','numeric'],
            'deskripsi'       => ['nullable','string','max:3000'],
            'periode_sejarah' => ['nullable','string','max:100'],
            'status_kelola'   => ['required','in:Aktif Dijaga,Terbengkalai,Renovasi,Tertutup'],
            'pengelola'       => ['nullable','string','max:150'],
            'jam_operasional' => ['nullable','string','max:100'],
            'gambar'          => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        ]);
        if ($request->hasFile('gambar')) {
            if ($item->gambar_path) \Storage::disk('public')->delete($item->gambar_path);
            $validated['gambar_path'] = $request->file('gambar')->store('lokasi', 'public');
        }
        $item->update($validated);
        return redirect()->route('admin.lokasi')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroyLokasi($id)
    {
        $item = LokasiGeografis::findOrFail($id);
        if ($item->gambar_path) \Storage::disk('public')->delete($item->gambar_path);
        $item->delete();
        return redirect()->route('admin.lokasi')->with('success', 'Lokasi berhasil dihapus.');
    }

    // ── Edit & Update: Events ──────────────────────────────────
    public function editEvent($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        return view('admin.events_edit', compact('event'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $validated = $request->validate([
            'judul_event'      => ['required','string','max:150'],
            'deskripsi'        => ['nullable','string'],
            'tanggal_mulai'    => ['required','date'],
            'tanggal_selesai'  => ['required','date','after_or_equal:tanggal_mulai'],
            'lokasi_area'      => ['nullable','string','max:100'],
            'kuota_tenant'     => ['required','integer','min:0'],
            'harga_sewa_booth' => ['required','numeric','min:0'],
            'status'           => ['required','in:mendatang,berjalan,selesai,dibatalkan'],
            'gambar'           => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        ]);
        if ($request->hasFile('gambar')) {
            if ($event->gambar_path) \Storage::disk('public')->delete($event->gambar_path);
            $validated['gambar_path'] = $request->file('gambar')->store('events', 'public');
        }
        $event->update($validated);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroyEvent($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if ($event->gambar_path) \Storage::disk('public')->delete($event->gambar_path);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

    // ── Tiket Bantuan ────────────────────────────────────────────
    public function tiketBantuan()
    {
        $tikets = TiketBantuan::with('tenant')
            ->latest()
            ->paginate(20);
        $stats = [
            'menunggu' => TiketBantuan::where('status', 'menunggu')->count(),
            'dibalas'  => TiketBantuan::where('status', 'dibalas')->count(),
            'ditutup'  => TiketBantuan::where('status', 'ditutup')->count(),
        ];
        return view('admin.tiket_bantuan', compact('tikets', 'stats'));
    }

    public function balasTiketBantuan(Request $request, $id)
    {
        $tiket = TiketBantuan::findOrFail($id);
        $request->validate(['balasan' => 'required|string|max:2000']);
        $tiket->update([
            'balasan_admin' => $request->balasan,
            'status'        => 'dibalas',
            'dibalas_pada'  => now(),
        ]);
        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function tutupTiketBantuan($id)
    {
        TiketBantuan::findOrFail($id)->update(['status' => 'ditutup']);
        return back()->with('success', 'Tiket berhasil ditutup.');
    }

    // ── Bantuan Publik ──────────────────────────────────────────
    public function bantuanPublik()
    {
        $tikets = \App\Models\BantuanPublik::latest()->paginate(20);
        $stats = [
            'menunggu' => \App\Models\BantuanPublik::where('status', 'menunggu')->count(),
            'dibalas'  => \App\Models\BantuanPublik::where('status', 'dibalas')->count(),
            'ditutup'  => \App\Models\BantuanPublik::where('status', 'ditutup')->count(),
        ];
        return view('admin.bantuan_publik', compact('tikets', 'stats'));
    }

    public function balasBantuanPublik(Request $request, $id)
    {
        $tiket = \App\Models\BantuanPublik::findOrFail($id);
        $request->validate(['balasan' => 'required|string|max:2000']);
        $tiket->update([
            'balasan_admin' => $request->balasan,
            'status'        => 'dibalas',
            'dibalas_pada'  => now(),
        ]);
        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function tutupBantuanPublik($id)
    {
        \App\Models\BantuanPublik::findOrFail($id)->update(['status' => 'ditutup']);
        return back()->with('success', 'Tiket bantuan publik berhasil ditutup.');
    }
}