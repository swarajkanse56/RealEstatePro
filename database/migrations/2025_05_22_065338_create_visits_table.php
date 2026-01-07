<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->foreignId('property_id')->constrained('properties', 'propertysid'); // Foreign key to the property
            $table->foreignId('category_id')->constrained('category', 'categoryid'); // Foreign key to the property
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->dateTime('visit_date');
            $table->timestamps(); // To track created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
