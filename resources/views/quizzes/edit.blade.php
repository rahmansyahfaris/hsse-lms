<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz Builder: ') . $section->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-bold">Details & Questions</h3>
                        <a href="{{ route('courses.sections.index', $section->course) }}" class="text-gray-600 hover:text-gray-900">
                            ← Back to Sections
                        </a>
                    </div>

                    <form method="POST" action="{{ route('quizzes.update', [$section->course, $section]) }}">
                        @csrf
                        @method('PUT')

                        <!-- Quiz Title -->>
                        <div class="mb-6 border-b pb-6">
                            <label class="block text-sm font-medium text-gray-700">Quiz Title (Optional)</label>
                            <input type="text" name="title" value="{{ old('title', $quiz->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-xs text-gray-500 mt-1">Displayed on the quiz start screen. Defaults to section title if empty.</p>
                        </div>

                        <!-- Passing Score -->
                        <div class="mb-6 border-b pb-6">
                            <label class="block text-sm font-medium text-gray-700">Passing Score (%)</label>
                            <input type="number" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}" class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="0" max="100">
                            <p class="text-xs text-gray-500 mt-1">Student must achieve this percentage to complete the section.</p>
                        </div>

                        <!-- Duration -->
                        <div class="mb-6 border-b pb-6">
                            <label class="block text-sm font-medium text-gray-700">Time Limit (Minutes)</label>
                            <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $quiz->duration_minutes ?? 10) }}" class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="1">
                            <p class="text-xs text-gray-500 mt-1">Countdown timer duration. Quiz auto-submits when time runs out.</p>
                        </div>

                        <!-- Questions Container -->
                        <div id="questions-container" class="space-y-6">
                            @foreach($quiz->questions as $qIndex => $question)
                                <div class="question-card border border-gray-200 rounded-lg p-4 bg-gray-50" data-index="{{ $qIndex }}">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex-1 mr-4">
                                            <label class="block text-xs font-bold text-gray-500 uppercase">Question Text</label>
                                            <textarea name="questions[{{ $qIndex }}][text]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2" required>{{ $question->question_text }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase">Points</label>
                                            <input type="number" name="questions[{{ $qIndex }}][points]" value="{{ $question->points }}" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        </div>
                                        <button type="button" class="ml-4 text-red-500 hover:text-red-700" onclick="removeQuestion(this)">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>

                                    <!-- Options -->
                                    <div class="ml-4 pl-4 border-l-2 border-gray-300">
                                        <div class="options-container space-y-2">
                                            @foreach($question->options as $oIndex => $option)
                                                <div class="flex items-center option-row">
                                                    <input type="hidden" name="questions[{{ $qIndex }}][options][{{ $oIndex }}][is_correct]" value="0">
                                                    <input type="checkbox" name="questions[{{ $qIndex }}][options][{{ $oIndex }}][is_correct]" value="1" class="rounded border-gray-300 text-green-600 focus:ring-green-500 mr-2" {{ $option->is_correct ? 'checked' : '' }}>
                                                    <input type="text" name="questions[{{ $qIndex }}][options][{{ $oIndex }}][text]" value="{{ $option->option_text }}" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required placeholder="Option text...">
                                                    <button type="button" class="ml-2 text-gray-400 hover:text-red-500" onclick="removeOption(this)">×</button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium" onclick="addOption(this)">+ Add Option</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <button type="button" id="add-question-btn" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-indigo-500 hover:text-indigo-500 font-medium transition-colors">
                                + Add New Question
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-4">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150"
                                    style="background-color: #4F46E5; color: white;">
                                Save Quiz
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Logic -->
    <script>
        let questionCount = {{ $quiz->questions->count() }};
        
        document.getElementById('add-question-btn').addEventListener('click', function() {
            const container = document.getElementById('questions-container');
            const index = questionCount++;
            
            const html = `
                <div class="question-card border border-gray-200 rounded-lg p-4 bg-gray-50" data-index="${index}">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1 mr-4">
                            <label class="block text-xs font-bold text-gray-500 uppercase">Question Text</label>
                            <textarea name="questions[${index}][text]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2" required></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase">Points</label>
                            <input type="number" name="questions[${index}][points]" value="10" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <button type="button" class="ml-4 text-red-500 hover:text-red-700" onclick="removeQuestion(this)">
                            Remove
                        </button>
                    </div>
                    <div class="ml-4 pl-4 border-l-2 border-gray-300">
                        <div class="options-container space-y-2">
                             ${getOptionHtml(index, 0)}
                             ${getOptionHtml(index, 1)}
                        </div>
                        <button type="button" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium" onclick="addOption(this)">+ Add Option</button>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', html);
        });

        function getOptionHtml(qIndex, oIndex) {
            return `
                <div class="flex items-center option-row">
                    <input type="hidden" name="questions[${qIndex}][options][${oIndex}][is_correct]" value="0">
                    <input type="checkbox" name="questions[${qIndex}][options][${oIndex}][is_correct]" value="1" class="rounded border-gray-300 text-green-600 focus:ring-green-500 mr-2">
                    <input type="text" name="questions[${qIndex}][options][${oIndex}][text]" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required placeholder="Option text...">
                    <button type="button" class="ml-2 text-gray-400 hover:text-red-500" onclick="removeOption(this)">×</button>
                </div>
            `;
        }

        window.addOption = function(btn) {
            const container = btn.previousElementSibling;
            const qCard = btn.closest('.question-card');
            const qIndex = qCard.dataset.index;
            const oIndex = container.children.length; // Simple increment
            // Note: In robust Production apps, use a unique ID generator. For MVP simple array index is risky if we delete, but Laravel handles array keys nicely if distinct.
            // Actually, deleting options messes up indexes if we just count length.
            // Better: Use Date.now() for unique keys if modifying structure heavily.
            // But strict PHP array parsing might expect sequential or named keys.
            // Let's stick to simple timestamp-based index for safety to avoid collisions on delete.
            const uniqueOIndex = Date.now() + Math.floor(Math.random() * 1000); 

            container.insertAdjacentHTML('beforeend', getOptionHtml(qIndex, uniqueOIndex));
        };

        window.removeQuestion = function(btn) {
            if(confirm('Delete this question?')) {
                btn.closest('.question-card').remove();
            }
        };

        window.removeOption = function(btn) {
            const container = btn.closest('.options-container');
            if(container.children.length <= 2) {
                alert('A question must have at least 2 options.');
                return;
            }
            btn.closest('.option-row').remove();
        };
    </script>
</x-app-layout>
