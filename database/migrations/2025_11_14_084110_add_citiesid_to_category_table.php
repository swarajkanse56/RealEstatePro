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
        // Check first: column already exists or not
        if (!Schema::hasColumn('category', 'citiesid')) {
            Schema::table('category', function (Blueprint $table) {
                $table->unsignedBigInteger('citiesid')
                      ->nullable()
                      ->after('image'); // add after image column

                // Optional: add foreign key if you want
                // $table->foreign('citiesid')->references('citiesid')->on('cities');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('category', 'citiesid')) {
            Schema::table('category', function (Blueprint $table) {
                $table->dropColumn('citiesid');
            });
        }
    }
};
