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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade'); // Admin who created the task
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null'); // User assigned to complete
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled', 'on_hold'])->default('pending');
            $table->enum('category', ['production', 'inventory', 'quality_control', 'delivery', 'maintenance', 'admin', 'customer_service', 'other'])->default('other');
            $table->dateTime('due_date')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->integer('estimated_hours')->nullable();
            $table->integer('actual_hours')->nullable();
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable(); // Store file paths
            $table->json('dependencies')->nullable(); // IDs of tasks this task depends on
            $table->string('location')->nullable(); // Where the task needs to be performed
            $table->enum('visibility', ['public', 'private', 'team'])->default('team');
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable(); // daily, weekly, monthly
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['assigned_to', 'status']);
            $table->index(['priority', 'due_date']);
            $table->index(['category', 'status']);
            $table->index(['assigned_by', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
