<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'alamat', 'foto_profil',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // Role helpers
    public function isAdmin()      { return $this->role === 'admin'; }
    public function isTenant()      { return $this->role === 'Tenant'; }
    public function isPengunjung() { return $this->role === 'pengunjung'; }

    // Relasi
    public function reservasi()  { return $this->hasMany(Reservasi::class); }
    public function Tenant()     { return $this->hasOne(Tenant::class); }   // ✅ hasOne Tenant
    public function transaksi()  { return $this->hasMany(Transaksi::class); }

    // Accessor foto
    public function getFotoUrlAttribute(): string
    {
        return $this->foto_profil
            ? asset($this->foto_profil)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=321F0E&color=C9963A&size=80';
    }
}
