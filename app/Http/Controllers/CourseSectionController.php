<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $originalFilename = null;

        if ($request->hasFile('content_file')) {
            // Store in 'storage/app/public/course_content'
            // Returns the path relative to 'public/' e.g. 'course_content/xyz.jpg'
            $contentPath = $request->file('content_file')->store('course_content', 'public');
            $originalFilename = $request->file('content_file')->getClientOriginalName();
        }

        $course->sections()->create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'content' => $contentPath,
            'original_filename' => $originalFilename,
            'order' => $course->sections()->count() + 1,
        ]);

        return redirect()->route('courses.sections.index', $course)
            ->with('success', 'Section created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, CourseSection $section)
    {
        return view('courses.sections.edit', compact('course', 'section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, CourseSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,reading,quiz,document',
            'content_file' => 'nullable|file|max:102400', // Optional on update
        ]);

        // Updates
        $section->title = $validated['title'];
        $section->type = $validated['type'];

        // Handle File Update
        if ($request->hasFile('content_file')) {
            // Delete old file if it exists
            if ($section->content && Storage::disk('public')->exists($section->content)) {
                Storage::disk('public')->delete($section->content);
            }

            // Upload new file
            $section->content = $request->file('content_file')->store('course_content', 'public');
            $section->original_filename = $request->file('content_file')->getClientOriginalName();
        }

        $section->save();

        return redirect()->route('courses.sections.index', $course)
            ->with('success', 'Section updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, CourseSection $section)
    {
        // Delete file from storage
        if ($section->content && Storage::disk('public')->exists($section->content)) {
            Storage::disk('public')->delete($section->content);
        }

        $section->delete();

        return redirect()->route('courses.sections.index', $course)
            ->with('success', 'Section deleted successfully!');
    }
}
