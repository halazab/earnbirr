<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->decimal('task_reward_min', 10, 2)->default(30)->after('activation_fee');
            $table->decimal('task_reward_max', 10, 2)->default(50)->after('task_reward_min');
        });

        DB::table('general_settings')->update([
            'task_reward_min' => 30,
            'task_reward_max' => 50,
        ]);
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn(['task_reward_min', 'task_reward_max']);
        });
    }
};
