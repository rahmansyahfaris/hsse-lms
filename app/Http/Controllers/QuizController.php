<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Show the form for editing the quiz content for a specific section.
     */
    public function edit(Course $course, CourseSection $section)
    {
        // Ensure this section is a quiz
        if ($section->type !== 'quiz') {
            return redirect()->back()->with('error', 'This section is not a quiz.');
        }

        // Get or create the quiz record
        $quiz = $section->quiz ?? $section->quiz()->create([
            'passing_score' => 80
        ]);

        // Load questions and options
        $quiz->load('questions.options');

        return view('quizzes.edit', compact('section', 'quiz'));
    }

    /**
     * Store/Update validation logic for quiz questions.
     */
    public function update(Request $request, Course $course, CourseSection $section)
    {
        // Simple full replacement logic for MVP
        // In a real app, we might use Livewire or a more complex sync logic.
        // For now, we'll validate a large array/JSON structure.
        
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
            'duration_minutes' => 'required|integer|min:1',
            'questions' => 'array',
            'questions.*.text' => 'required|string',
            'questions.*.points' => 'required|integer',
            'questions.*.options' => 'array|min:2', // At least 2 options
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.is_correct' => 'nullable', // Checkbox
        ]);

        $quiz = $section->quiz;
        $quiz->update([
            'title' => $validated['title'],
            'passing_score' => $validated['passing_score'],
            'duration_minutes' => $validated['duration_minutes'],
        ]);

        // Delete existing questions to simple sync (MVP approach)
        // Note: This wipes history references if not careful. For MVP dev, this is fine.
        // Ideally we would sync based on IDs.
        $quiz->questions()->delete(); 

        if (isset($validated['questions'])) {
            foreach ($validated['questions'] as $qIndex => $qData) {
                $question = $quiz->questions()->create([
                    'question_text' => $qData['text'],
                    'points' => $qData['points'],
                    'order' => $qIndex + 1,
                ]);

                if (isset($qData['options'])) {
                    foreach ($qData['options'] as $oData) {
                        $question->options()->create([
                            'option_text' => $oData['text'],
                            'is_correct' => isset($oData['is_correct']) && $oData['is_correct'] == '1',
                        ]);
                    }
                }
            }
        }

        return redirect()->route('courses.sections.index', $section->course)
            ->with('success', 'Quiz updated successfully!');
    }

    /**
     * Handle Quiz Submission (Learner Side)
     */
    public function submit(Request $request, Course $course, CourseSection $section)
    {
        $request->validate([
            'answers' => 'required|array',
            'started_at' => 'nullable|date',
            'time_spent_seconds' => 'nullable|integer',
        ]);

        $quiz = $section->quiz;
        if (!$quiz) {
            return response()->json(['error' => 'No quiz found.'], 404);
        }

        $submittedAnswers = $request->input('answers'); // [question_id => option_id]
        $questions = $quiz->questions()->with('options')->get();
        
        $score = 0;
        $totalPoints = 0;
        $attemptAnswers = [];

        foreach ($questions as $question) {
            $totalPoints += $question->points;
            
            // Check if user answered this question
            if (isset($submittedAnswers[$question->id])) {
                $selectedOptionId = $submittedAnswers[$question->id];
                $selectedOption = $question->options->where('id', $selectedOptionId)->first();

                if ($selectedOption) {
                    // Record Answer
                    $attemptAnswers[] = [
                        'quiz_question_id' => $question->id,
                        'quiz_option_id' => $selectedOption->id,
                    ];

                    // Check correctness
                    if ($selectedOption->is_correct) {
                        $score += $question->points;
                    }
                }
            }
        }

        // Calculate Result
        $percentage = $totalPoints > 0 ? ($score / $totalPoints) * 100 : 0;
        $passed = $percentage >= $quiz->passing_score;

        // Save Attempt with time tracking
        $attempt = $quiz->attempts()->create([
            'user_id' => auth()->id(),
            'score' => $score,
            'total_points' => $totalPoints,
            'passed' => $passed,
            'started_at' => $request->input('started_at'),
            'time_spent_seconds' => $request->input('time_spent_seconds'),
        ]);

        // Save Detailed Answers
        foreach ($attemptAnswers as $ans) {
            $attempt->answers()->create($ans);
        }

        // Update Section Progress if Passed
        if ($passed) {
            $section->progress()->updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'completed' => true,
                    // We could store score in 'meta' if we had a column, but key logic is 'completed'
                ]
            );
        }

        return response()->json([
            'message' => 'Quiz submitted.',
            'passed' => $passed,
            'score' => $score,
            'total_points' => $totalPoints,
            'percentage' => round($percentage),
            'attempt_id' => $attempt->id
        ]);
    }
    /**
     * Show Quiz History (Learner Side)
     */
    public function history(Course $course, CourseSection $section)
    {
        $quiz = $section->quiz;
        if (!$quiz) {
            return redirect()->back()->with('error', 'No quiz found.');
        }

        $attempts = $quiz->attempts()
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('quizzes.history', compact('course', 'section', 'quiz', 'attempts'));
    }

    /**
     * Show Specific Attempt Review (Learner Side)
     */
    public function review(Course $course, CourseSection $section, $attemptId)
    {
        $quiz = $section->quiz;
        if (!$quiz) {
            return redirect()->back()->with('error', 'No quiz found.');
        }

        // Fetch attempt and eager load answers
        $attempt = $quiz->attempts()
            ->with(['answers.question.options', 'answers.selectedOption'])
            ->where('id', $attemptId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('quizzes.review', compact('course', 'section', 'quiz', 'attempt'));
    }
}
