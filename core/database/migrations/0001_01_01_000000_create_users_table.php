<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->nullable();
            $table->string('country_code')->nullable();
            $table->string('password');
            $table->decimal('balance', 28, 8)->default(0);
            $table->decimal('total_earned', 28, 8)->default(0);
            $table->decimal('total_withdrawn', 28, 8)->default(0);
            $table->integer('kv')->default(0)->comment('KYC: 0=unverified,1=verified,2=pending');
            $table->string('kyc_rejection_reason')->nullable();
            $table->text('kyc_data')->nullable();
            $table->text('kyc_info')->nullable();
            $table->integer('ev')->default(0)->comment('Email verified: 0=no,1=yes');
            $table->integer('sv')->default(0)->comment('Mobile verified: 0=no,1=yes');
            $table->string('ver_code')->nullable();
            $table->dateTime('ver_code_send_at')->nullable();
            $table->integer('ts')->default(0)->comment('2FA status');
            $table->string('tsc')->nullable()->comment('2FA secret');
            $table->integer('activation_fee_paid')->default(0)->comment('0=pending,1=paid');
            $table->string('activation_trx')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('device_token')->nullable();
            $table->string('ip')->nullable();
            $table->text('device_info')->nullable();
            $table->integer('status')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('personal_access_tokens');
    }
};
