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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('method', ['cash', 'transfer', 'qris']);
            $table->decimal('amount', 10, 2);
            $table->enum('status', [
                'pending', // menunggu pembayaran/verifikasi
                'uploaded', // bukti sudah diupload
                'verified', // sudah diverifikasi admin
                'rejected', // ditolak admin
                'refunded' // dikembalikan
            ])->default('pending');
            $table->string('proof_image')->nullable(); // bukti transfer/QRIS
            $table->text('notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('reject_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};