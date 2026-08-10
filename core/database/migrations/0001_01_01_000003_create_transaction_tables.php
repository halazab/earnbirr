<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('trx')->unique();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->decimal('post_balance', 28, 8)->default(0);
            $table->string('type')->comment('credit, debit');
            $table->string('remark')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });

        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('trx')->unique();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->decimal('final_amount', 28, 8)->default(0);
            $table->string('gateway')->nullable();
            $table->string('method')->nullable();
            $table->text('information')->nullable();
            $table->string('reference_code')->nullable();
            $table->integer('status')->default(0)->comment('0=pending,1=success,2=rejected');
            $table->text('admin_feedback')->nullable();
            $table->timestamps();
        });

        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('trx')->unique();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->decimal('final_amount', 28, 8)->default(0);
            $table->string('method');
            $table->text('account_info')->nullable();
            $table->text('admin_feedback')->nullable();
            $table->integer('status')->default(0)->comment('0=pending,1=approved,2=rejected');
            $table->timestamps();
        });

        Schema::create('withdraw_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('user_data')->nullable();
            $table->decimal('min_limit', 28, 8)->default(0);
            $table->decimal('max_limit', 28, 8)->default(0);
            $table->decimal('fixed_charge', 28, 8)->default(0);
            $table->decimal('percent_charge', 8, 2)->default(0);
            $table->string('currency')->default('ETB');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdraw_methods');
        Schema::dropIfExists('withdrawals');
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('transactions');
    }
};
