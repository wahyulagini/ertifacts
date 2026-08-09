<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Tenant;
use App\Models\Transaksi;
use App\Models\PajakTenant;
use App\Models\TiketBantuan;

class TenantController extends Controller
{
    // ═══════════════════════════════════════════════
    // DASHBOARD
    // ═══════════════════════════════════════════════
    public function dashboard()
    {
        $user   = Auth::user();
        $tenant = Tenant::where('user_id', $user->id)->where('status', 'aktif')->latest()->first() ?? Tenant::where('user_id', $user->id)->latest()->first();

        if (!$tenant) {
            return redirect()->route('tenant.daftar')
                ->with('info', 'Anda belum mendaftar untuk event manapun. Silakan daftar booth event.');
        }

        $transaksi  = Transaksi::where('tenant_id', $tenant->id)->latest()->take(10)->get();
        $pajak_list = PajakTenant::where('tenant_id', $tenant->id)->latest()->take(6)->get();
        $tikets     = TiketBantuan::where('tenant_id', $tenant->id)->latest()->get();

        // Tagihan sewa bulan ini (berdasarkan harga sewa booth, bukan penjualan)
        $pajak_bulan = PajakTenant::where('tenant_id', $tenant->id)
            ->where('periode', now()->format('Y-m'))
            ->sum('nominal_pajak');

        $stats = [
            'pajak_bulan'           => $pajak_bulan,
            'pajak_belum_bayar'     => PajakTenant::where('tenant_id', $tenant->id)
                                        ->whereIn('status_bayar', ['belum_bayar', 'menunggu_konfirmasi'])
                                        ->sum('nominal_pajak'),
            'total_transaksi'       => Transaksi::where('tenant_id', $tenant->id)
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
            'total_tiket'           => TiketBantuan::where('tenant_id', $tenant->id)->count(),
            'tiket_menunggu_balasan'=> TiketBantuan::where('tenant_id', $tenant->id)->where('status','dibalas')->count(),
        ];

        return view('tenant.dashboard', compact('tenant', 'transaksi', 'pajak_list', 'tikets', 'stats'));
    }

    // ═══════════════════════════════════════════════
    // FORM DAFTAR TENANT
    // ═══════════════════════════════════════════════
    public function formDaftar()
    {
        $events = \App\Models\Event::whereIn('status', ['mendatang', 'berjalan'])->get();
        return view('tenant.daftar', compact('events'));
    }

    public function storeDaftar(Request $request)
    {
        $validated = $request->validate([
            'event_id'         => ['required', 'exists:events,id'],
            'nama_tenant'      => ['required', 'string', 'max:150'],
            'jenis_usaha'      => ['required', 'string', 'max:100'],
            'deskripsi'        => ['nullable', 'string', 'max:500'],
            'no_kontak'        => ['nullable', 'string', 'max:20'],
        ], [
            'event_id.required'    => 'Event wajib dipilih.',
            'nama_tenant.required' => 'Nama usaha wajib diisi.',
            'jenis_usaha.required' => 'Jenis usaha wajib dipilih.',
        ]);

        $event = \App\Models\Event::findOrFail($validated['event_id']);

        Tenant::create([
            'user_id'          => Auth::id(),
            'event_id'         => $event->id,
            'nama_tenant'      => $validated['nama_tenant'],
            'jenis_usaha'      => $validated['jenis_usaha'],
            'deskripsi'        => $validated['deskripsi'] ?? null,
            'lokasi_di_museum' => $event->lokasi_area, // mengikuti lokasi event
            'no_kontak'        => $validated['no_kontak'] ?? null,
            'persentase_pajak' => 10.00,
            'tarif_sewa'       => $event->harga_sewa_booth,
            'status'           => 'menunggu',
        ]);

        return redirect()->route('tenant.dashboard')
            ->with('success', 'Pendaftaran event berhasil! Menunggu persetujuan admin.');
    }

    // ═══════════════════════════════════════════════
    // INPUT PENJUALAN
    // ═══════════════════════════════════════════════
    public function penjualan()
    {
        $tenant    = Auth::user()->tenant;
        $transaksi = Transaksi::where('tenant_id', $tenant?->id)->latest()->paginate(10);
        return view('tenant.penjualan', compact('transaksi', 'tenant'));
    }

    public function storePenjualan(Request $request)
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant || $tenant->status !== 'aktif') {
            return back()->with('error', 'Akun tenant belum aktif. Tunggu persetujuan admin.');
        }

        $validated = $request->validate([
            'jumlah'       => ['required', 'numeric', 'min:1000'],
            'keterangan'   => ['required', 'string', 'max:200'],
            'metode_bayar' => ['required', 'string'],
            'tanggal'      => ['nullable', 'date'],
        ], [
            'jumlah.required'       => 'Jumlah penjualan wajib diisi.',
            'jumlah.min'            => 'Jumlah minimal Rp 1.000.',
            'keterangan.required'   => 'Keterangan transaksi wajib diisi.',
            'metode_bayar.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        $transaksi = Transaksi::create([
            'user_id'         => Auth::id(),
            'tenant_id'       => $tenant->id,
            'jenis_transaksi' => 'Pendapatan tenant',
            'jumlah'          => $validated['jumlah'],
            'metode_bayar'    => $validated['metode_bayar'],
            'status_bayar'    => 'lunas',
            'keterangan'      => $validated['keterangan'],
            'dibayar_pada'    => $validated['tanggal'] ?? now(),
            'created_at'      => $validated['tanggal'] ?? now(),
        ]);

        $nominalPajak = $transaksi->jumlah * ($tenant->persentase_pajak / 100);
        PajakTenant::create([
            'tenant_id'         => $tenant->id,
            'transaksi_id'      => $transaksi->id,
            'pendapatan_kotor'  => $transaksi->jumlah,
            'persentase_pajak'  => $tenant->persentase_pajak,
            'nominal_pajak'     => $nominalPajak,
            'pendapatan_bersih' => $transaksi->jumlah - $nominalPajak,
            'periode'           => now()->format('Y-m'),
            'status_bayar'      => 'belum_bayar',
        ]);

        return redirect()->route('tenant.penjualan')
            ->with('success', 'Penjualan dicatat! Pajak ' . $tenant->persentase_pajak . '% = Rp ' . number_format($nominalPajak, 0, ',', '.'));
    }

    // ═══════════════════════════════════════════════
    // RIWAYAT TRANSAKSI (dengan filter tanggal)
    // ═══════════════════════════════════════════════
    public function riwayat(Request $request)
    {
        $tenant = Auth::user()->tenant;

        $query = Transaksi::where('tenant_id', $tenant?->id);

        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        $transaksi = $query->latest()->paginate(15)->withQueryString();

        return view('tenant.riwayat', compact('transaksi', 'tenant'));
    }

    // ═══════════════════════════════════════════════
    // TAGIHAN PAJAK
    // ═══════════════════════════════════════════════
    public function pajak()
    {
        $tenant      = Auth::user()->tenant;
        $pajak       = PajakTenant::where('tenant_id', $tenant?->id)->latest()->paginate(10);
        $total_belum = PajakTenant::where('tenant_id', $tenant?->id)
                        ->whereIn('status_bayar', ['belum_bayar', 'menunggu_konfirmasi'])
                        ->sum('nominal_pajak');

        return view('tenant.pajak', compact('pajak', 'total_belum', 'tenant'));
    }

    public function uploadBuktiBayar(Request $request, $id)
    {
        $tenant = Auth::user()->tenant;
        $pajak  = PajakTenant::where('tenant_id', $tenant?->id)->findOrFail($id);

        $request->validate([
            'bukti_bayar' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'bukti_bayar.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_bayar.mimes'    => 'File harus berupa JPG, PNG, atau PDF.',
            'bukti_bayar.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $request->file('bukti_bayar')->store('bukti-bayar-pajak', 'public');

        $pajak->update([
            'bukti_bayar_path' => $path,
            'status_bayar'     => 'menunggu_konfirmasi',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
    }

    // ═══════════════════════════════════════════════
    // PROFIL USAHA
    // ═══════════════════════════════════════════════
    public function profil()
    {
        $tenant = Auth::user()->tenant;
        return view('tenant.profil', compact('tenant'));
    }

    public function updateProfil(Request $request)
    {
        $tenant = Auth::user()->tenant;

        $validated = $request->validate([
            'nama_tenant'      => ['required', 'string', 'max:150'],
            'jenis_usaha'      => ['required', 'string', 'max:100'],
            'deskripsi'        => ['nullable', 'string', 'max:500'],
            'no_kontak'        => ['nullable', 'string', 'max:20'],
            'website'          => ['nullable', 'url', 'max:255'],
            'lokasi_di_museum' => ['nullable', 'string', 'max:150'],
            'logo'             => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        if ($request->hasFile('logo')) {
            if ($tenant->logo_path) {
                Storage::disk('public')->delete($tenant->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('logo-tenant', 'public');
        }

        $tenant->update($validated);

        return back()->with('success', 'Profil usaha berhasil diperbarui.');
    }

    // ═══════════════════════════════════════════════
    // PUSAT BANTUAN
    // ═══════════════════════════════════════════════
    public function bantuan()
    {
        $tenant = Auth::user()->tenant;
        $tikets = TiketBantuan::where('tenant_id', $tenant?->id)->latest()->get();
        return view('tenant.bantuan', compact('tenant', 'tikets'));
    }

    public function storeBantuan(Request $request)
    {
        $tenant = Auth::user()->tenant;

        $request->validate([
            'subjek' => 'required|string|max:150',
            'pesan'  => 'required|string|max:2000',
        ], [
            'subjek.required' => 'Subjek tiket wajib diisi.',
            'pesan.required'  => 'Pesan wajib diisi.',
        ]);

        TiketBantuan::create([
            'tenant_id' => $tenant->id,
            'subjek'    => $request->subjek,
            'pesan'     => $request->pesan,
            'status'    => 'menunggu',
        ]);

        return back()->with('success', 'Tiket bantuan berhasil dikirim! Admin akan segera merespons.');
    }
}