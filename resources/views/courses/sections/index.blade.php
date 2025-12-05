<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Sections') }}: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Add Section Button -->
                    <div class="mb-6">
                        <a href="{{ route('courses.sections.create', $course) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Add Section
                        </a>
                    </div>

                    <!-- Sections List -->
                    @if($sections->count() > 0)
                        <div class="space-y-4">
                            @foreach($sections as $section)
                                <div class="border rounded-lg p-4 flex justify-between items-center">
                                    <div>
                                        <h3 class="font-semibold">{{ $section->title }}</h3>
                                        <p class="text-sm text-gray-600">Type: {{ ucfirst($section->type) }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">No sections yet. Add one to get started!</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
