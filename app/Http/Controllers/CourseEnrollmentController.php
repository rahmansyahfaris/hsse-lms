<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseEnrollmentController extends Controller
{
    /**
     * Enroll the authenticated user in the given course.
     */
    public function store(Request $request, Course $course)
    {
        $user = Auth::user();

        // Prevent duplicate enrollment
        if (!$user->courses()->where('course_id', $course->id)->exists()) {
            $user->courses()->attach($course->id);
            $message = 'You have successfully enrolled in ' . $course->title . '!';
        } else {
            $message = 'You are already enrolled in this course.';
        }

        // Redirect to the learning page
        return redirect()->route('courses.learn', $course)
            ->with('success', $message);
    }
}
