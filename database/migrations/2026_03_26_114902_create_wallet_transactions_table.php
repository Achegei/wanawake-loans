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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();

            $table->string('wallet_id');
            $table->decimal('amount', 10, 2);

            $table->string('type'); // disbursement, repayment
            $table->string('direction'); // in, out

            $table->enum('status', ['pending', 'approved', 'rejected', 'disbursed', 'paid', 'defaulted'])->default('pending');

            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
