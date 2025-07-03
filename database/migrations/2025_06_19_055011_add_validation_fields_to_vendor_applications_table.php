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
        Schema::table('vendor_applications', function (Blueprint $table) {
            // Financial Stability Data
            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->decimal('net_worth', 15, 2)->nullable();
            $table->integer('years_in_business')->nullable();
            $table->string('credit_rating', 10)->nullable();
            $table->boolean('has_bankruptcy')->default(false);
            $table->boolean('has_tax_liens')->default(false);
            
            // Reputation Data
            $table->decimal('average_rating', 3, 1)->nullable();
            $table->integer('total_reviews')->nullable();
            $table->boolean('has_legal_issues')->default(false);
            $table->text('legal_issues_description')->nullable();
            $table->boolean('has_complaints')->default(false);
            $table->text('complaints_description')->nullable();
            
            // Regulatory Compliance Data
            $table->boolean('has_business_license')->default(false);
            $table->boolean('has_tax_registration')->default(false);
            $table->boolean('has_insurance')->default(false);
            $table->string('insurance_type')->nullable();
            $table->boolean('has_environmental_compliance')->default(false);
            $table->boolean('has_safety_certification')->default(false);
            
            // Facility Visit Data
            $table->timestamp('scheduled_visit_date')->nullable();
            $table->string('visit_status')->default('pending');
            $table->text('visit_notes')->nullable();
            $table->boolean('visit_passed')->nullable();
            
            // PDF Document Data
            $table->string('pdf_document_path')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('validated_at')->nullable();
            
            // Validation Scores
            $table->decimal('financial_score', 5, 2)->nullable();
            $table->decimal('reputation_score', 5, 2)->nullable();
            $table->decimal('compliance_score', 5, 2)->nullable();
            $table->decimal('overall_score', 5, 2)->nullable();
            
            // Note: reviewed_by and reviewed_at columns already exist in the table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_applications', function (Blueprint $table) {
            // Drop all added columns (excluding reviewed_by and reviewed_at which already exist)
            $table->dropColumn([
                'annual_revenue', 'net_worth', 'years_in_business', 'credit_rating',
                'has_bankruptcy', 'has_tax_liens', 'average_rating', 'total_reviews',
                'has_legal_issues', 'legal_issues_description', 'has_complaints',
                'complaints_description', 'has_business_license', 'has_tax_registration',
                'has_insurance', 'insurance_type', 'has_environmental_compliance',
                'has_safety_certification', 'scheduled_visit_date', 'visit_status',
                'visit_notes', 'visit_passed', 'pdf_document_path', 'submitted_at',
                'validated_at', 'financial_score', 'reputation_score', 'compliance_score',
                'overall_score'
            ]);
        });
    }
};
