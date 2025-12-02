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
}
