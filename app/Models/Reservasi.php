<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $fillable = [
        'user_id', 'artefak_id', 'jenis', 'tanggal_kunjungan',
        'sesi', 'jumlah_orang', 'opsi_guide', 'keperluan',
        'tanggal_kembali', 'tujuan_peminjaman', 'institusi_peminjam',
        'status', 'kode_booking', 'catatan_admin', 'disetujui_pada',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'tanggal_kembali'   => 'date',
        'disetujui_pada'    => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($r) {
            if (empty($r->kode_booking)) {
                $r->kode_booking = 'RES-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()      { return $this->belongsTo(User::class); }
    public function artefak()   { return $this->belongsTo(Artefak::class); }
    public function transaksi() { return $this->hasOne(Transaksi::class); }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'menunggu'   => 'badge-yellow',
            'disetujui'  => 'badge-green',
            'ditolak'    => 'badge-red',
            'selesai'    => 'badge-blue',
            'dibatalkan' => 'badge-gray',
            default      => 'badge-gray',
        };
    }
}