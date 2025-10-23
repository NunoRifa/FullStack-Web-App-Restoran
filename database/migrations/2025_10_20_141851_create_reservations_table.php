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
        Schema::create('reservations', function (Blueprint $table) {
            $table->string('reservations_id')->primary();
            $table->string('reservations_customer_name');
            $table->string('reservations_number_phone');
            $table->string('reservations_email')->nullable();
            $table->dateTime('reservations_date');
            $table->string('reservations_time');
            $table->unsignedSmallInteger('reservations_guest');

            $table->string('tables_id')->nullable();
            $table->foreign('tables_id')->references('tables_id')->on('tables')->onDelete('set null');

            $table->string('reservations_status');
            $table->decimal('reservations_deposit_amount', 11, 2);
            $table->dateTime('reservations_checkin')->nullable();
            $table->dateTime('reservations_checkout')->nullable();
            $table->boolean('reservations_overtime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
