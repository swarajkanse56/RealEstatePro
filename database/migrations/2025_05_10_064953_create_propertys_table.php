<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('properties')) {
            Schema::create('properties', function (Blueprint $table) {
                $table->bigIncrements('propertysid'); // Primary key
                
                $table->string('name');
                
                // Nullable foreign keys for user_id to allow guest entries
                $table->unsignedBigInteger('user_id')->nullable(); 
                $table->unsignedBigInteger('category_id');   
                $table->unsignedBigInteger('city_id');

                $table->string('image')->nullable();
                $table->json('gallery')->nullable();
                $table->json('phone')->nullable();

                $table->decimal('price', 20, 2);
                $table->string('subname')->nullable();
                $table->text('description')->nullable();
                $table->text('address')->nullable();

                $table->timestamps();

                // Foreign key constraints
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('category_id')->references('categoryid')->on('category')->onDelete('cascade');
                $table->foreign('city_id')->references('citiesid')->on('cities')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
