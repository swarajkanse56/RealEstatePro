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
        Schema::create('cities', function (Blueprint $table) {
    $table->bigIncrements('citiesid');// unsigned BIGINT primary key
    $table->string('name')->nullable();
    $table->string('image')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
