<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::table('vendor_applications')->whereNull('financial_score')->update(['financial_score' => 0]);
        DB::table('vendor_applications')->whereNull('reputation_score')->update(['reputation_score' => 0]);
        DB::table('vendor_applications')->whereNull('compliance_score')->update(['compliance_score' => 0]);
        DB::table('vendor_applications')->whereNull('overall_score')->update(['overall_score' => 0]);
    }

    public function down()
    {
        // No rollback needed
    }
}; 