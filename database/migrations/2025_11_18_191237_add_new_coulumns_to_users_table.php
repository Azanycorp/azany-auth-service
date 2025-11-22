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
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('verification_code_expire_at')->nullable();
            $table->string('status')->default('pending');
            $table->string('last_login')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'account_number',
                'phone',
                'profile_photo',
                'verification_code',
                'verification_code_expire_at',
                'status',
                'last_login'
            ]);
        });
    }
};
