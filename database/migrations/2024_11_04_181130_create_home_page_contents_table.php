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
        Schema::create('home_page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('search_placeholder')->nullable();
            $table->string('button_text')->nullable();
            $table->string('signup_text')->nullable();
            $table->string('how_to_use_title')->nullable();
            $table->text('how_to_use_description')->nullable();
            $table->string('step_one_title')->nullable();
            $table->string('step_one_description')->nullable();
            $table->string('step_two_title')->nullable();
            $table->string('step_two_description')->nullable();
            $table->string('step_three_title')->nullable();
            $table->string('step_three_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page_contents');
    }
};
