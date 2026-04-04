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
        Schema::table('loans', function (Blueprint $table) {
            $table->string('disbursement_tracking_id')->nullable()->after('transaction_id');
            $table->string('repayment_invoice_id')->nullable()->after('disbursement_tracking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('disbursement_tracking_id');
            $table->dropColumn('repayment_invoice_id');
        });
    }
};
