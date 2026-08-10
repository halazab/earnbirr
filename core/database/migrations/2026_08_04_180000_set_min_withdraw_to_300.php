<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('general_settings')
            ->where('id', 1)
            ->update(['min_withdraw' => 300]);
    }

    public function down(): void
    {
        DB::table('general_settings')
            ->where('id', 1)
            ->update(['min_withdraw' => 50]);
    }
};
