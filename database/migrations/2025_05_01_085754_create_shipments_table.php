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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->string('external_id');
            $table->string('status');
            $table->string('courier_company');
            $table->string('courier_type');
            $table->string('courier_link');
            $table->string('tracking_id');
            $table->string('delivery_type');
            $table->datetime('delivery_datetime');
            $table->decimal('price', 12, 2);
            $table->string('shipper_name');
            $table->string('origin_name');
            $table->string('origin_phone');
            $table->string('origin_address');
            $table->string('destination_name');
            $table->string('destination_phone');
            $table->string('destination_address');
            $table->string('reference_id')->nullable();
            $table->json('raw_response');
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
