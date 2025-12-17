<?php

namespace App\Http\Controllers;

use App\Models\CourseSection;
use App\Models\SectionProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionProgressController extends Controller
{
    /**
     * Mark a section as complete.
     */
    public function markComplete(Request $request, CourseSection $section)
    {
        $user = Auth::user();

        // Update or create progress record
        SectionProgress::updateOrCreate(
            ['user_id' => $user->id, 'course_section_id' => $section->id],
            ['completed' => true]
        );

        return response()->json(['message' => 'Section marked as complete.']);
    }

    /**
     * Update video watch progress.
     */
    public function updateVideoProgress(Request $request, CourseSection $section)
    {
        $request->validate([
            'watch_time' => 'required|integer|min:0',
            'total_duration' => 'nullable|integer|min:0',
        ]);

        $user = Auth::user();
        $watchTime = $request->input('watch_time');
        $totalDuration = $request->input('total_duration');

        // Logic: specific completion threshold for videos (e.g., 90%)
        // If we want to strictly enforce it here, we checks watchTime / totalDuration
        $completed = false;
        if ($totalDuration > 0) {
            $percentage = ($watchTime / $totalDuration) * 100;
            if ($percentage >= 90) {
                $completed = true;
            }
        }

        $data = [
            'watch_time' => $watchTime,
            'total_duration' => $totalDuration,
        ];

        // Only mark complete if threshold reached or if it was already complete
        if ($completed) {
            $data['completed'] = true;
        }

        SectionProgress::updateOrCreate(
            ['user_id' => $user->id, 'course_section_id' => $section->id],
            $data
        );

        return response()->json([
            'message' => 'Progress updated.',
            'completed' => $completed
        ]);
    }
}
