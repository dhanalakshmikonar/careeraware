<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('awareness_session_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_option_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure only one response per question per user per session
            $table->unique(['user_id', 'awareness_session_id', 'question_id'], 'usr_sess_q_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_responses');
    }
};
