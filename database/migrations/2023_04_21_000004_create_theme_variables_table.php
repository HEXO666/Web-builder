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
        Schema::create('theme_variables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('variable_key');
            $table->string('default_value');
            $table->unsignedBigInteger('section_theme_id');
            $table->string('type')->default('color'); // color, text, number, etc.
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->foreign('section_theme_id')->references('id')->on('section_themes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_variables');
    }
};
