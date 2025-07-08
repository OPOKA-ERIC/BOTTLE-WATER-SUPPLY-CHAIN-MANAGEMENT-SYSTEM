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
        Schema::table('production_batches', function (Blueprint $table) {
            // Add missing fields
            $table->date('start_date')->nullable()->after('production_date');
            $table->date('estimated_completion')->nullable()->after('start_date');
            $table->timestamp('completed_at')->nullable()->after('status');
            
            // Update status enum to include 'pending'
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_batches', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'estimated_completion', 'completed_at']);
            $table->enum('status', ['in_progress', 'completed', 'cancelled'])->default('in_progress')->change();
        });
    }
};
