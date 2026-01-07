<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertySlidersTable extends Migration
{
    public function up()
    {
        Schema::create('property_sliders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable(); // optional link to property
            $table->string('image')->nullable();                   // slider image
            $table->string('title')->nullable();                   // slider title
            $table->string('subtitle')->nullable();                // slider subtitle
            $table->string('discount')->nullable();                // offer text like 20% OFF
            $table->timestamps();

            $table->foreign('property_id')
                ->references('propertysid')->on('properties')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_sliders');
    }
}
