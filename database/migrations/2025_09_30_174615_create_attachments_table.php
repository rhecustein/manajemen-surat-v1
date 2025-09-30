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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachable_type')->comment('model yang memiliki attachment');
            $table->unsignedBigInteger('attachable_id')->comment('ID dari model tersebut');
            $table->string('original_name')->comment('nama file asli');
            $table->string('file_name')->comment('nama file yang disimpan');
            $table->string('file_path')->comment('path file');
            $table->bigInteger('file_size')->comment('ukuran file dalam bytes');
            $table->string('mime_type')->comment('tipe MIME file');
            $table->string('extension', 10)->nullable()->comment('ekstensi file');
            $table->boolean('is_main')->default(false)->comment('apakah file utama');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade')->comment('user yang mengupload');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['attachable_type', 'attachable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
