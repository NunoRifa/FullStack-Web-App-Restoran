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
        Schema::create('order_details', function (Blueprint $table) {
            $table->string('order_details_id')->primary();

            $table->string('menu_items_id')->nullable();
            $table->foreign('menu_items_id')->references('menu_items_id')->on('menu_items')->onDelete('set null');

            $table->string('order_details_menu_name');
            $table->unsignedTinyInteger('order_details_quantity');
            $table->decimal('order_details_price', 11, 2);
            $table->string('order_details_notes')->nullable();
            $table->string('order_details_tipe')->nullable();
            $table->enum('order_details_status', ['Waiting', 'Process', 'Cancel']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
