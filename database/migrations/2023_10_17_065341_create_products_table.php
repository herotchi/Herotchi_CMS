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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('first_category_id')->constrained();
            $table->foreignId('second_category_id')->constrained();
            $table->string('name', 50);
            $table->string('image', 255);
            $table->text('detail');
            $table->tinyInteger('release_flg')->default(2)->unsigned();
            $table->datetimeTz('created_at');
            $table->datetimeTz('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
