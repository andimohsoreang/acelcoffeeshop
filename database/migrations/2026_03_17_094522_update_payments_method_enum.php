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
        // SQLite doesn't support changing column type easily, but for typical MySQL/PostgreSQL:
        // We use raw DB statement to modify enum or just change string column.
        // Assuming 'method' is a string or enum.
        Schema::table('payments', function (Blueprint $table) {
             // If it's an enum in MySQL:
             // DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('cash', 'qris') NOT NULL");
             
             // Safer approach for general Laravel migrations:
             $table->string('method')->comment('cash, qris')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('method')->comment('cash, transfer, qris')->change();
        });
    }
};
