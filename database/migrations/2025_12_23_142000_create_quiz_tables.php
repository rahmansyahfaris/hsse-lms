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
        // 1. Quizzes Table (Linked to a Course Section)
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            // A section can have one quiz. We use course_section_id.
            $table->foreignId('course_section_id')->constrained('course_sections')->onDelete('cascade');
            $table->integer('passing_score')->default(80); // Percentage required to pass
            $table->timestamps();
        });

        // 2. Questions Table
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->text('question_text');
            $table->integer('points')->default(10); // Points for this question
            $table->integer('order')->default(0); // Display order
            $table->timestamps();
        });

        // 3. Options Table
        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_question_id')->constrained('quiz_questions')->onDelete('cascade');
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        // 4. Attempts Table (Tracks a student's take of a quiz)
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->integer('score'); // Total points earned
            $table->integer('total_points'); // Total points possible
            $table->boolean('passed')->default(false);
            $table->timestamps();
        });
        
        // 5. Attempt Answers Table (Detailed History - "Pro" Feature)
        Schema::create('quiz_attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_attempt_id')->constrained('quiz_attempts')->onDelete('cascade');
            $table->foreignId('quiz_question_id')->constrained('quiz_questions')->onDelete('cascade');
            $table->foreignId('quiz_option_id')->constrained('quiz_options')->onDelete('cascade'); // The option selected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempt_answers');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('quiz_options');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
