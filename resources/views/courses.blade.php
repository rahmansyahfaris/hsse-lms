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

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($courses as $course)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow duration-200 border border-gray-100 dark:border-gray-700">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $course->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ $course->description }}</p>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $course->duration_hours }} hours</span>
                                </div>
                                
                                @auth
                                    <div class="mt-4 flex flex-col space-y-2">
                                        {{-- Instructor: Manage Button --}}
                                        @if(auth()->user()->role === 'instructor' || auth()->user()->role === 'admin')
                                            <a href="{{ route('courses.sections.index', $course) }}" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-md font-semibold text-sm hover:bg-indigo-700">
                                                Manage Sections
                                            </a>
                                        @endif

                                        {{-- Student: Enroll / Continue Button --}}
                                        @if(auth()->user()->courses->contains($course))
                                            {{-- Already Enrolled --}}
                                            <a href="{{ route('courses.learn', $course) }}" class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-md font-semibold text-sm hover:bg-green-700">
                                                Continue Learning
                                            </a>
                                        @else
                                            {{-- Not Enrolled --}}
                                            <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-md font-semibold text-sm hover:bg-blue-700">
                                                    Enroll Now
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


