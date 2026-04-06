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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->constrained()->cascadeOnDelete();
            // Internal cost fields — never exposed to customer
            $table->string('supplier_name')->nullable();
            $table->decimal('cost_per_mt', 10, 2)->nullable();
            $table->decimal('est_total_mt', 8, 2)->nullable();
            $table->decimal('freight_cost', 10, 2)->default(0);
            $table->decimal('other_costs', 10, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->nullable();
            // Customer-facing fields
            $table->decimal('selling_price_per_mt', 10, 2);
            $table->decimal('total_selling_price', 12, 2);
            $table->string('payment_terms');
            $table->string('lead_time');
            $table->date('valid_until');
            $table->text('remarks')->nullable();
            $table->string('status')->default('draft'); // draft, sent, approved, rejected, expired
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
