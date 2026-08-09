<?php

namespace App\Http\Controllers;

use App\Models\Artefak;
use App\Models\TokohPenting;
use App\Models\ArsipSejarah;
use App\Models\LokasiGeografis;

class KoleksiController extends Controller
{
    public function artefak()
    {
        $artefak = Artefak::latest()->paginate(12);
        return view('pengunjung.koleksi.artefak', compact('artefak'));
    }

    public function tokoh()
    {
        $tokoh = TokohPenting::latest()->paginate(12);
        return view('pengunjung.koleksi.tokoh', compact('tokoh'));
    }

    public function arsip()
    {
        $arsip = ArsipSejarah::where('tersedia_publik', true)->latest()->paginate(12);
        return view('pengunjung.koleksi.arsip', compact('arsip'));
    }

    public function lokasi()
    {
        $lokasi = LokasiGeografis::latest()->paginate(12);
        return view('pengunjung.koleksi.lokasi', compact('lokasi'));
    }
}
