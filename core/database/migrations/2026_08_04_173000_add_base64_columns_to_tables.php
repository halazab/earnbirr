<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->longText('task_file_data')->nullable()->after('task_file');
            $table->string('task_file_type')->nullable()->after('task_file_data');
        });

        Schema::table('deposit_methods', function (Blueprint $table) {
            $table->longText('image_data')->nullable()->after('image');
            $table->string('image_type')->nullable()->after('image_data');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->longText('kyc_id_front_data')->nullable()->after('kyc_info');
            $table->string('kyc_id_front_type')->nullable()->after('kyc_id_front_data');
            $table->longText('kyc_id_back_data')->nullable()->after('kyc_id_front_type');
            $table->string('kyc_id_back_type')->nullable()->after('kyc_id_back_data');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['task_file_data', 'task_file_type']);
        });

        Schema::table('deposit_methods', function (Blueprint $table) {
            $table->dropColumn(['image_data', 'image_type']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kyc_id_front_data', 'kyc_id_front_type', 'kyc_id_back_data', 'kyc_id_back_type']);
        });
    }
};
