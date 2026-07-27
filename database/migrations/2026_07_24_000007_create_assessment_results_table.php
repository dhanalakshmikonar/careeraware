<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('awareness_session_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('top_careers'); // [{code: 'AI', name: 'AI Engineer', confidence: 85}, ...]
            $table->json('career_scores'); // {AI: 85, ML: 70, ...}
            $table->timestamps();

            $table->unique(['user_id', 'awareness_session_id'], 'usr_sess_res_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};
