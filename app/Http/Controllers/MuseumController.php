<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi pencatatan keuangan harian tenant.
     */
    public function up(): void
    {
        Schema::create('tenant_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->decimal('total_omset', 12, 2);
            $table->decimal('jumlah_pajak', 12, 2); // Nilai bagi hasil otomatis yang dipotong untuk operasional
            $table->decimal('pendapatan_bersih', 12, 2);
            $table->date('tanggal_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_sales');
    }
};