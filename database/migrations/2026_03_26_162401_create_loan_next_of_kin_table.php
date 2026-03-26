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
        Schema::create('loan_next_of_kin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('relation'); // e.g., brother, sister, spouse, parent
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_next_of_kin');
    }
};
