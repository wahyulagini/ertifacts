<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BantuanPublik;

class BantuanPublikController extends Controller
{
    // Halaman FAQ + Form bantuan
    public function index()
    {
        return view('bantuan_publik');
    }

    // Simpan tiket bantuan publik
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => ['required', 'string', 'max:150'],
            'email'  => ['required', 'email', 'max:150'],
            'subjek' => ['required', 'string', 'max:200'],
            'pesan'  => ['required', 'string', 'max:2000'],
        ]);

        BantuanPublik::create($validated);

        return redirect()->route('bantuan-publik.index')
            ->with('success', 'Tiket bantuan Anda berhasil dikirim! Admin akan merespons melalui email Anda.');
    }
}
