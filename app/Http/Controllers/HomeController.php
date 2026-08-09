<?php

namespace App\Http\Controllers;

use App\Models\Artefak;
use App\Models\TokohPenting;
use App\Models\ArsipSejarah;
use App\Models\LokasiGeografis;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $artefaks    = Artefak::orderBy('kode_registrasi')->get();
        $tokoh       = TokohPenting::orderBy('tahun_lahir')->get();
        $arsip       = ArsipSejarah::orderBy('kode_arsip')->get();
        $lokasi      = LokasiGeografis::orderBy('nama_lokasi')->get();

        // Statistik ringkasan untuk hero section
        $stats = [
            'total_artefak' => $artefaks->count(),
            'total_tokoh'   => $tokoh->count(),
            'total_arsip'   => $arsip->count(),
            'total_lokasi'  => $lokasi->count(),
        ];

        return view('home', compact('artefaks', 'tokoh', 'arsip', 'lokasi', 'stats'));
    }

    /**
     * API endpoint: return single artifact as JSON (for JS AJAX if needed)
     */
    public function getArtefak(Artefak $artefak)
    {
        return response()->json([
            'id'                   => $artefak->id,
            'nama_artefak'         => $artefak->nama_artefak,
            'nama_lokal'           => $artefak->nama_lokal,
            'era_periodisasi'      => $artefak->era_periodisasi,
            'kode_registrasi'      => $artefak->kode_registrasi,
            'asal_daerah'          => $artefak->asal_daerah,
            'periode_abad'         => $artefak->periode_abad,
            'kategori'             => $artefak->kategori,
            'bahan_utama'          => $artefak->bahan_utama,
            'dimensi'              => $artefak->dimensi,
            'berat'                => $artefak->berat,
            'teknik_pembuatan'     => $artefak->teknik_pembuatan,
            'deskripsi'            => $artefak->deskripsi,
            'gambar_url'           => $artefak->gambar_url,
            'situs_penemuan'       => $artefak->situs_penemuan,
            'lokasi_administratif' => $artefak->lokasi_administratif,
            'tanggal_ditemukan'    => $artefak->tanggal_ditemukan?->format('d F Y'),
            'penemu'               => $artefak->penemu,
            'kondisi_lingkungan'   => $artefak->kondisi_lingkungan,
            'persentase_keutuhan'  => $artefak->persentase_keutuhan,
            'status_kondisi'       => $artefak->status_kondisi,
            'tanggal_pemeriksaan'  => $artefak->tanggal_pemeriksaan?->format('d F Y'),
            'catatan_konservasi'   => $artefak->catatan_konservasi,
            'health_color'         => $artefak->health_color,
        ]);
    }
}
