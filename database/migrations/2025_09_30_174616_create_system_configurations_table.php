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
        Schema::create('system_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('group_name')->comment('kelompok konfigurasi (email, app, security)');
            $table->string('key')->comment('kunci konfigurasi');
            $table->text('value')->nullable()->comment('nilai konfigurasi');
            $table->text('description')->nullable()->comment('deskripsi konfigurasi');
            $table->enum('data_type', ['string', 'integer', 'boolean', 'json'])->default('string');
            $table->boolean('is_public')->default(false)->comment('apakah bisa diakses publik');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['group_name', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_configurations');
    }
};
