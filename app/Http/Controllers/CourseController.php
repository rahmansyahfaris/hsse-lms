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
}


