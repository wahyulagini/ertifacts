<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── Pastikan tabel Tenants ada dengan semua kolom ────────────────
        if (!Schema::hasTable('Tenants')) {
            Schema::create('Tenants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
                $table->string('nama_Tenant', 150);
                $table->string('jenis_usaha', 100);
                $table->text('deskripsi')->nullable();
                $table->string('lokasi_di_museum', 150)->nullable();
                $table->string('logo_path')->nullable();
                $table->string('no_kontak', 20)->nullable();
                $table->string('website')->nullable();
                $table->decimal('tarif_sewa', 12, 2)->default(0);
                $table->decimal('persentase_pajak', 5, 2)->default(10.00);
                $table->enum('status', ['menunggu', 'aktif', 'ditolak', 'nonaktif'])->default('menunggu');
                $table->text('catatan_admin')->nullable();
                $table->timestamp('disetujui_pada')->nullable();
                $table->timestamps();
            });
        } else {
            if (!Schema::hasColumn('Tenants', 'event_id')) {
                Schema::table('Tenants', function (Blueprint $table) {
                    $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete()->after('user_id');
                });
            }
        }

        // ── Pastikan tabel pajak_Tenant ada dengan semua kolom ──────────
        if (!Schema::hasTable('pajak_Tenant')) {
            Schema::create('pajak_Tenant', function (Blueprint $table) {
                $table->id();
                $table->foreignId('Tenant_id')->constrained('Tenants')->cascadeOnDelete();
                $table->unsignedBigInteger('transaksi_id')->nullable();
                $table->decimal('pendapatan_kotor', 14, 2);
                $table->decimal('persentase_pajak', 5, 2);
                $table->decimal('nominal_pajak', 14, 2);
                $table->decimal('pendapatan_bersih', 14, 2);
                $table->string('periode', 7);
                $table->enum('status_bayar', ['belum_bayar', 'menunggu_konfirmasi', 'sudah_bayar', 'ditunda'])->default('belum_bayar');
                $table->timestamp('dibayar_pada')->nullable();
                $table->text('catatan')->nullable();
                $table->string('bukti_bayar_path')->nullable();
                $table->timestamps();
            });
        } else {
            if (!Schema::hasColumn('pajak_Tenant', 'bukti_bayar_path')) {
                Schema::table('pajak_Tenant', function (Blueprint $table) {
                    $table->string('bukti_bayar_path')->nullable()->after('catatan');
                });
            }
            try {
                DB::statement("ALTER TABLE `pajak_Tenant` MODIFY `status_bayar` ENUM('belum_bayar','menunggu_konfirmasi','sudah_bayar','ditunda') DEFAULT 'belum_bayar'");
            } catch (\Exception $e) {
                // sudah ada, skip
            }
        }
    }

    public function down(): void
    {
        // safety migration - no rollback needed
    }
};

