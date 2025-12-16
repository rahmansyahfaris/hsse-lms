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
                        <a href="{{ route('courses.sections.create', $course) }}" style="display: inline-block; padding: 10px 20px; background-color: #1F2937; color: white; border-radius: 6px; font-weight: 600; text-decoration: none;">
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
