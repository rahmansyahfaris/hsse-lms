<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


