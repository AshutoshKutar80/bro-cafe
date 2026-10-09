<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 15);
            $table->string('otp_hash');
            $table->string('purpose')->default('register');
            $table->json('payload')->nullable();
            $table->timestamp('expires_at');
            $table->integer('attempts')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->index('mobile');
        });

        Schema::create('otp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 15);
            $table->string('action');
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }
    public function down(): void {
        Schema::dropIfExists('otp_logs');
        Schema::dropIfExists('otp_verifications');
    }
};