<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_paths', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., 'AI', 'Full Stack'
            $table->string('name');
            $table->text('description');
            $table->json('skills');
            $table->json('certifications');
            $table->json('projects');
            $table->string('salary_range');
            $table->string('demand_status');
            $table->json('roadmap');
            $table->json('swot'); // {strengths: [], weaknesses: [], opportunities: [], threats: []}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_paths');
    }
};
