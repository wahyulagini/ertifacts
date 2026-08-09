<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\tenant;

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

        // ── tenant ─────────────────────────────────────────────
        $tenant = User::updateOrCreate(
            ['email' => 'tenant@ertifact.id'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role'     => 'tenant',
                'phone'    => '08220000002',
            ]
        );

        // Data tenant-nya (relasi user_id → tenants)
        tenant::updateOrCreate(
            ['user_id' => $tenant->id],
            [
                'nama_tenant'      => 'Warung Kopi Pasai',
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