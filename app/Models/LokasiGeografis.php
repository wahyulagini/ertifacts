<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LokasiGeografis extends Model
{
    use HasFactory;

    protected $table = 'lokasi_geografis';

    protected $fillable = [
        'nama_lokasi',
        'jenis_lokasi',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'latitude',
        'longitude',
        'deskripsi',
        'periode_sejarah',
        'status_kelola',
        'pengelola',
        'jam_operasional',
        'gambar_path',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

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
        return "https://placehold.co/600x400/F4ECE1/4A2E14?text=" . urlencode($this->nama_lokasi);
    }

    public function getAlamatLengkapAttribute(): string
    {
        return collect([$this->kecamatan, $this->kabupaten_kota, $this->provinsi])
            ->filter()
            ->implode(', ');
    }

    /**
     * Return true if the location has valid GPS coordinates for the map.
     */
    public function hasCoordinates(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }
}
