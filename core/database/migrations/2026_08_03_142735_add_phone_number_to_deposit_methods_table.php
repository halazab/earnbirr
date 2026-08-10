<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('deposit_methods', function (Blueprint $table) {
            if (!Schema::hasColumn('deposit_methods', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('deposit_methods', function (Blueprint $table) {
            if (Schema::hasColumn('deposit_methods', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });
    }
};
