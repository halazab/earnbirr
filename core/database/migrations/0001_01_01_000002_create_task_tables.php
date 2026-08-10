<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('task_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('instructions')->nullable();
            $table->string('task_type')->comment('social_media, micro_task, daily_claim, survey, freelance');
            $table->decimal('reward', 28, 8)->default(0);
            $table->integer('total_slots')->default(0);
            $table->integer('remaining_slots')->default(0);
            $table->string('external_link')->nullable();
            $table->text('requirements')->nullable();
            $table->string('proof_type')->default('screenshot')->comment('screenshot, text, file, link');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('status')->default(0)->comment('0=pending,1=active,2=paused,3=completed,4=rejected');
            $table->timestamps();
        });

        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->text('proof_text')->nullable();
            $table->string('proof_file')->nullable();
            $table->string('proof_link')->nullable();
            $table->text('admin_note')->nullable();
            $table->integer('status')->default(0)->comment('0=pending,1=approved,2=rejected');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_categories');
    }
};
