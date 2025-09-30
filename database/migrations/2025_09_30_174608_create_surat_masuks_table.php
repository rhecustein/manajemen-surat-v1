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
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('nomor_agenda')->nullable()->comment('nomor agenda surat masuk');
            $table->date('tanggal_surat');
            $table->date('tanggal_terima')->comment('tanggal surat diterima');
            $table->string('pengirim');
            $table->text('alamat_pengirim')->nullable();
            $table->string('telepon_pengirim')->nullable();
            $table->string('email_pengirim')->nullable();
            $table->string('perihal');
            $table->text('isi_ringkas')->nullable()->comment('ringkasan isi surat');
            $table->foreignId('klasifikasi_id')->constrained('klasifikasis')->onDelete('cascade');
            $table->enum('tingkat_keamanan', ['biasa', 'rahasia', 'sangat_rahasia'])->default('biasa');
            $table->enum('sifat_surat', ['biasa', 'penting', 'segera', 'sangat_segera'])->default('biasa');
            $table->string('file')->nullable();
            $table->bigInteger('file_size')->nullable()->comment('ukuran file dalam bytes');
            $table->string('file_type')->nullable()->comment('tipe file (pdf, doc, jpg, dll)');
            $table->enum('status', ['baru', 'diproses', 'selesai'])->default('baru');
            $table->enum('status_baca', ['belum', 'sudah', 'arsip'])->default('belum');
            $table->enum('priority', ['rendah', 'sedang', 'tinggi', 'urgent'])->default('sedang');
            $table->date('due_date')->nullable()->comment('tanggal deadline tindak lanjut');
            $table->text('keywords')->nullable()->comment('kata kunci untuk pencarian');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->comment('user yang mencatat');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};