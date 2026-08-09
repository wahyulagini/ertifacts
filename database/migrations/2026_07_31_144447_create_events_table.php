<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('judul_event', 150);
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('lokasi_area', 100)->nullable();
            $table->unsignedInteger('kuota_tenant')->default(0);
            $table->decimal('harga_sewa_booth', 12, 2)->default(0);
            $table->enum('status', ['mendatang', 'berjalan', 'selesai', 'dibatalkan'])->default('mendatang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
