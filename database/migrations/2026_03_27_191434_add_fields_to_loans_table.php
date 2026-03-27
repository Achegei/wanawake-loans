<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            if (!Schema::hasColumn('loans', 'principal')) {
                $table->decimal('principal', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('loans', 'interest')) {
                $table->decimal('interest', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('loans', 'total_due')) {
                $table->decimal('total_due', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('loans', 'balance_remaining')) {
                $table->decimal('balance_remaining', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('loans', 'status')) {
                $table->string('status')->default('active');
            }
            if (!Schema::hasColumn('loans', 'disbursed_at')) {
                $table->timestamp('disbursed_at')->nullable();
            }
            if (!Schema::hasColumn('loans', 'due_date')) {
                $table->timestamp('due_date')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            if (Schema::hasColumn('loans', 'principal')) {
                $table->dropColumn('principal');
            }
            if (Schema::hasColumn('loans', 'interest')) {
                $table->dropColumn('interest');
            }
            if (Schema::hasColumn('loans', 'total_due')) {
                $table->dropColumn('total_due');
            }
            if (Schema::hasColumn('loans', 'balance_remaining')) {
                $table->dropColumn('balance_remaining');
            }
            if (Schema::hasColumn('loans', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('loans', 'disbursed_at')) {
                $table->dropColumn('disbursed_at');
            }
            if (Schema::hasColumn('loans', 'due_date')) {
                $table->dropColumn('due_date');
            }
        });
    }
};