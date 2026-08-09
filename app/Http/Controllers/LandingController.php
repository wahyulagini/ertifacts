<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artefak;
use App\Models\TokohPenting;
use App\Models\ArsipSejarah;
use App\Models\LokasiGeografis;
use App\Models\Event;

class LandingController extends Controller
{
    public function index()
    {
        $artefaks = Artefak::latest()->take(6)->get();
        $tokohs = TokohPenting::latest()->take(6)->get();
        $arsips = ArsipSejarah::latest()->take(6)->get();
        $lokasis = LokasiGeografis::latest()->take(6)->get();
        $events = Event::whereIn('status', ['mendatang', 'berjalan'])->orderBy('tanggal_mulai')->get();

        return view('landing', compact('artefaks', 'tokohs', 'arsips', 'lokasis', 'events'));
    }

    public function koleksi(Request $request)
    {
        $type = $request->get('type', 'artefak');
        $query = $request->get('q', '');

        if ($type === 'artefak') {
            $data = Artefak::where('nama_artefak', 'like', "%{$query}%")->paginate(12);
        } elseif ($type === 'tokoh') {
            $data = TokohPenting::where('nama_tokoh', 'like', "%{$query}%")->paginate(12);
        } elseif ($type === 'arsip') {
            $data = ArsipSejarah::where('judul_arsip', 'like', "%{$query}%")->paginate(12);
        } else {
            $data = LokasiGeografis::where('nama_lokasi', 'like', "%{$query}%")->paginate(12);
        }

        return view('koleksi', compact('data', 'type', 'query'));
    }
}
