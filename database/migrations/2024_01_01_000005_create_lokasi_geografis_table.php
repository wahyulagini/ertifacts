<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lokasi_geografis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi', 200);
            $table->enum('jenis_lokasi', [
                'Situs Arkeologi','Museum','Cagar Budaya','Makam Bersejarah',
                'Masjid Bersejarah','Benteng','Istana / Keraton','Lainnya'
            ])->default('Situs Arkeologi');
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten_kota', 100)->default('Kota Lhokseumawe');
            $table->string('provinsi', 100)->default('Aceh');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('periode_sejarah', 100)->nullable();
            $table->enum('status_kelola', ['Aktif Dijaga','Terbengkalai','Renovasi','Tertutup'])->default('Aktif Dijaga');
            $table->string('pengelola', 150)->nullable();
            $table->string('jam_operasional', 100)->nullable();
            $table->string('gambar_path')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('lokasi_geografis'); }
};
