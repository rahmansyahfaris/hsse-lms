<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attempt Details: ') . $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Header / Summary --}}
                    <div class="border-b pb-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('quizzes.history', ['course' => $course->id, 'section' => $section->id]) }}" class="text-gray-500 hover:text-gray-700">
                                    ← Back to History
                                </a>
                                <span class="text-gray-300">|</span>
                                <span class="text-sm text-gray-500">Attempted on {{ $attempt->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div>
                                @if($attempt->passed)
                                    <span class="px-4 py-2 rounded-full bg-green-100 text-green-800 font-bold border border-green-200">
                                        PASSED
                                    </span>
                                @else
                                    <span class="px-4 py-2 rounded-full bg-red-100 text-red-800 font-bold border border-red-200">
                                        FAILED
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500 uppercase font-bold tracking-wider">Score</div>
                                <div class="text-3xl font-bold {{ $attempt->passed ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $attempt->score }} / {{ $attempt->total_points }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ round(($attempt->score / $attempt->total_points) * 100) }}%
                                </div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500 uppercase font-bold tracking-wider">Passing Score</div>
                                <div class="text-3xl font-bold text-gray-700">
                                    {{ $quiz->passing_score }}%
                                </div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-500 uppercase font-bold tracking-wider">Time Spent</div>
                                <div class="text-3xl font-bold text-gray-700">
                                    @if($attempt->time_spent_seconds)
                                        {{ floor($attempt->time_spent_seconds / 60) }}m {{ $attempt->time_spent_seconds % 60 }}s
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Questions Review --}}
                    <div class="space-y-8">
                        @foreach($quiz->questions as $index => $question)
                            @php
                                $userAnswer = $attempt->answers->where('quiz_question_id', $question->id)->first();
                                $isCorrect = $userAnswer && $userAnswer->selectedOption->is_correct;
                                $statusClass = $isCorrect ? 'bg-green-50 border-green-200' : ($userAnswer ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200');
                                $icon = $isCorrect ? '✅' : ($userAnswer ? '❌' : '⚪');
                            @endphp

                            <div class="border rounded-lg p-6 {{ $statusClass }}">
                                <div class="flex items-start justify-between mb-4">
                                    <h5 class="font-bold text-lg text-gray-900 flex-1">
                                        <span class="mr-2">{{ $index + 1 }}.</span>
                                        {{ $question->question_text }}
                                        <span class="text-xs font-normal text-gray-500 ml-2">({{ $question->points }} pts)</span>
                                    </h5>
                                    <div class="ml-4 flex-shrink-0 text-xl">
                                        {{ $icon }}
                                    </div>
                                </div>

                                <div class="space-y-3 ml-6">
                                    @foreach($question->options as $option)
                                        @php
                                            $isSelected = $userAnswer && $userAnswer->quiz_option_id == $option->id;
                                            $isOptionCorrect = $option->is_correct;
                                            
                                            $optionClass = 'border-transparent';
                                            if ($isSelected) {
                                                $optionClass = $isOptionCorrect ? 'bg-green-100 border-green-500 text-green-900 shadow-sm' : 'bg-red-100 border-red-500 text-red-900 shadow-sm';
                                            } elseif ($isOptionCorrect) {
                                                $optionClass = 'bg-green-50 state-correct text-green-800 border-green-200';
                                            }
                                        @endphp

                                        <div class="flex items-center p-3 rounded-md border {{ $optionClass }}">
                                            <div class="flex-shrink-0 mr-3">
                                                @if($isSelected)
                                                    <span class="w-5 h-5 flex items-center justify-center rounded-full border {{ $isOptionCorrect ? 'border-green-600 bg-green-600' : 'border-red-600 bg-red-600' }}">
                                                        <span class="text-white text-xs">●</span>
                                                    </span>
                                                @else
                                                    <span class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-400"></span>
                                                @endif
                                            </div>
                                            <span class="flex-1 {{ $isOptionCorrect ? 'font-semibold' : '' }}">{{ $option->option_text }}</span>
                                            @if($isOptionCorrect)
                                                <span class="ml-2 text-xs font-bold text-green-700 uppercase tracking-wide">Correct Answer</span>
                                            @endif
                                            @if($isSelected && !$isOptionCorrect)
                                                <span class="ml-2 text-xs font-bold text-red-700 uppercase tracking-wide">Your Answer</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ route('courses.learn', ['course' => $course->id, 'section' => $section->id]) }}" class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Return to Quiz
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
