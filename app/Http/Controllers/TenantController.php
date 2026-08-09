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
        $Tenant = Tenant::where('user_id', $user->id)->where('status', 'aktif')->latest()->first() ?? Tenant::where('user_id', $user->id)->latest()->first();

        if (!$Tenant) {
            return redirect()->route('Tenant.daftar')
                ->with('info', 'Anda belum mendaftar untuk event manapun. Silakan daftar booth event.');
        }

        $transaksi  = Transaksi::where('Tenant_id', $Tenant->id)->latest()->take(10)->get();
        $pajak_list = PajakTenant::where('Tenant_id', $Tenant->id)->latest()->take(6)->get();
        $tikets     = TiketBantuan::where('Tenant_id', $Tenant->id)->latest()->get();

        // Tagihan sewa bulan ini (berdasarkan harga sewa booth, bukan penjualan)
        $pajak_bulan = PajakTenant::where('Tenant_id', $Tenant->id)
            ->where('periode', now()->format('Y-m'))
            ->sum('nominal_pajak');

        $stats = [
            'pajak_bulan'           => $pajak_bulan,
            'pajak_belum_bayar'     => PajakTenant::where('Tenant_id', $Tenant->id)
                                        ->whereIn('status_bayar', ['belum_bayar', 'menunggu_konfirmasi'])
                                        ->sum('nominal_pajak'),
            'total_transaksi'       => Transaksi::where('Tenant_id', $Tenant->id)
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
            'total_tiket'           => TiketBantuan::where('Tenant_id', $Tenant->id)->count(),
            'tiket_menunggu_balasan'=> TiketBantuan::where('Tenant_id', $Tenant->id)->where('status','dibalas')->count(),
        ];

        return view('Tenant.dashboard', compact('Tenant', 'transaksi', 'pajak_list', 'tikets', 'stats'));
    }

    // ═══════════════════════════════════════════════
    // FORM DAFTAR Tenant
    // ═══════════════════════════════════════════════
    public function formDaftar()
    {
        $events = \App\Models\Event::whereIn('status', ['mendatang', 'berjalan'])->get();
        return view('Tenant.daftar', compact('events'));
    }

    public function storeDaftar(Request $request)
    {
        $validated = $request->validate([
            'event_id'         => ['required', 'exists:events,id'],
            'nama_Tenant'      => ['required', 'string', 'max:150'],
            'jenis_usaha'      => ['required', 'string', 'max:100'],
            'deskripsi'        => ['nullable', 'string', 'max:500'],
            'no_kontak'        => ['nullable', 'string', 'max:20'],
        ], [
            'event_id.required'    => 'Event wajib dipilih.',
            'nama_Tenant.required' => 'Nama usaha wajib diisi.',
            'jenis_usaha.required' => 'Jenis usaha wajib dipilih.',
        ]);

        $event = \App\Models\Event::findOrFail($validated['event_id']);

        Tenant::create([
            'user_id'          => Auth::id(),
            'event_id'         => $event->id,
            'nama_Tenant'      => $validated['nama_Tenant'],
            'jenis_usaha'      => $validated['jenis_usaha'],
            'deskripsi'        => $validated['deskripsi'] ?? null,
            'lokasi_di_museum' => $event->lokasi_area, // mengikuti lokasi event
            'no_kontak'        => $validated['no_kontak'] ?? null,
            'persentase_pajak' => 10.00,
            'tarif_sewa'       => $event->harga_sewa_booth,
            'status'           => 'menunggu',
        ]);

        return redirect()->route('Tenant.dashboard')
            ->with('success', 'Pendaftaran event berhasil! Menunggu persetujuan admin.');
    }

    // ═══════════════════════════════════════════════
    // INPUT PENJUALAN
    // ═══════════════════════════════════════════════
    public function penjualan()
    {
        $Tenant    = Auth::user()->Tenant;
        $transaksi = Transaksi::where('Tenant_id', $Tenant?->id)->latest()->paginate(10);
        return view('Tenant.penjualan', compact('transaksi', 'Tenant'));
    }

    public function storePenjualan(Request $request)
    {
        $Tenant = Auth::user()->Tenant;

        if (!$Tenant || $Tenant->status !== 'aktif') {
            return back()->with('error', 'Akun Tenant belum aktif. Tunggu persetujuan admin.');
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
            'Tenant_id'       => $Tenant->id,
            'jenis_transaksi' => 'Pendapatan Tenant',
            'jumlah'          => $validated['jumlah'],
            'metode_bayar'    => $validated['metode_bayar'],
            'status_bayar'    => 'lunas',
            'keterangan'      => $validated['keterangan'],
            'dibayar_pada'    => $validated['tanggal'] ?? now(),
            'created_at'      => $validated['tanggal'] ?? now(),
        ]);

        $nominalPajak = $transaksi->jumlah * ($Tenant->persentase_pajak / 100);
        PajakTenant::create([
            'Tenant_id'         => $Tenant->id,
            'transaksi_id'      => $transaksi->id,
            'pendapatan_kotor'  => $transaksi->jumlah,
            'persentase_pajak'  => $Tenant->persentase_pajak,
            'nominal_pajak'     => $nominalPajak,
            'pendapatan_bersih' => $transaksi->jumlah - $nominalPajak,
            'periode'           => now()->format('Y-m'),
            'status_bayar'      => 'belum_bayar',
        ]);

        return redirect()->route('Tenant.penjualan')
            ->with('success', 'Penjualan dicatat! Pajak ' . $Tenant->persentase_pajak . '% = Rp ' . number_format($nominalPajak, 0, ',', '.'));
    }

    // ═══════════════════════════════════════════════
    // RIWAYAT TRANSAKSI (dengan filter tanggal)
    // ═══════════════════════════════════════════════
    public function riwayat(Request $request)
    {
        $Tenant = Auth::user()->Tenant;

        $query = Transaksi::where('Tenant_id', $Tenant?->id);

        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        $transaksi = $query->latest()->paginate(15)->withQueryString();

        return view('Tenant.riwayat', compact('transaksi', 'Tenant'));
    }

    // ═══════════════════════════════════════════════
    // TAGIHAN PAJAK
    // ═══════════════════════════════════════════════
    public function pajak()
    {
        $Tenant      = Auth::user()->Tenant;
        $pajak       = PajakTenant::where('Tenant_id', $Tenant?->id)->latest()->paginate(10);
        $total_belum = PajakTenant::where('Tenant_id', $Tenant?->id)
                        ->whereIn('status_bayar', ['belum_bayar', 'menunggu_konfirmasi'])
                        ->sum('nominal_pajak');

        return view('Tenant.pajak', compact('pajak', 'total_belum', 'Tenant'));
    }

    public function uploadBuktiBayar(Request $request, $id)
    {
        $Tenant = Auth::user()->Tenant;
        $pajak  = PajakTenant::where('Tenant_id', $Tenant?->id)->findOrFail($id);

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
        $Tenant = Auth::user()->Tenant;
        return view('Tenant.profil', compact('Tenant'));
    }

    public function updateProfil(Request $request)
    {
        $Tenant = Auth::user()->Tenant;

        $validated = $request->validate([
            'nama_Tenant'      => ['required', 'string', 'max:150'],
            'jenis_usaha'      => ['required', 'string', 'max:100'],
            'deskripsi'        => ['nullable', 'string', 'max:500'],
            'no_kontak'        => ['nullable', 'string', 'max:20'],
            'website'          => ['nullable', 'url', 'max:255'],
            'lokasi_di_museum' => ['nullable', 'string', 'max:150'],
            'logo'             => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        if ($request->hasFile('logo')) {
            if ($Tenant->logo_path) {
                Storage::disk('public')->delete($Tenant->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('logo-Tenant', 'public');
        }

        $Tenant->update($validated);

        return back()->with('success', 'Profil usaha berhasil diperbarui.');
    }

    // ═══════════════════════════════════════════════
    // PUSAT BANTUAN
    // ═══════════════════════════════════════════════
    public function bantuan()
    {
        $Tenant = Auth::user()->Tenant;
        $tikets = TiketBantuan::where('Tenant_id', $Tenant?->id)->latest()->get();
        return view('Tenant.bantuan', compact('Tenant', 'tikets'));
    }

    public function storeBantuan(Request $request)
    {
        $Tenant = Auth::user()->Tenant;

        $request->validate([
            'subjek' => 'required|string|max:150',
            'pesan'  => 'required|string|max:2000',
        ], [
            'subjek.required' => 'Subjek tiket wajib diisi.',
            'pesan.required'  => 'Pesan wajib diisi.',
        ]);

        TiketBantuan::create([
            'Tenant_id' => $Tenant->id,
            'subjek'    => $request->subjek,
            'pesan'     => $request->pesan,
            'status'    => 'menunggu',
        ]);

        return back()->with('success', 'Tiket bantuan berhasil dikirim! Admin akan segera merespons.');
    }
}