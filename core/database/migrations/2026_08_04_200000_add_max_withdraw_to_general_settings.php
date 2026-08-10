<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->decimal('max_withdraw', 28, 8)->default(65000)->after('min_withdraw');
        });

        DB::table('general_settings')->where('id', 1)->update(['max_withdraw' => 65000]);
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn('max_withdraw');
        });
    }
};
