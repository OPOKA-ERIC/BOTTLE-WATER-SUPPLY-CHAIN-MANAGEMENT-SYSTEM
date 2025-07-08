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
        Schema::table('inventories', function (Blueprint $table) {
            $table->integer('current_stock')->default(0)->after('product_id');
            $table->integer('minimum_stock')->default(0)->after('current_stock');
            $table->string('unit', 20)->default('pieces')->after('minimum_stock');
            $table->text('notes')->nullable()->after('unit');
            $table->string('location')->nullable()->after('notes');
            $table->string('batch_number')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn(['current_stock', 'minimum_stock', 'unit', 'notes', 'location', 'batch_number']);
        });
    }
};
