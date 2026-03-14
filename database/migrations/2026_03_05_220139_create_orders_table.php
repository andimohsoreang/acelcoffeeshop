<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique(); // ORD-20240101-0001
            $table->integer('queue_number'); // nomor antrian harian
            $table->enum('order_type', ['dine_in', 'takeaway']);
            $table->string('table_number')->nullable(); // dine_in
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->text('notes')->nullable();
            $table->enum('status', [
                'pending', // baru masuk, menunggu konfirmasi
                'confirmed', // dikonfirmasi admin
                'in_progress', // sedang dibuat
                'ready', // siap diambil/disajikan
                'completed', // selesai
                'cancelled' // dibatalkan
            ])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};