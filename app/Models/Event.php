<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'judul_event', 'deskripsi', 'gambar_path', 'tanggal_mulai', 'tanggal_selesai',
        'lokasi_area', 'kuota_Tenant', 'harga_sewa_booth', 'status'
    ];

    public function Tenants()
    {
        return $this->hasMany(Tenant::class);
    }
}
