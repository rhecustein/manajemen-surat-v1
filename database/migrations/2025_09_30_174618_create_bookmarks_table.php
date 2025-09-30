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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('bookmarkable_type')->comment('model yang di-bookmark');
            $table->unsignedBigInteger('bookmarkable_id')->comment('ID dari model tersebut');
            $table->string('title')->nullable()->comment('judul bookmark');
            $table->text('notes')->nullable()->comment('catatan bookmark');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['bookmarkable_type', 'bookmarkable_id']);
            $table->unique(['user_id', 'bookmarkable_type', 'bookmarkable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
