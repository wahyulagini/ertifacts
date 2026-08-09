<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('Tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('nama_Tenant', 150);
            $table->string('jenis_usaha', 100);
            $table->text('deskripsi')->nullable();
            $table->string('lokasi_di_museum', 150)->nullable();
            $table->string('logo_path')->nullable();
            $table->string('no_kontak', 20)->nullable();
            $table->string('website')->nullable();
            $table->decimal('tarif_sewa', 12, 2)->default(0);
            $table->decimal('persentase_pajak', 5, 2)->default(10.00);
            $table->enum('status', ['menunggu','aktif','ditolak','nonaktif'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('disetujui_pada')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('Tenants'); }
};
