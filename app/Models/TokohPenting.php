<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TokohPenting extends Model
{
    use HasFactory;

    protected $table = 'tokoh_penting';

    protected $fillable = [
        'nama_tokoh',
        'nama_julukan',
        'gelar',
        'peran',
        'era_aktif',
        'tahun_lahir',
        'tahun_wafat',
        'tempat_asal',
        'biografi',
        'kontribusi',
        'gambar_path',
        'sumber_referensi',
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
        return "https://placehold.co/400x500/F4ECE1/4A2E14?text=" . urlencode($this->nama_tokoh);
    }

    public function getPeriodeLabelAttribute(): string
    {
        if ($this->tahun_lahir && $this->tahun_wafat) {
            return "{$this->tahun_lahir} - {$this->tahun_wafat}";
        }
        return $this->era_aktif ?? 'Tidak Diketahui';
    }
}
