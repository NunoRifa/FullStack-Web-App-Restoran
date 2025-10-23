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
        Schema::create('tables', function (Blueprint $table) {
            $table->string('tables_id')->primary();
            $table->string('tables_name');
            $table->unsignedTinyInteger('tables_capacity');
            $table->string('tables_location')->nullable();
            $table->enum('tables_status', ['Available', 'Reserved', 'Occupied', 'Cleaning', 'Reparation']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
