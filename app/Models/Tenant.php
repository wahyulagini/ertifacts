<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    // ✅ nama tabel: tenants (bukan tenant)
    protected $table = 'tenants';

    protected $fillable = [
        'user_id', 'event_id', 'nama_tenant', 'jenis_usaha', 'deskripsi',
        'lokasi_di_museum', 'logo_path', 'no_kontak', 'website',
        'tarif_sewa', 'persentase_pajak', 'status',
        'catatan_admin', 'disetujui_pada',
    ];

    protected $casts = [
        'tarif_sewa'       => 'decimal:2',
        'persentase_pajak' => 'decimal:2',
        'disetujui_pada'   => 'datetime',
    ];

    // Relasi
    public function user()        { return $this->belongsTo(User::class); }
    public function event()       { return $this->belongsTo(Event::class); }
    public function transaksi()   { return $this->hasMany(Transaksi::class); }
    public function pajakTenant() { return $this->hasMany(PajakTenant::class); }
    public function tiketBantuan(){ return $this->hasMany(TiketBantuan::class); }

    // Helpers
    public function isAktif()    { return $this->status === 'aktif'; }
    public function isMenunggu() { return $this->status === 'menunggu'; }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo_path
            ? asset($this->logo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode(substr($this->nama_tenant, 0, 1)) . '&background=C9963A&color=321F0E&size=80';
    }

    public function getTarifSewaRpAttribute(): string
    {
        return 'Rp ' . number_format($this->tarif_sewa, 0, ',', '.');
    }

    public function getTotalPajakBelumBayarAttribute(): float
    {
        return (float) $this->pajakTenant()->where('status_bayar', 'belum_bayar')->sum('nominal_pajak');
    }
}
