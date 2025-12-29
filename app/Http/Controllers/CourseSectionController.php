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
            'content_file' => 'nullable|file|max:102400', // Nullable for quizzes
            'is_locked' => 'nullable|boolean',
            'is_unskippable' => 'nullable|boolean',
        ]);

        // Validation Hook: Require content_file if type is NOT quiz
        if ($validated['type'] !== 'quiz' && !$request->hasFile('content_file')) {
            return back()->withErrors(['content_file' => 'Content file is required for Video, Reading, or Document sections.'])->withInput();
        }

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
            'is_locked' => $request->has('is_locked'),
            'is_skippable' => !$request->has('is_unskippable'), // Inverted logic
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
            'is_locked' => 'nullable|boolean',
            'is_unskippable' => 'nullable|boolean',
        ]);

        // Updates
        $section->title = $validated['title'];
        $section->type = $validated['type'];
        $section->is_locked = $request->has('is_locked');
        $section->is_skippable = !$request->has('is_unskippable'); // Inverted logic

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
    /**
     * Reorder sections.
     */
    public function reorder(Request $request, Course $course, CourseSection $section)
    {
        $direction = $request->input('direction');
        
        // Get ALL sections ordered by their current order value
        $allSections = $course->sections()->orderBy('order')->get();
        
        // Find the current section's position in the list (0-indexed)
        $currentPosition = $allSections->search(function($s) use ($section) {
            return $s->id === $section->id;
        });

        if ($currentPosition === false) {
            return back()->withErrors('Section not found.');
        }

        // Determine the target position
        $targetPosition = null;
        if ($direction === 'up' && $currentPosition > 0) {
            $targetPosition = $currentPosition - 1;
        } elseif ($direction === 'down' && $currentPosition < $allSections->count() - 1) {
            $targetPosition = $currentPosition + 1;
        }

        // If we have a valid target, swap the two sections
        if ($targetPosition !== null) {
            $currentSection = $allSections[$currentPosition];
            $targetSection = $allSections[$targetPosition];
            
            // Swap their order values
            $tempOrder = $currentSection->order;
            $currentSection->order = $targetSection->order;
            $targetSection->order = $tempOrder;
            
            $currentSection->save();
            $targetSection->save();
        }

        return back()->with('success', 'Section order updated.');
    }
}
