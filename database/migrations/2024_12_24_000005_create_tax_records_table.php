<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('period_month');
            $table->year('period_year');
            $table->decimal('gross_revenue', 15, 2)->default(0);
            $table->decimal('tax_base', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->string('tax_type')->default('pph_final'); // pph_final, ppn
            $table->string('status')->default('draft'); // draft, calculated, paid
            $table->date('payment_date')->nullable();
            $table->string('payment_proof')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'period_month', 'period_year', 'tax_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_records');
    }
};
