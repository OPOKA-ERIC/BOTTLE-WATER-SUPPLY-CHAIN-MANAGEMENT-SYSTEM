<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity_available');
            $table->string('unit_of_measure');
            // $table->string('category'); // Removed: use 'name' only. See new migration for dropping this column.
            $table->string('status')->default('active');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('raw_materials');
    }
}; 