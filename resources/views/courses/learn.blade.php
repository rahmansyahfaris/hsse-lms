<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex">
                    <!-- Sidebar: Section Navigation -->
                    <div class="w-1/4 bg-gray-50 p-6 border-r border-gray-200">
                        <h3 class="font-semibold text-lg mb-4">Course Content</h3>
                        <ul class="space-y-2">
                            @foreach ($sections as $section)
                                <li>
                                    <a href="{{ route('courses.learn', ['course' => $course->id, 'section' => $section->id]) }}" 
                                       class="block p-3 rounded {{ $currentSection && $currentSection->id === $section->id ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-gray-100' }}">
                                        <div class="flex items-center">
                                            @if ($section->type === 'video')
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                </svg>
                                            @elseif ($section->type === 'reading')
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                                </svg>
                                            @elseif ($section->type === 'document')
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                            <span class="text-sm">{{ $section->title }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Main Content Area -->
                    <div class="w-3/4 p-6">
                        @if ($currentSection)
                            <h3 class="text-2xl font-bold mb-4">{{ $currentSection->title }}</h3>
                            
                            @if ($currentSection->type === 'video')
                                <div class="bg-black rounded-lg overflow-hidden">
                                    <video controls class="w-full" controlsList="nodownload">
                                        <source src="{{ asset('storage/' . $currentSection->content) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @elseif ($currentSection->type === 'reading')
                                <div class="prose max-w-none">
                                    {!! nl2br(e($currentSection->content)) !!}
                                </div>
                            @elseif ($currentSection->type === 'document')
                                @php
                                    $fileExtension = strtolower(pathinfo($currentSection->content, PATHINFO_EXTENSION));
                                    $isPdf = $fileExtension === 'pdf';
                                @endphp

                                @if ($isPdf)
                                    {{-- PDF Viewer --}}
                                    <div class="bg-gray-100 rounded-lg overflow-hidden" style="height: 600px;">
                                        <iframe 
                                            src="{{ asset('storage/' . $currentSection->content) }}" 
                                            style="width: 100%; height: 100%; border: 0;"
                                            title="{{ $currentSection->title }}">
                                        </iframe>
                                    </div>
                                @else
                                    {{-- Non-PDF Fallback --}}
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                        <svg class="mx-auto h-11 w-11 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Document Cannot Be Viewed</h3>
                                        <p class="mt-1 text-sm text-gray-500">{{ $currentSection->original_filename ?? basename($currentSection->content) }}</p>
                                        <p class="mt-2 text-xs text-gray-400">This file type cannot be viewed in the browser.</p>
                                        <div class="mt-6">
                                            <a href="{{ asset('storage/' . $currentSection->content) }}" 
                                               download 
                                               style="display: inline-flex; align-items: center; padding: 10px 20px; background-color: #4F46E5; color: white; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 14px;">
                                                Download Document
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="bg-gray-100 rounded-lg p-8 text-center">
                                    <p class="text-gray-600">Content type: {{ $currentSection->type }}</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <p class="text-gray-500">No sections available yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
