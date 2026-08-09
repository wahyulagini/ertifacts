<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artefak', function (Blueprint $table) {
            $table->unique('nama_artefak');
        });
    }

    public function down(): void
    {
        Schema::table('artefak', function (Blueprint $table) {
            $table->dropUnique(['nama_artefak']);
        });
    }
};
