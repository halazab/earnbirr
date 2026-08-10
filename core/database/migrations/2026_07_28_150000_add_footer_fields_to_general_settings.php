<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->text('footer_text')->nullable()->after('daily_claim_reward');
            $table->string('footer_address')->nullable()->after('footer_text');
            $table->string('footer_email')->nullable()->after('footer_address');
            $table->string('footer_phone')->nullable()->after('footer_email');
            $table->string('social_telegram')->nullable()->after('footer_phone');
            $table->string('social_facebook')->nullable()->after('social_telegram');
            $table->string('social_twitter')->nullable()->after('social_facebook');
            $table->string('social_instagram')->nullable()->after('social_twitter');
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_text', 'footer_address', 'footer_email', 'footer_phone',
                'social_telegram', 'social_facebook', 'social_twitter', 'social_instagram'
            ]);
        });
    }
};
