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
            $table->date('start_date')->nullable();
            $table->date('estimated_completion')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            // TiDB doesn't support CHANGE COLUMN - status enum already set in create migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_batches', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'estimated_completion', 'completed_at']);
            // TiDB doesn't support CHANGE COLUMN - no-op
        });
    }
};
