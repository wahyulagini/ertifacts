<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pajak_Tenant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Tenant_id')->constrained('Tenants')->cascadeOnDelete();
            $table->foreignId('transaksi_id')->constrained('transaksi')->cascadeOnDelete();
            $table->decimal('pendapatan_kotor', 14, 2);
            $table->decimal('persentase_pajak', 5, 2);
            $table->decimal('nominal_pajak', 14, 2);
            $table->decimal('pendapatan_bersih', 14, 2);
            $table->string('periode', 7); // format: YYYY-MM
            $table->enum('status_bayar', ['belum_bayar','sudah_bayar','ditunda'])->default('belum_bayar');
            $table->timestamp('dibayar_pada')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pajak_Tenant'); }
};
