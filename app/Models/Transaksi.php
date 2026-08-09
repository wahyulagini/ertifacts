<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id', 'reservasi_id', 'Tenant_id',
        'jenis_transaksi', 'jumlah', 'kode_transaksi',
        'metode_bayar', 'status_bayar', 'keterangan', 'dibayar_pada',
    ];

    protected $casts = [
        'jumlah'       => 'decimal:2',
        'dibayar_pada' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($t) {
            if (empty($t->kode_transaksi)) {
                $t->kode_transaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });
    }

public function user()       { return $this->belongsTo(User::class); }
public function reservasi()  { return $this->belongsTo(Reservasi::class); }
public function Tenant()     { return $this->belongsTo(Tenant::class); }
public function pajakTenant(){ return $this->hasOne(PajakTenant::class); }

    public function getJumlahRpAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }
}