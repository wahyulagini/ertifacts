<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tokoh_penting', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tokoh', 150);
            $table->string('nama_julukan', 150)->nullable();
            $table->string('gelar', 100)->nullable();
            $table->string('peran', 100)->nullable();
            $table->string('era_aktif', 100)->nullable();
            $table->year('tahun_lahir')->nullable();
            $table->year('tahun_wafat')->nullable();
            $table->string('tempat_asal', 150)->nullable();
            $table->text('biografi')->nullable();
            $table->text('kontribusi')->nullable();
            $table->string('gambar_path')->nullable();
            $table->string('sumber_referensi')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tokoh_penting'); }
};
