<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tasks')->where('title', 'like', '%Payment Method Preference%')->delete();
    }

    public function down(): void
    {
        // Cannot reverse
    }
};
