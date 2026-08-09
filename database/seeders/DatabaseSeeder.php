<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── ADMIN ─────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@ertifact.id'],
            [
                'name'     => 'Admin E-RTIFACT',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'phone'    => '08110000001',
            ]
        );

        // ── Tenant ─────────────────────────────────────────────
        $Tenant = User::updateOrCreate(
            ['email' => 'Tenant@ertifact.id'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role'     => 'Tenant',
                'phone'    => '08220000002',
            ]
        );

        // Data Tenant-nya (relasi user_id → Tenants)
        Tenant::updateOrCreate(
            ['user_id' => $Tenant->id],
            [
                'nama_Tenant'      => 'Warung Kopi Pasai',
                'jenis_usaha'      => 'Kafe / Restoran',
                'deskripsi'        => 'Kafe khas Aceh dengan menu kopi Gayo dan makanan tradisional Lhokseumawe.',
                'lokasi_di_museum' => 'Lantai 1 - Sayap Barat',
                'tarif_sewa'       => 1_500_000,
                'persentase_pajak' => 10.00,
                'status'           => 'aktif',
                'disetujui_pada'   => now(),
            ]
        );

        // ── PENGUNJUNG ────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'user@ertifact.id'],
            [
                'name'     => 'Siti Rahma',
                'password' => Hash::make('password'),
                'role'     => 'pengunjung',
                'phone'    => '08330000003',
            ]
        );

        // ── KOLEKSI SEEDER ────────────────────────────────────────
        $this->call([
            EventSeeder::class,
            KoleksiSeeder::class, // Keep old items
            ArtefakSeeder::class,
            TokohSeeder::class,
            ArsipSeeder::class,
            LokasiSeeder::class,
        ]);
    }
}