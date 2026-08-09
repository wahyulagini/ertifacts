<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArsipSejarah extends Model
{
    use HasFactory;

    protected $table = 'arsip_sejarah';

    protected $fillable = [
        'kode_arsip',
        'judul_arsip',
        'jenis_koleksi',
        'bahasa',
        'tahun_dokumen',
        'asal_instansi',
        'deskripsi_isi',
        'kondisi_fisik',
        'lokasi_penyimpanan',
        'file_digital_path',
        'gambar_thumbnail',
        'tersedia_publik',
        'pengunggah',
    ];

    protected $casts = [
        'tersedia_publik' => 'boolean',
    ];

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->gambar_thumbnail) {
            if (str_starts_with($this->gambar_thumbnail, 'http')) {
                return $this->gambar_thumbnail;
            }
            if (str_starts_with($this->gambar_thumbnail, '/')) {
                return asset($this->gambar_thumbnail);
            }
            return asset('storage/' . $this->gambar_thumbnail);
        }
        return "https://placehold.co/400x300/F4ECE1/4A2E14?text=" . urlencode($this->judul_arsip);
    }

    public function getJenisIconAttribute(): string
    {
        return match($this->jenis_koleksi) {
            'Naskah Kuno'           => 'fa-scroll',
            'Foto Bersejarah'       => 'fa-image',
            'Peta Kuno'             => 'fa-map',
            'Surat / Dokumen Resmi' => 'fa-envelope-open-text',
            'Rekaman Audio'         => 'fa-headphones',
            'Rekaman Video'         => 'fa-video',
            'Laporan Arkeologi'     => 'fa-file-lines',
            default                 => 'fa-archive',
        };
    }
}
