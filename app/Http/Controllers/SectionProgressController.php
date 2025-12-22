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

        // Video Logic
        $percentage = 0;
        if ($totalDuration > 0) {
            $percentage = ($watchTime / $totalDuration) * 100;
        }

        // Completion Rules (Explicit Mode):
        // We do NOT mark 'completed' here anymore.
        // We just tell the frontend if the criteria is met.
        
        $criteriaMet = false;
        
        if ($section->is_skippable) {
            $criteriaMet = true; 
        } elseif ($percentage >= 90) {
            $criteriaMet = true;
        }

        $data = [
            'watch_time' => $watchTime,
            'total_duration' => $totalDuration,
        ];
        
        // If it was ALREADY complete, keep it complete. 
        // But we don't set it to true if it's currently false.
        
        SectionProgress::updateOrCreate(
            ['user_id' => $user->id, 'course_section_id' => $section->id],
            $data
        );

        $progress = SectionProgress::where('user_id', $user->id)
                                   ->where('course_section_id', $section->id)
                                   ->first();

        return response()->json([
            'message' => 'Progress updated.',
            'criteria_met' => $criteriaMet,
            'completed' => $progress ? $progress->completed : false
        ]);
    }
}
