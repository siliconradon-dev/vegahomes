<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('status', 20)->default('ongoing')->index(); // ongoing | completed | design
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('progress')->nullable();       // % complete (ongoing projects)
            $table->date('started_on')->nullable();
            $table->date('completed_on')->nullable();
            $table->json('images')->nullable();                        // paths relative to /public - first image is the cover
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
