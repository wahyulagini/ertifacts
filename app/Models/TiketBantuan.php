<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketBantuan extends Model
{
    protected $table = 'tiket_bantuan';

    protected $fillable = [
        'tenant_id',
        'subjek',
        'pesan',
        'status',
        'balasan_admin',
        'dibalas_pada',
    ];

    protected $casts = [
        'dibalas_pada' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'badge-yellow',
            'dibalas'  => 'badge-green',
            'ditutup'  => 'badge-gray',
            default    => 'badge-gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'Menunggu',
            'dibalas'  => 'Dibalas',
            'ditutup'  => 'Ditutup',
            default    => $this->status,
        };
    }
}
