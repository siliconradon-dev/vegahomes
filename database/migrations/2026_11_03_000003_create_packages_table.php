<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->unsignedInteger('rate');                 // indicative selling rate, LKR per sq.ft.
            $table->boolean('is_starting_rate')->default(false); // shows "From LKR ..."
            $table->boolean('is_featured')->default(false);      // "Most popular" ribbon
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
