<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Step 1: Add phone as nullable (to prevent duplicate empty entries)
            $table->string('phone')->nullable()->after('email');
        });

        // Step 2: Fill existing rows with temporary unique values
        DB::statement("UPDATE users SET phone = CONCAT('temp_', id) WHERE phone IS NULL OR phone = ''");

        // Step 3: Now make the column unique
        Schema::table('users', function (Blueprint $table) {
            $table->unique('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone']);
            $table->dropColumn('phone');
        });
    }
};
