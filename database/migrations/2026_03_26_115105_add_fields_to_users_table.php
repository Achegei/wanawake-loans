<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->unique()->after('email');
            }

            if (!Schema::hasColumn('users', 'id_number')) {
                $table->string('id_number')->unique()->after('phone');
            }

            if (!Schema::hasColumn('users', 'employment_status')) {
                $table->string('employment_status')->nullable();
            }

            if (!Schema::hasColumn('users', 'monthly_income')) {
                $table->decimal('monthly_income', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('users', 'wallet_id')) {
                $table->string('wallet_id')->nullable();
            }

            if (!Schema::hasColumn('users', 'selfie_path')) {
                $table->string('selfie_path')->nullable();
            }

            if (!Schema::hasColumn('users', 'id_photo_path')) {
                $table->string('id_photo_path')->nullable();
            }

            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }

            if (Schema::hasColumn('users', 'id_number')) {
                $table->dropColumn('id_number');
            }

            if (Schema::hasColumn('users', 'employment_status')) {
                $table->dropColumn('employment_status');
            }

            if (Schema::hasColumn('users', 'monthly_income')) {
                $table->dropColumn('monthly_income');
            }

            if (Schema::hasColumn('users', 'wallet_id')) {
                $table->dropColumn('wallet_id');
            }

            if (Schema::hasColumn('users', 'selfie_path')) {
                $table->dropColumn('selfie_path');
            }

            if (Schema::hasColumn('users', 'id_photo_path')) {
                $table->dropColumn('id_photo_path');
            }

            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
        });
    }
};