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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->year('year');
            $table->string('languages')->nullable();
            $table->string('right_ans')->nullable();
            $table->string('wrong_ans')->nullable();
            $table->string('empty_ans')->nullable();
            $table->timestamps();
            $table->unique(['name', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
