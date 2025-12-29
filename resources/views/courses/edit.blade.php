<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('courses.update', $course) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Course Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description', $course->description) }}</textarea>
                        </div>

                        <!-- Duration (Optional) -->
                        <div class="mb-4">
                            <label for="duration_hours" class="block text-sm font-medium text-gray-700">Duration (Hours) - Optional</label>
                            <input type="number" name="duration_hours" id="duration_hours" value="{{ old('duration_hours', $course->duration_hours) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a href="{{ route('courses') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Course
                            </button>
                        </div>
                    </form>

                    <!-- Delete Course Section -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Danger Zone</h3>
                        <p class="text-sm text-gray-600 mb-4">Once you delete a course, there is no going back. This will also delete all sections and their files.</p>
                        
                        <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone and will delete all sections and files.');">
                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Delete Course
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
