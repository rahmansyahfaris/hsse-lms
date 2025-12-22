<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SectionProgress;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();  // Fetch all courses from the database
        return view('courses', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_hours' => 'nullable|integer|min:0',
        ]);



        $validated['instructor_id'] = Auth::id();
        Course::create($validated);

        return redirect()->route('courses')->with('success', 'Course created successfully!');
    }

    public function learn(Course $course, \Illuminate\Http\Request $request)
    {
        // Load all sections for this course
        $sections = $course->sections()->orderBy('order')->get();

        // Fetch User Progress
        $user = Auth::user();
        $progress = SectionProgress::where('user_id', $user->id)
            ->whereIn('course_section_id', $sections->pluck('id'))
            ->get()
            ->keyBy('course_section_id');

        // Get the section ID from query parameter, or default to the first section
        $sectionId = $request->query('section');
        $currentSection = $sectionId 
            ? $sections->firstWhere('id', $sectionId)
            : $sections->first();

        // --- LOCKING LOGIC ---
        if ($currentSection && $currentSection->is_locked) {
            // Find previous section
            $currentIndex = $sections->search(function($item) use ($currentSection) {
                return $item->id === $currentSection->id;
            });

            if ($currentIndex > 0) {
                $previousSection = $sections[$currentIndex - 1];
                $prevProgress = $progress->get($previousSection->id);

                // If previous section not completed, BLOCK access
                if (!$prevProgress || !$prevProgress->completed) {
                    return redirect()->route('courses.learn', [
                        'course' => $course->id, 
                        'section' => $previousSection->id
                    ])->with('error', 'You must complete the previous section first.');
                }
            }
        }

        return view('courses.learn', compact('course', 'sections', 'currentSection', 'progress'));
    }
}


