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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('verification_code_expire_at')->nullable();
            $table->string('status')->default('pending');
            $table->string('kyc_verification')->nullable();
            $table->string('two_factor_enabled')->nullable();
            $table->boolean('biometric_enabled')->default(false);
            $table->boolean('lock_screen_enabled')->default(false);
            $table->string('lock_screen_pin')->nullable();
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
                '
            account_number',
                'phone',
                'first_name',
                'last_name',
                'country_id',
                'state',
                'city',
                'address',
                'zip_code',
                'profile_photo',
                'verification_code',
                'verification_code_expire_at',
                'status',
                'kyc_verification',
                'two_factor_enabled',
                'biometric_enabled',
                'lock_screen_enabled',
                'lock_screen_pin',
                'last_login'
            ]);
        });
    }
};
