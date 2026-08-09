<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reservasi_id')->nullable()->constrained('reservasi')->nullOnDelete();
            $table->foreignId('Tenant_id')->nullable()->constrained('Tenants')->nullOnDelete();
            $table->enum('jenis_transaksi', [
                'Tiket Masuk','Tiket Rombongan',
                'Biaya Peminjaman Artefak',
                'Pendapatan Tenant','Sewa Tempat Tenant','Lainnya'
            ]);
            $table->decimal('jumlah', 14, 2);
            $table->string('kode_transaksi', 30)->unique();
            $table->string('metode_bayar', 50)->nullable();
            $table->enum('status_bayar', ['menunggu','lunas','gagal','dikembalikan'])->default('menunggu');
            $table->text('keterangan')->nullable();
            $table->timestamp('dibayar_pada')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('transaksi'); }
};
