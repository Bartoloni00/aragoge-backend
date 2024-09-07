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
        Schema::create('plannigs', function (Blueprint $table) {
            $table->id();
            $table->string('title',300);
            $table->text('description');
            $table->text('synopsis');
            $table->unsignedInteger('price');
            $table->foreignId('image_id')->nullable()->constrained('images');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('professional_id')->constrained('professionals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plannigs');
    }
};
