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
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained()->onUpdate('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('category');
            $table->string('sku')->nullable();
            $table->decimal('value', 12, 2);
            $table->integer('quantity');
            $table->decimal('length', 12, 2)->nullable();
            $table->decimal('width', 12, 2)->nullable();
            $table->decimal('height', 12, 2)->nullable();
            $table->decimal('weight', 12, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_items');
    }
};
