<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Index pada tabel orders — digunakan hampir di semua query admin & user
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');                    // filter by status
            $table->index('created_at');               // filter by date (today, week, month, year)
            $table->index('order_type');               // filter by dine_in / takeaway
            $table->index(['status', 'created_at']);   // composite — untuk dashboard stats
        });

        // Index pada tabel payments — digunakan untuk revenue sum & unverified alerts
        Schema::table('payments', function (Blueprint $table) {
            $table->index('status');                   // filter pending / verified
            $table->index(['status', 'created_at']);   // composite — dashboard revenue
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['order_type']);
            $table->dropIndex(['status', 'created_at']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['status', 'created_at']);
        });
    }
};
