<?php

namespace App\Http\Controllers;

use App\Models\Course;

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

        Course::create($validated);

        return redirect()->route('courses')->with('success', 'Course created successfully!');
    }
}


