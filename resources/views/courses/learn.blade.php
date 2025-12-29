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
                        <!-- Back Link -->
                        <div class="mb-4">
                            <a href="{{ route('courses') }}" class="text-indigo-600 hover:text-indigo-900 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Course List
                            </a>
                        </div>
                        <h3 class="font-semibold text-lg mb-4">Course Content</h3>
                        <ul class="space-y-2">
                            @foreach ($sections as $section)
                                @php
                                    $isLocked = $section->is_locked && 
                                                // It's locked if it's marked locked AND previous not completed
                                                ($loop->index > 0 && 
                                                 (!isset($progress[$sections[$loop->index - 1]->id]) || 
                                                  !$progress[$sections[$loop->index - 1]->id]->completed));
                                    
                                    $isCompleted = isset($progress[$section->id]) && $progress[$section->id]->completed;
                                    $isActive = $currentSection && $currentSection->id === $section->id;
                                @endphp
                                <li>
                                    @if($isLocked)
                                        <div class="block p-3 rounded bg-gray-100 text-gray-400 cursor-not-allowed">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <span class="mr-2">🔒</span>
                                                    <span class="text-sm">{{ $section->title }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('courses.learn', ['course' => $course->id, 'section' => $section->id]) }}" 
                                           class="block p-3 rounded {{ $isActive ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-gray-100' }}">
                                            <div class="flex items-center justify-between">
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
                                                    <span class="text-sm truncate" style="max-width: 15rem;">{{ $section->title }}</span>
                                                </div>
                                                @if($isCompleted)
                                                    <span class="text-green-500 ml-2">✅</span>
                                                @endif
                                            </div>
                                        </a>
                                    @endif
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
                            @elseif ($currentSection->type === 'quiz')
                                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                                    @php
                                        $quiz = $currentSection->quiz;
                                        // Check if user has an attempt
                                        $lastAttempt = $quiz ? $quiz->attempts()->where('user_id', auth()->id())->latest()->first() : null;
                                    @endphp

                                    @if($lastAttempt)
                                        {{-- Result View --}}
                                        <div class="text-center mb-8">
                                            <div class="inline-block p-4 rounded-full {{ $lastAttempt->passed ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} mb-4">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $lastAttempt->passed ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path></svg>
                                            </div>
                                            <h4 class="text-2xl font-bold {{ $lastAttempt->passed ? 'text-green-800' : 'text-red-800' }}">
                                                {{ $lastAttempt->passed ? 'Quiz Passed!' : 'Quiz Failed' }}
                                            </h4>
                                            <p class="text-gray-600 mt-2">
                                                Score: <span class="font-bold">{{ $lastAttempt->score }}</span> / {{ $lastAttempt->total_points }} 
                                                ({{ round(($lastAttempt->score / $lastAttempt->total_points) * 100) }}%)
                                            </p>
                                            @if(!$lastAttempt->passed)
                                                <button onclick="location.reload()" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Try Again</button>
                                            @endif
                                        </div>

                                        {{-- Detailed History --}}
                                        <div class="space-y-6">
                                            <h5 class="font-bold text-lg border-b pb-2">Attempt History</h5>
                                            @foreach($quiz->questions as $index => $question)
                                                @php
                                                    $answer = $lastAttempt->answers->where('quiz_question_id', $question->id)->first();
                                                    $isCorrect = $answer && $answer->selectedOption->is_correct;
                                                @endphp
                                                <div class="border rounded p-4 {{ $isCorrect ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                                    <p class="font-semibold mb-2">{{ $index + 1 }}. {{ $question->question_text }}</p>
                                                    <ul class="space-y-1 ml-4 text-sm">
                                                        @foreach($question->options as $option)
                                                            <li class="flex items-center">
                                                                @if($answer && $answer->quiz_option_id == $option->id)
                                                                    <span class="mr-2">{{ $isCorrect ? '✅' : '❌' }} (You)</span>
                                                                @elseif($option->is_correct)
                                                                    <span class="mr-2">Correct Answer:</span>
                                                                @endif
                                                                <span class="{{ $option->is_correct ? 'font-bold text-green-700' : '' }} {{ ($answer && $answer->quiz_option_id == $option->id && !$isCorrect) ? 'text-red-700 line-through' : '' }}">
                                                                    {{ $option->option_text }}
                                                                </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>

                                    @elseif($quiz && $quiz->questions->count() > 0)
                                        {{-- Quiz Form --}}
                                        <div class="mb-4 text-sm text-gray-500">
                                            Passing Score: {{ $quiz->passing_score }}% | Total Questions: {{ $quiz->questions->count() }}
                                        </div>
                                        <form id="quiz-form">
                                            <div class="space-y-8">
                                                @foreach($quiz->questions as $index => $question)
                                                    <div class="question-block">
                                                        <h5 class="font-bold text-lg mb-3">{{ $index + 1 }}. {{ $question->question_text }} <span class="text-xs text-gray-400">({{ $question->points }} pts)</span></h5>
                                                        <div class="space-y-2 ml-4">
                                                            @foreach($question->options as $option)
                                                                <label class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-gray-50 rounded">
                                                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="form-radio h-5 w-5 text-indigo-600 focus:ring-indigo-500" required>
                                                                    <span class="text-gray-900">{{ $option->option_text }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mt-8 pt-6 border-t">
                                                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Submit Quiz
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="text-center py-12 text-gray-500">
                                            <p>This quiz has no questions yet.</p>
                                        </div>
                                    @endif
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
                        @endif
                        
                        <!-- Next/Prev Buttons -->
                        @if ($currentSection)
                            @php
                                $currentIndex = $sections->search(function($item) use ($currentSection) {
                                    return $item->id === $currentSection->id;
                                });
                                $prevSection = $currentIndex > 0 ? $sections[$currentIndex - 1] : null;
                                $nextSection = $currentIndex < $sections->count() - 1 ? $sections[$currentIndex + 1] : null;
                                
                                // Check completion for Next button state
                                $isCompleted = isset($progress[$currentSection->id]) && $progress[$currentSection->id]->completed;
                                
                                // NEW: Check if criteria is met (for button persistence)
                                $criteriaMet = false;
                                if ($currentSection->is_skippable) {
                                    $criteriaMet = true;
                                } elseif (isset($progress[$currentSection->id])) {
                                    $sectionProgress = $progress[$currentSection->id];
                                    if ($sectionProgress->total_duration > 0) {
                                        $percentage = ($sectionProgress->watch_time / $sectionProgress->total_duration) * 100;
                                        if ($percentage >= 90) {
                                            $criteriaMet = true;
                                        }
                                    }
                                }
                                
                                $canProceed = $criteriaMet || $isCompleted;
                            @endphp
                            
                            <div class="flex justify-between mt-8 pt-4 border-t border-gray-200">
                                @if($prevSection)
                                    <a href="{{ route('courses.learn', ['course' => $course->id, 'section' => $prevSection->id]) }}" 
                                       style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #E5E7EB; color: #374151; border-radius: 6px; font-weight: 600; text-decoration: none;">
                                        ← Previous
                                    </a>
                                @else
                                    <div></div>
                                @endif

                                @if($nextSection)
                                    <a id="next-section-btn" 
                                       href="{{ route('courses.learn', ['course' => $course->id, 'section' => $nextSection->id]) }}" 
                                       style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #4F46E5; color: white; border-radius: 6px; font-weight: 600; text-decoration: none; {{ !$canProceed ? 'opacity: 0.5; pointer-events: none;' : '' }}">
                                        Next Section →
                                    </a>
                                @else
                                    {{-- Last Section: Show Finish Button --}}
                                    <button id="finish-btn"
                                       style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #10B981; color: white; border-radius: 6px; font-weight: 600; cursor: pointer; {{ !$canProceed ? 'opacity: 0.5; pointer-events: none;' : '' }}">
                                        Finish Course 🎉
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sectionId = "{{ $currentSection->id ?? '' }}";
            const sectionType = "{{ $currentSection->type ?? '' }}";
            
            if (!sectionId) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const nextBtn = document.getElementById('next-section-btn');
            const finishBtn = document.getElementById('finish-btn');
            
            // --- UI HELPERS ---
            function enableProceedButton() {
                if(nextBtn) {
                    nextBtn.style.opacity = '1';
                    nextBtn.style.pointerEvents = 'auto';
                }
                if(finishBtn) {
                    finishBtn.style.opacity = '1';
                    finishBtn.style.pointerEvents = 'auto';
                }
            }

            // --- CLICK HANDLER (EXPLICIT COMPLETION) ---
            function handleProceed(e) {
                e.preventDefault();
                const targetUrl = this.getAttribute('href'); // For Next button
                
                // Call Mark Complete
                fetch(`/sections/${sectionId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Section marked complete explicitly.');
                    if(targetUrl) {
                        window.location.href = targetUrl;
                    } else {
                        // If Finish Button, reload or go to course index
                        window.location.href = "{{ route('courses') }}";
                    }
                });
            }

            if(nextBtn) nextBtn.addEventListener('click', handleProceed);
            if(finishBtn) finishBtn.addEventListener('click', handleProceed);

            // --- DOCUMENT LOGIC ---
            if (sectionType === 'document' || sectionType === 'reading') {
                // Documents/Readings are "view to complete", so enable button immediately
                enableProceedButton();
            }

            // --- VIDEO LOGIC ---
            const videoElement = document.querySelector('video');
            
            if (sectionType === 'video' && videoElement) {
                // ... (Existing video logic) ...
                let lastUpdateTime = 0;
                videoElement.addEventListener('timeupdate', function() {
                    const currentTime = Math.floor(videoElement.currentTime);
                    const totalDuration = Math.floor(videoElement.duration);
                    if (currentTime > lastUpdateTime) {
                        lastUpdateTime = currentTime;
                        fetch(`/sections/${sectionId}/progress`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                            body: JSON.stringify({ watch_time: currentTime, total_duration: totalDuration })
                        }).then(r => r.json()).then(d => { if(d.criteria_met) enableProceedButton(); });
                    }
                });
            }

            // --- QUIZ LOGIC ---
            const quizForm = document.getElementById('quiz-form');
            if (sectionType === 'quiz' && quizForm) {
                quizForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Collect answers
                    const formData = new FormData(quizForm);
                    const answers = {};
                    for(let [key, value] of formData.entries()) {
                        // key is "answers[123]", extract 123
                        const qId = key.match(/\d+/)[0];
                        answers[qId] = value;
                    }

                    fetch(`/sections/${sectionId}/quiz-submit`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ answers: answers })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.passed) {
                            alert('Quiz Passed! Score: ' + data.score + '%');
                            window.location.reload(); // Reload to show history & unlock Next
                        } else {
                            alert('Quiz Failed. Score: ' + data.score + '%. Please try again.');
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Quiz Error:', error);
                        alert('Something went wrong submitting the quiz.');
                    });
                });
            }
        });
    </script>
</x-app-layout>
