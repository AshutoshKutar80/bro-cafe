<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('delivery_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('vehicle_type')->default('bike');
            $table->string('vehicle_number')->nullable();
            $table->boolean('is_online')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->decimal('earnings', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('partner_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('delivery_partners')->cascadeOnDelete();
            $table->string('type'); // aadhaar, license, rc
            $table->string('file_path');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('partner_id')->constrained('delivery_partners')->cascadeOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->enum('status', ['assigned', 'picked_up', 'out_for_delivery', 'delivered', 'cancelled'])->default('assigned');
            $table->timestamps();
        });

        Schema::create('location_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('delivery_partners')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->timestamp('recorded_at')->useCurrent();
            $table->index(['partner_id', 'order_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('location_updates');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('partner_documents');
        Schema::dropIfExists('delivery_partners');
    }
};