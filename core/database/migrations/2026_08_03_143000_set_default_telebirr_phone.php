<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('deposit_methods')
            ->where('name', 'LIKE', '%TeleBirr%')
            ->orWhere('name', 'LIKE', '%telebirr%')
            ->update(['phone_number' => '900298059']);
    }

    public function down(): void
    {
        DB::table('deposit_methods')
            ->where('phone_number', '900298059')
            ->update(['phone_number' => null]);
    }
};
