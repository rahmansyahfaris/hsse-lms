<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    @if(auth()->user()->role === 'instructor' || auth()->user()->role === 'admin')
                        <div class="mt-6 border-t pt-4">
                            <h3 class="text-lg font-medium mb-4">Instructor Controls</h3>
                            <a href="{{ route('courses.create') }}" style="display: inline-block; padding: 10px 20px; background-color: #4F46E5; color: white; border-radius: 6px; font-weight: 600; text-decoration: none;">
                                + Create New Course
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
