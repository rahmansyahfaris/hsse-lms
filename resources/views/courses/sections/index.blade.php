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
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <a href="{{ route('courses') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                            </a>
                            <h3 class="text-lg font-medium text-gray-900">Manage Sections: {{ $course->title }}</h3>
                        </div>
                        <a href="{{ route('courses.sections.create', $course) }}" style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #4F46E5; color: white; border-radius: 6px; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em; text-decoration: none;">
                            Add New Section
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
                                        <!-- Reorder Buttons -->
                                        @if(!$loop->first)
                                            <form action="{{ route('courses.sections.reorder', [$course, $section]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="direction" value="up">
                                                <button type="submit" class="p-1 text-gray-500 hover:text-gray-700 bg-gray-100 rounded">
                                                    ↑
                                                </button>
                                            </form>
                                        @endif
                                        @if(!$loop->last)
                                            <form action="{{ route('courses.sections.reorder', [$course, $section]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="direction" value="down">
                                                <button type="submit" class="p-1 text-gray-500 hover:text-gray-700 bg-gray-100 rounded">
                                                    ↓
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('courses.sections.edit', [$course, $section]) }}" style="display: inline-block; padding: 6px 12px; background-color: #3B82F6; color: white; border-radius: 4px; font-size: 14px; text-decoration: none;">
                                            Edit
                                        </a>
                                        <form action="{{ route('courses.sections.destroy', [$course, $section]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this section? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="display: inline-block; padding: 6px 12px; background-color: #EF4444; color: white; border-radius: 4px; font-size: 14px; border: none; cursor: pointer;">
                                                Delete
                                            </button>
                                        </form>
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
