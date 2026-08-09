<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku_tamu', function (Blueprint $table) {
            $table->string('kode_tiket')->unique()->nullable()->after('id');
            $table->string('email')->nullable()->after('saran_komentar');
            $table->enum('jenis_tiket', ['reguler', 'pelajar'])->default('reguler')->after('email');
            $table->integer('total_harga')->default(0)->after('jenis_tiket');
            $table->enum('status_bayar', ['belum_bayar', 'menunggu', 'lunas'])->default('belum_bayar')->after('total_harga');
            $table->string('metode_bayar')->default('qris')->after('status_bayar');
            $table->timestamp('dibayar_pada')->nullable()->after('metode_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('buku_tamu', function (Blueprint $table) {
            $table->dropColumn([
                'kode_tiket', 'email', 'jenis_tiket', 'total_harga',
                'status_bayar', 'metode_bayar', 'dibayar_pada',
            ]);
        });
    }
};
