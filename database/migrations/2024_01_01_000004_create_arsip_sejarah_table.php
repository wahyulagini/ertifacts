<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('arsip_sejarah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_arsip', 50)->unique();
            $table->string('judul_arsip', 200);
            $table->enum('jenis_koleksi', [
                'Naskah Kuno','Foto Bersejarah','Peta Kuno',
                'Surat / Dokumen Resmi','Rekaman Audio',
                'Rekaman Video','Laporan Arkeologi','Lainnya'
            ])->default('Lainnya');
            $table->string('bahasa', 100)->nullable();
            $table->string('tahun_dokumen', 50)->nullable();
            $table->string('asal_instansi', 150)->nullable();
            $table->text('deskripsi_isi')->nullable();
            $table->string('kondisi_fisik', 100)->nullable();
            $table->string('lokasi_penyimpanan')->nullable();
            $table->string('file_digital_path')->nullable();
            $table->string('gambar_thumbnail')->nullable();
            $table->boolean('tersedia_publik')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('arsip_sejarah'); }
};
