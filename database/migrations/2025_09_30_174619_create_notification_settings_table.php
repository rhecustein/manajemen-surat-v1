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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->comment('jika null berarti pengaturan global');
            $table->boolean('email')->default(true);
            $table->boolean('web_push')->default(false);
            $table->boolean('mobile_push')->default(false)->comment('notifikasi mobile');
            $table->boolean('sms')->default(false)->comment('notifikasi SMS');
            $table->json('triggers')->nullable()->comment('trigger notifikasi');
            $table->string('email_default')->nullable();
            $table->string('webhook_url')->nullable();
            $table->enum('frequency', ['realtime', 'daily', 'weekly'])->default('realtime');
            $table->time('quiet_hours_start')->nullable()->comment('jam mulai mode hening');
            $table->time('quiet_hours_end')->nullable()->comment('jam akhir mode hening');
            $table->string('timezone')->default('Asia/Jakarta');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
