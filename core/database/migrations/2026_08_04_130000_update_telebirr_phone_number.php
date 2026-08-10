<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('deposit_methods')
            ->where('name', 'LIKE', '%TeleBirr%')
            ->update(['phone_number' => '0990781902']);
    }

    public function down(): void
    {
        DB::table('deposit_methods')
            ->where('name', 'LIKE', '%TeleBirr%')
            ->update(['phone_number' => '900298059']);
    }
};
