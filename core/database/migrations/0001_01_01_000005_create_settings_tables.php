<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('EarnEthio');
            $table->string('cur_text')->default('ETB');
            $table->string('cur_sym')->default('Br');
            $table->string('base_color')->default('#10b981');
            $table->string('secondary_color')->default('#3b82f6');
            $table->decimal('min_withdraw', 28, 8)->default(50);
            $table->decimal('activation_fee', 28, 8)->default(250);
            $table->string('email_from')->nullable();
            $table->text('email_template')->nullable();
            $table->string('sms_api')->nullable();
            $table->integer('otp_expiration')->default(5);
            $table->integer('daily_claim_reward')->default(1);
            $table->text('system_config')->nullable();
            $table->integer('maintenance_mode')->default(0);
            $table->timestamps();
        });

        Schema::create('frontends', function (Blueprint $table) {
            $table->id();
            $table->string('data_keys');
            $table->text('data_values')->nullable();
            $table->timestamps();
        });

        Schema::create('extensions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias')->unique();
            $table->text('script')->nullable();
            $table->text('shortcode')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->integer('is_default')->default(0);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('sections')->nullable();
            $table->text('seo_content')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('act');
            $table->string('name');
            $table->text('email_subject')->nullable();
            $table->text('email_body')->nullable();
            $table->text('sms_body')->nullable();
            $table->text('push_body')->nullable();
            $table->timestamps();
        });

        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::create('user_logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('ip')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });

        Schema::create('user_activations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('trx')->nullable();
            $table->decimal('amount', 28, 8)->default(250);
            $table->string('method')->nullable();
            $table->string('reference_code')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::create('daily_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('claim_date');
            $table->integer('streak')->default(1);
            $table->decimal('reward', 28, 8)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_claims');
        Schema::dropIfExists('user_activations');
        Schema::dropIfExists('user_logins');
        Schema::dropIfExists('notification_logs');
        Schema::dropIfExists('notification_templates');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('extensions');
        Schema::dropIfExists('frontends');
        Schema::dropIfExists('general_settings');
    }
};
