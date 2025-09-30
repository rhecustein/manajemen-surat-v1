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
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuks')->onDelete('cascade');
            $table->foreignId('dari_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kepada_user_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->text('instruksi')->nullable()->comment('instruksi khusus untuk disposisi');
            $table->date('due_date')->nullable()->comment('deadline tindak lanjut');
            $table->enum('priority', ['rendah', 'sedang', 'tinggi', 'urgent'])->default('sedang');
            $table->enum('status', ['diajukan', 'diproses', 'diterima', 'ditolak', 'selesai'])->default('diajukan');
            $table->timestamp('tanggal_baca')->nullable()->comment('kapan disposisi dibaca');
            $table->timestamp('tanggal_selesai')->nullable()->comment('kapan disposisi diselesaikan');
            $table->text('feedback')->nullable()->comment('feedback dari penerima disposisi');
            $table->boolean('is_forwarded')->default(false)->comment('apakah disposisi diteruskan');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->comment('user yang membuat disposisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisis');
    }
};