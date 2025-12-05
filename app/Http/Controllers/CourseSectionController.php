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
        ]);

        // Create the section
        // Note: 'content' is required by DB, so we use a placeholder for now.
        // We will implement file upload in the next phase.
        $course->sections()->create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'content' => 'Pending Content', // Placeholder
            'order' => $course->sections()->count() + 1, // Auto-increment order
        ]);

        return redirect()->route('courses.sections.index', $course)
            ->with('success', 'Section created successfully!');
    }
}
