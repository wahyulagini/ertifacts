<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artefak extends Model
{
    use HasFactory;

    protected $table = 'artefak';

    protected $fillable = [
        'kode_registrasi', 'nama_artefak', 'nama_lokal',
        'era_periodisasi', 'periode_abad', 'kategori', 'asal_daerah',
        'bahan_utama', 'dimensi', 'berat', 'teknik_pembuatan', 'deskripsi',
        'gambar_path', 'situs_penemuan', 'lokasi_administratif',
        'tanggal_ditemukan', 'penemu', 'kondisi_lingkungan',
        'persentase_keutuhan', 'status_kondisi',
        'tanggal_pemeriksaan', 'catatan_konservasi', 'bisa_dipinjam',
    ];

    protected $casts = [
        'tanggal_ditemukan'  => 'date',
        'tanggal_pemeriksaan'=> 'date',
        'bisa_dipinjam'      => 'boolean',
    ];

    // ── Relasi ────────────────────────────────────────────────
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar_path) {
            if (str_starts_with($this->gambar_path, 'http')) {
                return $this->gambar_path;
            }
            if (str_starts_with($this->gambar_path, '/')) {
                return asset($this->gambar_path);
            }
            return asset('storage/' . $this->gambar_path);
        }
        return "https://placehold.co/600x600/F4ECE1/4A2E14?text=" . urlencode($this->nama_artefak);
    }

    public function getHealthColorAttribute(): string
    {
        if ($this->persentase_keutuhan >= 80) return 'bg-emerald-500';
        if ($this->persentase_keutuhan >= 50) return 'bg-yellow-500';
        return 'bg-red-500';
    }

    // Cek apakah artefak sedang dipinjam (ada reservasi aktif)
    public function getSedangDipinjamAttribute(): bool
    {
        return $this->reservasi()
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->where('jenis', 'Peminjaman Artefak')
            ->exists();
    }
}