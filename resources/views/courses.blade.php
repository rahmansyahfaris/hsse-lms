@extends('app')

@section('content')
    <h1>All Courses</h1>

    <div class="courses-list">
        @foreach ($courses as $course)
            <div class="course-card">
                <h3>{{ $course->title }}</h3>
                <p>{{ $course->description }}</p>
                <p><strong>Duration:</strong> {{ $course->duration_hours }} hours</p>
            </div>
        @endforeach
    </div>
@endsection


