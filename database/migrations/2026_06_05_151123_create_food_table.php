<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {

            $table->id();

            // Food name/title
            $table->string('title');

            // Food description/details
            $table->text('detail');

            // Food price
            $table->string('price');

            // Food image filename
            $table->string('image')->nullable();

            // Laravel timestamps (created_at, updated_at)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};