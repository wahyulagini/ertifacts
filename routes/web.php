<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\KoleksiController;
use App\Http\Controllers\LandingController;

// ══════════════════════════════════════════
// PUBLIC ROUTES
// ══════════════════════════════════════════
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/koleksi-museum', [LandingController::class, 'koleksi'])->name('landing.koleksi');

// Route Buku Tamu Publik
Route::get('/buku-tamu', [App\Http\Controllers\BukuTamuController::class, 'create'])->name('buku-tamu.create');
Route::post('/buku-tamu', [App\Http\Controllers\BukuTamuController::class, 'store'])->name('buku-tamu.store');
Route::get('/buku-tamu/bayar/{kode}', [App\Http\Controllers\BukuTamuController::class, 'payment'])->name('buku-tamu.payment');
Route::post('/buku-tamu/bayar/{kode}', [App\Http\Controllers\BukuTamuController::class, 'confirmPayment'])->name('buku-tamu.confirm');
Route::get('/buku-tamu/tiket/{kode}', [App\Http\Controllers\BukuTamuController::class, 'tiket'])->name('buku-tamu.tiket');

// Route Bantuan Publik
Route::get('/bantuan', [App\Http\Controllers\BantuanPublikController::class, 'index'])->name('bantuan-publik.index');
Route::post('/bantuan', [App\Http\Controllers\BantuanPublikController::class, 'store'])->name('bantuan-publik.store');

// ══════════════════════════════════════════
// GUEST ONLY
// ══════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',    [LoginController::class, 'login'])->name('login.post');
    Route::get('/register',  [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')->name('logout');

// ══════════════════════════════════════════
// SEMUA YANG LOGIN
// ══════════════════════════════════════════
Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return match (auth()->user()->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'tenant' => redirect()->route('tenant.dashboard'),
            default  => redirect()->route('pengunjung.dashboard'),
        };
    })->name('home');
    // ── GRUP PENGUNJUNG ─────────────────────────────────────────
    Route::middleware('role:pengunjung')
        ->prefix('pengunjung')
        ->name('pengunjung.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'pengunjung'])->name('dashboard');
        });

    // ── GRUP ADMIN (PENGELOLA) ──────────────────────────────────
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        });

    // ── PENGUNJUNG ────────────────────────
    Route::middleware('role:pengunjung')
        ->prefix('pengunjung')->name('pengunjung.')
        ->group(function () {
            Route::get('/dashboard',             [DashboardController::class, 'pengunjung'])->name('dashboard');
            Route::get('/reservasi',             [ReservasiController::class, 'index'])->name('reservasi.index');
            Route::get('/reservasi/buat',        [ReservasiController::class, 'create'])->name('reservasi.create');
            Route::post('/reservasi',            [ReservasiController::class, 'store'])->name('reservasi.store');
            Route::get('/reservasi/{id}',        [ReservasiController::class, 'show'])->name('reservasi.show');
            Route::post('/reservasi/{id}/batal', [ReservasiController::class, 'cancel'])->name('reservasi.cancel');
            Route::get('/transaksi',             [TransaksiController::class, 'pengunjung'])->name('transaksi.index');
            Route::get('/profil',                [DashboardController::class, 'profil'])->name('profil');
            Route::post('/profil',               [DashboardController::class, 'updateProfil'])->name('profil.update');

            // (Fitur koleksi pengunjung telah dipindahkan ke Landing Page)
        });

    // ── TENANT ─────────────────────────────
    Route::middleware('role:tenant')
    ->prefix('tenant')
    ->name('tenant.')
    ->group(function () {
        Route::get('/dashboard', [TenantController::class, 'dashboard'])->name('dashboard');

        Route::get('/daftar',  [TenantController::class, 'formDaftar'])->name('daftar');
        Route::post('/daftar', [TenantController::class, 'storeDaftar'])->name('daftar.store');

        Route::get('/penjualan',  [TenantController::class, 'penjualan'])->name('penjualan');
        Route::post('/penjualan', [TenantController::class, 'storePenjualan'])->name('penjualan.store');

        Route::get('/riwayat', [TenantController::class, 'riwayat'])->name('riwayat');
        Route::get('/riwayat-transaksi', [TenantController::class, 'riwayat'])->name('transaksi');
        
        Route::get('/pajak', [TenantController::class, 'pajak'])->name('pajak');
        Route::post('/pajak/{id}/upload', [TenantController::class, 'uploadBuktiBayar'])->name('pajak.upload');
        Route::post('/pajak/{id}/bayar', [TenantController::class, 'uploadBuktiBayar'])->name('pajak.bayar');

        Route::get('/profil',  [TenantController::class, 'profil'])->name('profil');
        Route::post('/profil', [TenantController::class, 'updateProfil'])->name('profil.update');

        // Pusat Bantuan
        Route::get('/bantuan',  [TenantController::class, 'bantuan'])->name('bantuan');
        Route::post('/bantuan', [TenantController::class, 'storeBantuan'])->name('bantuan.store');
    });
    // ── ADMIN ─────────────────────────────
    Route::middleware('role:admin')
        ->prefix('admin')->name('admin.')
        ->group(function () {
            Route::get('/dashboard',                  [DashboardController::class, 'admin'])->name('dashboard');
            Route::get('/reservasi',                  [AdminController::class, 'reservasi'])->name('reservasi');
            Route::post('/reservasi/{id}/setuju',     [AdminController::class, 'setujuReservasi'])->name('reservasi.setuju');
            Route::post('/reservasi/{id}/tolak',      [AdminController::class, 'tolakReservasi'])->name('reservasi.tolak');
            Route::post('/reservasi/{id}/selesai',    [AdminController::class, 'selesaiReservasi'])->name('reservasi.selesai');
            Route::get('/tenant',                      [AdminController::class, 'tenant'])->name('tenant');
            Route::post('/tenant/{id}/setuju',         [AdminController::class, 'setujuTenant'])->name('tenant.setuju');
            Route::post('/tenant/{id}/tolak',          [AdminController::class, 'tolakTenant'])->name('tenant.tolak');
            Route::get('/keuangan',                   [AdminController::class, 'keuangan'])->name('keuangan');
            Route::get('/pajak',                      [AdminController::class, 'pajak'])->name('pajak');
            Route::post('/pajak/{id}/konfirmasi',     [AdminController::class, 'konfirmasiPajak'])->name('pajak.konfirmasi');
            Route::post('/pajak/{id}/tolak',          [AdminController::class, 'tolakPajak'])->name('pajak.tolak');
            Route::get('/artefak',                    [AdminController::class, 'artefak'])->name('artefak');
            Route::get('/artefak/create',             [AdminController::class, 'createArtefak'])->name('artefak.create');
            Route::post('/artefak',                   [AdminController::class, 'storeArtefak'])->name('artefak.store');
            Route::get('/artefak/{id}/edit',          [AdminController::class, 'editArtefak'])->name('artefak.edit');
            Route::put('/artefak/{id}',               [AdminController::class, 'updateArtefak'])->name('artefak.update');
            Route::delete('/artefak/{id}',            [AdminController::class, 'destroyArtefak'])->name('artefak.destroy');
            Route::get('/tokoh',                      [AdminController::class, 'tokoh'])->name('tokoh');
            Route::get('/tokoh/create',               [AdminController::class, 'createTokoh'])->name('tokoh.create');
            Route::post('/tokoh',                     [AdminController::class, 'storeTokoh'])->name('tokoh.store');
            Route::get('/tokoh/{id}/edit',            [AdminController::class, 'editTokoh'])->name('tokoh.edit');
            Route::put('/tokoh/{id}',                 [AdminController::class, 'updateTokoh'])->name('tokoh.update');
            Route::delete('/tokoh/{id}',              [AdminController::class, 'destroyTokoh'])->name('tokoh.destroy');
            Route::get('/arsip',                      [AdminController::class, 'arsip'])->name('arsip');
            Route::get('/arsip/create',               [AdminController::class, 'createArsip'])->name('arsip.create');
            Route::post('/arsip',                     [AdminController::class, 'storeArsip'])->name('arsip.store');
            Route::get('/arsip/{id}/edit',            [AdminController::class, 'editArsip'])->name('arsip.edit');
            Route::put('/arsip/{id}',                 [AdminController::class, 'updateArsip'])->name('arsip.update');
            Route::delete('/arsip/{id}',              [AdminController::class, 'destroyArsip'])->name('arsip.destroy');
            Route::get('/lokasi',                     [AdminController::class, 'lokasi'])->name('lokasi');
            Route::get('/lokasi/create',              [AdminController::class, 'createLokasi'])->name('lokasi.create');
            Route::post('/lokasi',                    [AdminController::class, 'storeLokasi'])->name('lokasi.store');
            Route::get('/lokasi/{id}/edit',           [AdminController::class, 'editLokasi'])->name('lokasi.edit');
            Route::put('/lokasi/{id}',                [AdminController::class, 'updateLokasi'])->name('lokasi.update');
            Route::delete('/lokasi/{id}',             [AdminController::class, 'destroyLokasi'])->name('lokasi.destroy');
            Route::get('/users',                      [AdminController::class, 'users'])->name('users.index');
            Route::get('/users/create',               [RegisterController::class, 'adminShowForm'])->name('users.create');
            Route::post('/users',                     [RegisterController::class, 'adminStore'])->name('users.store');
            Route::get('/buku-tamu',                  [AdminController::class, 'bukuTamu'])->name('buku-tamu.index');
            Route::get('/events',                     [AdminController::class, 'events'])->name('events.index');
            Route::get('/events/create',              [AdminController::class, 'createEvent'])->name('events.create');
            Route::post('/events',                    [AdminController::class, 'storeEvent'])->name('events.store');
            Route::get('/events/{id}/edit',           [AdminController::class, 'editEvent'])->name('events.edit');
            Route::put('/events/{id}',                [AdminController::class, 'updateEvent'])->name('events.update');
            Route::delete('/events/{id}',             [AdminController::class, 'destroyEvent'])->name('events.destroy');
            Route::get('/tiket-bantuan',              [AdminController::class, 'tiketBantuan'])->name('tiket-bantuan.index');
            Route::post('/tiket-bantuan/{id}/balas',  [AdminController::class, 'balasTiketBantuan'])->name('tiket-bantuan.balas');
            Route::post('/tiket-bantuan/{id}/tutup',  [AdminController::class, 'tutupTiketBantuan'])->name('tiket-bantuan.tutup');
            Route::get('/bantuan-publik',             [AdminController::class, 'bantuanPublik'])->name('bantuan-publik.index');
            Route::post('/bantuan-publik/{id}/balas', [AdminController::class, 'balasBantuanPublik'])->name('bantuan-publik.balas');
            Route::post('/bantuan-publik/{id}/tutup', [AdminController::class, 'tutupBantuanPublik'])->name('bantuan-publik.tutup');
        });
});