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
        Schema::create('digital_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('surat_id')->comment('ID surat yang ditandatangani');
            $table->string('surat_type')->comment('jenis surat (surat_masuk/surat_keluar)');
            $table->text('signature_data')->comment('data tanda tangan digital');
            $table->string('signature_hash')->comment('hash tanda tangan untuk verifikasi');
            $table->timestamp('signed_at');
            $table->string('ip_address', 45)->nullable();
            $table->text('device_info')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['surat_id', 'surat_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_signatures');
    }
};
