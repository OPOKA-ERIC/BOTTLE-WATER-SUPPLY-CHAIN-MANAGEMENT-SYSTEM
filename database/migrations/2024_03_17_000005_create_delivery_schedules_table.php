<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('delivery_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('retailer_id')->constrained('users');
            $table->dateTime('delivery_date');
            $table->string('status')->default('scheduled');
            $table->foreignId('driver_id')->nullable()->constrained('users');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_id')
                  ->references('id')
                  ->on('vehicles')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_schedules');
    }
}; 