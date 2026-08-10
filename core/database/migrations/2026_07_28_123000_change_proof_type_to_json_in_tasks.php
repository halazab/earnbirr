<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('proof_type')->change();
        });

        DB::table('tasks')->where('proof_type', 'screenshot')->update(['proof_type' => '["screenshot"]']);
        DB::table('tasks')->where('proof_type', 'text')->update(['proof_type' => '["text"]']);
        DB::table('tasks')->where('proof_type', 'file')->update(['proof_type' => '["file"]']);
        DB::table('tasks')->where('proof_type', 'link')->update(['proof_type' => '["link"]']);
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('proof_type', 255)->change();
        });
    }
};
