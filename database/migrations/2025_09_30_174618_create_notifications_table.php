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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type')->comment('jenis notifikasi');
            $table->string('title')->comment('judul notifikasi');
            $table->text('message')->comment('isi notifikasi');
            $table->json('data')->nullable()->comment('data tambahan notifikasi');
            $table->timestamp('read_at')->nullable()->comment('kapan notifikasi dibaca');
            $table->string('action_url')->nullable()->comment('URL untuk aksi');
            $table->string('icon')->nullable()->comment('ikon notifikasi');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->timestamp('expires_at')->nullable()->comment('kapan notifikasi kedaluwarsa');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};