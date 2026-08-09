<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Reservasi;
use App\Models\Artefak;

class ReservasiController extends Controller
{
    // Daftar reservasi milik user
    public function index()
    {
        $reservasi = Reservasi::where('user_id', Auth::id())
            ->latest()->paginate(10);
        return view('pengunjung.reservasi.index', compact('reservasi'));
    }

    // Form buat reservasi
    public function create()
    {
        $artefak_dipinjam = Artefak::where('bisa_dipinjam', true)->get();
        return view('pengunjung.reservasi.create', compact('artefak_dipinjam'));
    }
    public function reservasi(Request $request)
    {
    $query = Reservasi::with('user');

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $reservasi = $query->latest()->paginate(15)->withQueryString();

    $stats = [
        'menunggu'  => Reservasi::where('status','menunggu')->count(),
        'disetujui' => Reservasi::where('status','disetujui')->count(),
        'ditolak'   => Reservasi::where('status','ditolak')->count(),
        'selesai'   => Reservasi::where('status','selesai')->count(),
    ];

    return view('admin.reservasi', compact('reservasi','stats'));
    }

    // Simpan reservasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis'              => ['required', 'in:Kunjungan Umum,Kunjungan Rombongan,Kunjungan Riset,Peminjaman Artefak'],
            'tanggal_kunjungan'  => ['required', 'date', 'after_or_equal:tomorrow'],
            'sesi'               => ['required', 'in:Pagi (08.00-12.00),Siang (12.00-16.00),Penuh (08.00-16.00)'],
            'jumlah_orang'       => ['required', 'integer', 'min:1', 'max:100'],
            'opsi_guide'         => ['nullable', 'boolean'],
            'keperluan'          => ['nullable', 'string', 'max:500'],
            'artefak_id'         => ['nullable', 'exists:artefak,id'],
            'tanggal_kembali'    => ['nullable', 'date', 'after:tanggal_kunjungan'],
            'tujuan_peminjaman'  => ['nullable', 'string', 'max:500'],
            'institusi_peminjam' => ['nullable', 'string', 'max:150'],
        ], [
            'jenis.required'             => 'Pilih jenis kunjungan.',
            'tanggal_kunjungan.required' => 'Tanggal kunjungan wajib diisi.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan minimal besok.',
            'sesi.required'              => 'Pilih sesi kunjungan.',
            'jumlah_orang.required'      => 'Jumlah orang wajib diisi.',
            'jumlah_orang.max'           => 'Maksimal 100 orang per reservasi.',
        ]);

        Reservasi::create([
            'user_id'            => Auth::id(),
            'artefak_id'         => $validated['artefak_id'] ?? null,
            'jenis'              => $validated['jenis'],
            'tanggal_kunjungan'  => $validated['tanggal_kunjungan'],
            'sesi'               => $validated['sesi'],
            'jumlah_orang'       => $validated['jumlah_orang'],
            'opsi_guide'         => $request->has('opsi_guide'),
            'keperluan'          => $validated['keperluan'] ?? null,
            'tanggal_kembali'    => $validated['tanggal_kembali'] ?? null,
            'tujuan_peminjaman'  => $validated['tujuan_peminjaman'] ?? null,
            'institusi_peminjam' => $validated['institusi_peminjam'] ?? null,
            'status'             => 'menunggu',
            'kode_booking'       => 'RES-' . strtoupper(Str::random(8)),
        ]);

        return redirect()->route('pengunjung.reservasi.index')
            ->with('success', 'Reservasi berhasil dibuat! Menunggu persetujuan admin.');
    }

    // Detail reservasi
    public function show($id)
    {
        $reservasi = Reservasi::where('user_id', Auth::id())
            ->with(['artefak'])
            ->findOrFail($id);
        return view('pengunjung.reservasi.show', compact('reservasi'));
    }

    // Batalkan reservasi
    public function cancel($id)
    {
        $reservasi = Reservasi::where('user_id', Auth::id())
            ->where('status', 'menunggu')
            ->findOrFail($id);

        $reservasi->update(['status' => 'dibatalkan']);

        return redirect()->route('pengunjung.reservasi.index')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }
}