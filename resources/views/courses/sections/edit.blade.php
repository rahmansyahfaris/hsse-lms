<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Section: ') . $section->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('courses.sections.update', [$course, $section]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Section Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $section->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <!-- Type -->
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Section Type</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="video" {{ $section->type == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="reading" {{ $section->type == 'reading' ? 'selected' : '' }}>Reading</option>
                                <option value="quiz" {{ $section->type == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                <option value="document" {{ $section->type == 'document' ? 'selected' : '' }}>Document</option>
                            </select>
                        </div>

                        <!-- Content (File Upload) -->
                        <div class="mb-4">
                            <label for="content_file" class="block text-sm font-medium text-gray-700">Replace Content File (Optional)</label>
                            @if($section->content)
                                <div style="background-color: #ecfdf5; border: 1px solid #10b981; color: #064e3b; padding: 12px; border-radius: 6px; margin-bottom: 12px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <div style="display: flex; align-items: center;">
                                            <span style="font-size: 1.25rem; margin-right: 8px;">✅</span>
                                            <div>
                                                <div style="font-weight: bold; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">Current File Attached</div>
                                                <div style="font-family: monospace; font-size: 1rem; margin-top: 4px;">
                                                    {{ $section->original_filename ?? basename($section->content) }}
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . $section->content) }}" target="_blank" style="display: inline-block; padding: 8px 16px; background-color: #10b981; color: white; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                            Preview File
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="content_file" id="content_file" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                            ">
                            <p class="mt-1 text-xs text-gray-500">Upload new file to replace current content. Max size: 100MB.</p>
                        </div>

                        <!-- Lock Section -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_locked" value="1" {{ old('is_locked', $section->is_locked) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-gray-700">Lock this section (Requires previous section completion)</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('courses.sections.index', $course) }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Section
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
