<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        // Load sections for the course
        $sections = $course->sections;

        return view('courses.sections.index', compact('course', 'sections'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('courses.sections.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,reading,quiz,document',
            'content_file' => 'required|file|max:102400', // Max 100MB
        ]);

        $contentPath = 'No Content';

        if ($request->hasFile('content_file')) {
            // Store in 'storage/app/public/course_content'
            // Returns the path relative to 'public/' e.g. 'course_content/xyz.jpg'
            $contentPath = $request->file('content_file')->store('course_content', 'public');
        }

        $course->sections()->create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'content' => $contentPath,
            'order' => $course->sections()->count() + 1,
        ]);

        return redirect()->route('courses.sections.index', $course)
            ->with('success', 'Section created successfully!');
    }
}
