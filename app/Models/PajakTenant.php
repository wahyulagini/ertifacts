<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PajakTenant extends Model
{
    protected $table = 'pajak_Tenant';

    protected $fillable = [
        'Tenant_id', 'transaksi_id',
        'pendapatan_kotor', 'persentase_pajak',
        'nominal_pajak', 'pendapatan_bersih',
        'periode', 'status_bayar', 'dibayar_pada', 'catatan',
        'bukti_bayar_path',
    ];

    protected $casts = [
        'pendapatan_kotor'  => 'decimal:2',
        'persentase_pajak'  => 'decimal:2',
        'nominal_pajak'     => 'decimal:2',
        'pendapatan_bersih' => 'decimal:2',
        'dibayar_pada'      => 'datetime',
    ];

    public function Tenant()    { return $this->belongsTo(Tenant::class); }
    public function transaksi() { return $this->belongsTo(Transaksi::class); }

    public function getNominalPajakRpAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal_pajak, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status_bayar) {
            'belum_bayar'         => 'Belum Bayar',
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'sudah_bayar'         => 'Lunas',
            'ditunda'             => 'Ditunda',
            default               => $this->status_bayar,
        };
    }
}