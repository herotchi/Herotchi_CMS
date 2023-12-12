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
        Schema::table('second_categories', function (Blueprint $table) {
            //
            $table->dropUnique(['name']);
            $table->unique(['first_category_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('second_categories', function (Blueprint $table) {
            //
            $table->dropUnique(['first_category_id', 'name']);
            $table->unique(['name']);
        });
    }
};
