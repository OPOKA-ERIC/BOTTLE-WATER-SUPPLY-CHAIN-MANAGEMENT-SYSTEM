<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropPrimary();
            $table->char('id', 36)->change();
            $table->primary('id');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('id')->change(); // or revert to previous type/length
            $table->primary('id');
        });
    }
}; 