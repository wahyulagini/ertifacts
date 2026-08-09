<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('artefak_id')->nullable()->constrained('artefak')->nullOnDelete();
            $table->enum('jenis', [
                'Kunjungan Umum','Kunjungan Rombongan',
                'Kunjungan Riset','Peminjaman Artefak'
            ])->default('Kunjungan Umum');
            $table->date('tanggal_kunjungan');
            $table->enum('sesi', [
                'Pagi (08.00-12.00)',
                'Siang (12.00-16.00)',
                'Penuh (08.00-16.00)'
            ])->default('Pagi (08.00-12.00)');
            $table->unsignedSmallInteger('jumlah_orang')->default(1);
            $table->text('keperluan')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->text('tujuan_peminjaman')->nullable();
            $table->string('institusi_peminjam', 150)->nullable();
            $table->enum('status', [
                'menunggu','disetujui','ditolak','selesai','dibatalkan'
            ])->default('menunggu');
            $table->string('kode_booking', 20)->unique();
            $table->text('catatan_admin')->nullable();
            $table->timestamp('disetujui_pada')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('reservasi'); }
};
