<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('deposit_methods', 'account_name')) {
            Schema::table('deposit_methods', function (Blueprint $table) {
                $table->string('account_name')->nullable()->after('phone_number');
            });
        }
        DB::table('deposit_methods')
            ->where('name', 'like', '%telebirr%')
            ->update(['account_name' => 'Samuel Aragaw']);
    }

    public function down(): void
    {
        Schema::table('deposit_methods', function (Blueprint $table) {
            if (Schema::hasColumn('deposit_methods', 'account_name')) {
                $table->dropColumn('account_name');
            }
        });
    }
};
