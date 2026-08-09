<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Artefak;
use App\Models\Tenant;
use App\Models\Reservasi;
use App\Models\Transaksi;
use App\Models\PajakTenant;
use App\Models\BukuTamu;

class DashboardController extends Controller
{
    // ═══════════════════════════════════════
    // PENGUNJUNG
    // ═══════════════════════════════════════
    public function pengunjung()
    {
        $user = Auth::user();

        try { $reservasi = Reservasi::where('user_id', $user->id)->latest()->take(5)->get(); }
        catch (\Exception $e) { $reservasi = collect(); }

        try { $tenant_aktif = Tenant::where('status','aktif')->take(5)->get(); }
        catch (\Exception $e) { $tenant_aktif = collect(); }

        $stats = [
            'total_reservasi' => $reservasi->count(),
            'menunggu'        => $reservasi->where('status','menunggu')->count(),
            'disetujui'       => $reservasi->where('status','disetujui')->count(),
            'total_artefak'   => $this->safe(fn() => Artefak::count()),
        ];

        return view('pengunjung.dashboard', compact('reservasi','stats','tenant_aktif'));
    }

    // ═══════════════════════════════════════
    // ADMIN
    // ═══════════════════════════════════════
   public function admin()
{
    try { $buku_tamu_terbaru = BukuTamu::latest()->take(6)->get(); }
    catch (\Exception $e) { $buku_tamu_terbaru = collect(); }

    try { $tenant_pending = Tenant::where('status','menunggu')->with('user')->latest()->take(5)->get(); }
    catch (\Exception $e) { $tenant_pending = collect(); }

    $tiket_bulan = $this->safe(fn() => BukuTamu::where('status_bayar','lunas')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('total_harga'));

    $sewa_bulan  = $this->safe(fn() => Transaksi::where('jenis_transaksi','Sewa Tempat tenant')
                    ->where('status_bayar','lunas')
                    ->whereMonth('created_at', now()->month)->sum('jumlah'));

    // Tagihan sewa booth yang sudah terkonfirmasi
    $pajak_bulan = $this->safe(fn() => PajakTenant::where('status_bayar','sudah_bayar')
                    ->whereMonth('created_at', now()->month)->sum('nominal_pajak'));

    $stats = [
        'total_user'         => $this->safe(fn() => User::count()),
        'kunjungan_hari_ini' => $this->safe(fn() => BukuTamu::whereDate('created_at', today())->count()),
        'tenant_aktif'       => $this->safe(fn() => Tenant::where('status','aktif')->count()),

        // Pendapatan museum = Tiket Masuk (BukuTamu) + Sewa Tenant + Tagihan Sewa Booth terkonfirmasi
        'pendapatan_bulan'   => $tiket_bulan + $sewa_bulan + $pajak_bulan,

        'menunggu_tenant'    => $this->safe(fn() => Tenant::where('status','menunggu')->count()),
        'tiket_bulan'        => $tiket_bulan,
        'sewa_bulan'         => $sewa_bulan,
        'pajak_bulan'        => $pajak_bulan,
    ];

    return view('admin.dashboard', compact('buku_tamu_terbaru','tenant_pending','stats'));
}

    // ═══════════════════════════════════════
    // TENANT
    // ═══════════════════════════════════════
   public function tenant()
{
    $user   = Auth::user();
    $tenant = null;

    try { $tenant = Tenant::where('user_id', $user->id)->first(); }
    catch (\Exception $e) {}

    $transaksi = collect();
    $pajak_list = collect();
    $stats = [
        'total_transaksi'   => 0,
        'pendapatan_bulan'  => 0,
        'pajak_bulan'       => 0,
        'bersih_bulan'      => 0,
        'pajak_belum_bayar' => 0,
    ];

    if ($tenant) {
        try {
            $transaksi  = Transaksi::where('tenant_id',$tenant->id)->with('pajakTenant')->latest()->take(8)->get();
            $pajak_list = PajakTenant::where('tenant_id',$tenant->id)->latest()->get();
            $pendapatan = Transaksi::where('tenant_id',$tenant->id)->where('status_bayar','lunas')->whereMonth('created_at',now()->month)->sum('jumlah');
            $pajak      = PajakTenant::where('tenant_id',$tenant->id)->where('periode',now()->format('Y-m'))->sum('nominal_pajak');
            $stats = [
                'total_transaksi'   => Transaksi::where('tenant_id',$tenant->id)->count(),
                'pendapatan_bulan'  => $pendapatan,
                'pajak_bulan'       => $pajak,
                'bersih_bulan'      => $pendapatan - $pajak,
                'pajak_belum_bayar' => PajakTenant::where('tenant_id',$tenant->id)->where('status_bayar','belum_bayar')->sum('nominal_pajak'),
            ];
        } catch (\Exception $e) {}
    }

    return view('tenant.dashboard', compact('transaksi','stats','tenant','pajak_list'));
}

    // ═══════════════════════════════════════
    // PROFIL (semua role)
    // ═══════════════════════════════════════
    public function profil()
    {
        $user = Auth::user();
        $view = match($user->role) {
            'admin'  => 'admin.profil',
            'tenant'  => 'tenant.profil',
            default  => 'pengunjung.profil',
        };
        return view($view, compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name'         => ['required','string','max:150'],
            'phone'        => ['nullable','string','max:20'],
            'alamat'       => ['nullable','string','max:255'],
            'password'     => ['nullable','min:8','confirmed'],
        ],[
            'name.required'      => 'Nama wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->name   = $validated['name'];
        $user->phone  = $validated['phone'] ?? $user->phone;
        $user->alamat = $validated['alamat'] ?? $user->alamat;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();
        $route = match($user->role) {
            'admin'  => 'admin.dashboard',
            'tenant'  => 'tenant.dashboard',
            default  => 'pengunjung.dashboard',
        };

        return redirect()->route($route)->with('success','Profil berhasil diperbarui!');
    }

    // Helper aman jika tabel belum ada
    private function safe(\Closure $fn, $default = 0)
    {
        try { return $fn(); } catch (\Exception $e) { return $default; }
    }
}