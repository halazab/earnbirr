<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->string('site_logo_url')->nullable()->after('secondary_color');
            $table->string('site_icon_url')->nullable()->after('site_logo_url');
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn(['site_logo_url', 'site_icon_url']);
        });
    }
};
