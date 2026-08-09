<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('artefak', function (Blueprint $table) {
            $table->id();
            $table->string('kode_registrasi', 50)->unique();
            $table->string('nama_artefak', 150);
            $table->string('nama_lokal', 150)->nullable();
            $table->string('era_periodisasi', 100)->nullable();
            $table->string('periode_abad', 100)->nullable();
            $table->string('kategori', 100)->nullable();
            $table->string('asal_daerah', 150)->nullable();
            $table->string('bahan_utama', 150)->nullable();
            $table->string('dimensi', 100)->nullable();
            $table->string('berat', 50)->nullable();
            $table->string('teknik_pembuatan', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar_path')->nullable();
            $table->string('situs_penemuan', 150)->nullable();
            $table->string('lokasi_administratif')->nullable();
            $table->date('tanggal_ditemukan')->nullable();
            $table->string('penemu', 150)->nullable();
            $table->text('kondisi_lingkungan')->nullable();
            $table->unsignedTinyInteger('persentase_keutuhan')->default(100);
            $table->enum('status_kondisi', [
                'Utuh','Sangat Terkonservasi','Pecah Sebagian',
                'Fragmen Tersambung','Korosi','Lapuk','Restorasi'
            ])->default('Utuh');
            $table->date('tanggal_pemeriksaan')->nullable();
            $table->text('catatan_konservasi')->nullable();
            $table->boolean('bisa_dipinjam')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('artefak'); }
};
