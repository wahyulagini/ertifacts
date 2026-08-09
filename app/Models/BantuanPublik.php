<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BantuanPublik extends Model
{
    protected $table = 'bantuan_publik';

    protected $fillable = [
        'nama',
        'email',
        'subjek',
        'pesan',
        'status',
        'balasan_admin',
        'dibalas_pada',
    ];

    protected $casts = [
        'dibalas_pada' => 'datetime',
    ];

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
