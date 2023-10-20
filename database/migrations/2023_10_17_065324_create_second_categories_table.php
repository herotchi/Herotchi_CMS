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
        Schema::create('second_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('first_category_id')->constrained(); 
            $table->string('name', 50)->unique();
            $table->datetimeTz('created_at');
            $table->datetimeTz('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('second_categories');
    }
};
