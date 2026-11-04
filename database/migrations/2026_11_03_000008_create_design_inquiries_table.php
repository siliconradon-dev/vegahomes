<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('design_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 30)->unique();

            // Package snapshot
            $table->string('package_slug', 60);
            $table->string('package_name', 80);
            $table->string('pricing_type', 20);
            $table->decimal('rate', 8, 2);
            $table->unsignedInteger('construction_rate');

            // Project + estimate
            $table->decimal('area', 12, 2);
            $table->string('house_type', 40);
            $table->string('district', 60)->nullable();
            $table->unsignedBigInteger('construction_estimate')->default(0);
            $table->unsignedBigInteger('design_fee')->default(0);
            $table->string('calculation_basis')->nullable();
            $table->json('addons')->nullable();

            // Client
            $table->string('name', 120);
            $table->string('phone', 40);
            $table->string('email', 190)->nullable();
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
        Schema::dropIfExists('design_inquiries');
    }
};
