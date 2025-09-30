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
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('nomor_agenda')->nullable()->comment('nomor agenda surat keluar');
            $table->date('tanggal_surat');
            $table->date('tanggal_kirim')->nullable()->comment('tanggal surat dikirim');
            $table->string('tujuan');
            $table->text('alamat_tujuan')->nullable();
            $table->string('telepon_tujuan')->nullable();
            $table->string('email_tujuan')->nullable();
            $table->string('perihal');
            $table->text('isi_ringkas')->nullable()->comment('ringkasan isi surat');
            $table->foreignId('klasifikasi_id')->constrained('klasifikasis')->onDelete('cascade');
            $table->enum('tingkat_keamanan', ['biasa', 'rahasia', 'sangat_rahasia'])->default('biasa');
            $table->enum('sifat_surat', ['biasa', 'penting', 'segera', 'sangat_segera'])->default('biasa');
            $table->string('file')->nullable();
            $table->bigInteger('file_size')->nullable()->comment('ukuran file dalam bytes');
            $table->string('file_type')->nullable()->comment('tipe file (pdf, doc, jpg, dll)');
            $table->enum('status_kirim', ['draft', 'terkirim', 'arsip'])->default('draft');
            $table->enum('status', ['baru', 'diproses', 'selesai'])->default('baru');
            $table->enum('priority', ['rendah', 'sedang', 'tinggi', 'urgent'])->default('sedang');
            $table->enum('delivery_method', ['email', 'pos', 'kurir', 'fax', 'langsung'])->default('email');
            $table->string('tracking_number')->nullable()->comment('nomor resi pengiriman');
            $table->text('keywords')->nullable()->comment('kata kunci untuk pencarian');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->comment('user yang membuat');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->comment('user yang menyetujui');
            $table->timestamp('approved_at')->nullable()->comment('waktu persetujuan');
            //softdelete
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};