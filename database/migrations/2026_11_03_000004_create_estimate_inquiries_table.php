<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estimate_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 30)->unique();

            // Package snapshot (so old enquiries keep the rate they were quoted at)
            $table->string('package_slug', 60);
            $table->string('package_name', 80);
            $table->unsignedInteger('rate');
            $table->boolean('is_starting_rate')->default(false);

            // House configuration
            $table->unsignedTinyInteger('floors');
            $table->string('district', 60);
            $table->string('town_area', 160);
            $table->string('design_status', 80);
            $table->string('approval_status', 120);

            // Areas / estimate
            $table->decimal('ground_area', 10, 2)->default(0);
            $table->decimal('first_area', 10, 2)->default(0);
            $table->decimal('second_area', 10, 2)->default(0);
            $table->decimal('total_area', 10, 2)->default(0);
            $table->unsignedBigInteger('estimated_cost')->default(0);
            $table->json('rooms')->nullable();

            // Client
            $table->string('name', 120);
            $table->string('phone', 40);
            $table->string('email', 190)->nullable();
            $table->string('land_ownership', 40)->nullable();
            $table->date('start_date')->nullable();
            $table->text('comments')->nullable();

            // Admin side
            $table->string('status', 20)->default('new')->index();
            $table->text('admin_notes')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->string('ip', 45)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estimate_inquiries');
    }
};
