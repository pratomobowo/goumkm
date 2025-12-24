<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('type'); // income, expense
            $table->tinyInteger('period_month');
            $table->year('period_year');
            $table->decimal('planned_amount', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'category_id', 'period_month', 'period_year']);
            $table->index(['tenant_id', 'period_year', 'period_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
