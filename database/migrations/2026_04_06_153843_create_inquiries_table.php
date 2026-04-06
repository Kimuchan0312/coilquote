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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('grade');
            $table->decimal('width_mm', 8, 2);
            $table->decimal('thickness_mm', 8, 3);
            $table->decimal('coil_weight_kg', 10, 2)->nullable();
            $table->integer('quantity_coils');
            $table->string('delivery_terms');
            $table->string('preferred_origin')->nullable();
            $table->json('required_documents')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('new'); // new, reviewing, quoted, approved, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
