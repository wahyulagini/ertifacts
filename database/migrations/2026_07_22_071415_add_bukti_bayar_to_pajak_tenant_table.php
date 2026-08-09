<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pajak_Tenant', function (Blueprint $table) {
            $table->string('bukti_bayar_path')->nullable()->after('catatan');
        });

        DB::statement("ALTER TABLE pajak_Tenant MODIFY status_bayar ENUM('belum_bayar','menunggu_konfirmasi','sudah_bayar','ditunda') DEFAULT 'belum_bayar'");
    }

    public function down(): void
    {
        Schema::table('pajak_Tenant', function (Blueprint $table) {
            $table->dropColumn('bukti_bayar_path');
        });
        DB::statement("ALTER TABLE pajak_Tenant MODIFY status_bayar ENUM('belum_bayar','sudah_bayar','ditunda') DEFAULT 'belum_bayar'");
    }
};