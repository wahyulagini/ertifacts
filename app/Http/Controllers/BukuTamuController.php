<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTamu;

class BukuTamuController extends Controller
{
    // Menampilkan form publik
    public function create()
    {
        return view('buku_tamu.create');
    }

    // Menyimpan data buku tamu + generate tiket
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengunjung'   => ['required', 'string', 'max:150'],
            'jumlah_orang'      => ['required', 'integer', 'min:1', 'max:500'],
            'tanggal_kunjungan' => ['required', 'date'],
            'butuh_guide'       => ['nullable', 'boolean'],
            'saran_komentar'    => ['nullable', 'string', 'max:1000'],
            'email'             => ['nullable', 'email', 'max:150'],
            'jenis_tiket'       => ['required', 'in:reguler,pelajar'],
        ]);

        $validated['butuh_guide']  = $request->has('butuh_guide');
        $validated['kode_tiket']   = BukuTamu::generateKodeTiket();
        $validated['total_harga']  = BukuTamu::hitungHarga($validated['jenis_tiket'], $validated['jumlah_orang'], $validated['butuh_guide']);
        $validated['status_bayar'] = 'belum_bayar';

        $bukuTamu = BukuTamu::create($validated);

        return redirect()->route('buku-tamu.payment', $bukuTamu->kode_tiket);
    }

    // Halaman pembayaran QRIS
    public function payment($kode)
    {
        $bukuTamu = BukuTamu::where('kode_tiket', $kode)->firstOrFail();

        // Jika sudah lunas, langsung ke tiket
        if ($bukuTamu->status_bayar === 'lunas') {
            return redirect()->route('buku-tamu.tiket', $kode);
        }

        return view('buku_tamu.payment', compact('bukuTamu'));
    }

    // Konfirmasi pembayaran (simulasi)
    public function confirmPayment(Request $request, $kode)
    {
        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $bukuTamu = BukuTamu::where('kode_tiket', $kode)->firstOrFail();

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $bukuTamu->update([
            'status_bayar' => 'lunas',
            'dibayar_pada' => now(),
            'bukti_pembayaran' => $path,
        ]);

        return redirect()->route('buku-tamu.tiket', $kode)
            ->with('success', 'Pembayaran berhasil dikonfirmasi beserta bukti! Silakan download tiket Anda.');
    }

    // Halaman tiket digital
    public function tiket($kode)
    {
        $bukuTamu = BukuTamu::where('kode_tiket', $kode)->firstOrFail();

        if ($bukuTamu->status_bayar !== 'lunas') {
            return redirect()->route('buku-tamu.payment', $kode)
                ->with('error', 'Silakan selesaikan pembayaran terlebih dahulu.');
        }

        return view('buku_tamu.tiket', compact('bukuTamu'));
    }
}
