<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    use HasFactory;

    protected $table = 'buku_tamu';

    protected $fillable = [
        'kode_tiket',
        'nama_pengunjung',
        'jumlah_orang',
        'tanggal_kunjungan',
        'butuh_guide',
        'saran_komentar',
        'email',
        'jenis_tiket',
        'total_harga',
        'status_bayar',
        'metode_bayar',
        'dibayar_pada',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'butuh_guide'       => 'boolean',
        'dibayar_pada'      => 'datetime',
    ];

    // ── Harga Tiket ──
    const HARGA_REGULER = 15000;
    const HARGA_PELAJAR = 10000;
    const HARGA_GUIDE   = 50000;

    public static function hitungHarga(string $jenis, int $jumlah, bool $butuhGuide = false): int
    {
        $harga = $jenis === 'pelajar' ? self::HARGA_PELAJAR : self::HARGA_REGULER;
        $total = $harga * $jumlah;
        
        if ($butuhGuide) {
            $total += self::HARGA_GUIDE;
        }

        return $total;
    }

    public static function generateKodeTiket(): string
    {
        $prefix = 'TKT-' . now()->format('Ymd') . '-';
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        return $prefix . $random;
    }

    // ── Accessors ──
    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status_bayar) {
            'belum_bayar' => 'badge-yellow',
            'menunggu'    => 'badge-blue',
            'lunas'       => 'badge-green',
            default       => 'badge-gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status_bayar) {
            'belum_bayar' => 'Belum Bayar',
            'menunggu'    => 'Menunggu',
            'lunas'       => 'Lunas',
            default       => $this->status_bayar,
        };
    }
}
