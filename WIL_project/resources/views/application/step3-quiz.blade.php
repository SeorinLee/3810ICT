<!-- resources/views/application/step3-quiz.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span
                style="color: black; background-color: white; padding: 5px; width: 600px; height: 20px; display: inline-block;">
                Step 3: Quiz
            </span>
        </h2>

        <!-- Progress Bar Section -->
        <div class="progress-bar-container"
            style="display: flex; justify-content: space-between; width: 70%; margin: 50px auto; position: relative;">
            @php
                // Define the current step
                $currentStep = "Quiz";

                // Define all steps
                $steps = [
                    "Start" => "application.step0",
                    "Volunteer Details" => "application.step1",
                    "Video & Doc" => "application.step2",
                    "Quiz" => "application.step3",
                    "Workshop" => "application.step4",
                    "Interview" => "application.step5",
                    "Unique Job Plan" => "application.step6",
                    "Finish" => "application.step7"
                ];
            @endphp

            @foreach ($steps as $step => $route)
                        @php
                            $isCompleted = ($step == $currentStep) ? 'color: black;' : 'color: #888;';
                            $circleColor = ($step == $currentStep) ? 'background-color: dodgerblue;' : '';
                        @endphp

                        <div class="progress-step"
                            style="position: relative; padding: 10px; {{ $isCompleted }} font-size: 14px; text-align: center; flex: 1; cursor: pointer; margin-top: 20px;">
                            <a href="{{ route($route) }}" style="text-decoration: none; color: inherit;">
                                <div
                                    style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); width: 20px; height: 20px; border: 2px solid #ccc; border-radius: 50%; {{ $circleColor }}">
                                </div>
                                {{ $step }}
                            </a>
                            @if (!$loop->first)
                                        @php
                                            $lineColor = ($step == $currentStep) ? 'background-color: dodgerblue;' : 'background-color: black;';
                                        @endphp
                                        <div
                                            style="position: absolute; top: -10px; left: 0%; width: 80%; transform: translateX(-50%); height: 2px; {{ $lineColor }}">
                                        </div>
                            @endif
                        </div>
            @endforeach
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($application->quiz_passed)
                        <p>Congratulations! You passed the quiz.</p>
                        <p>You answered {{ count(json_decode($application->quiz_answers, true)) }} questions correctly.</p>
                        <a href="{{ route('application.step4') }}" class="btn btn-primary">Next</a>
                    @else
                        <p>Step 3: Please answer the following quiz questions</p>

                        <!-- Quiz Form -->
                        <form id="quizForm" action="{{ route('application.storeStep3') }}" method="POST">
                            @csrf
                            @foreach ($questions as $index => $question)
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ $question['question'] }}
                                    </label>
                                    @foreach ($question['choices'] as $choice)
                                        <div>
                                            <input type="radio" name="answers[{{ $index }}]" value="{{ $choice }}" required>
                                            <label>{{ $choice }}</label>
                                        </div>
                                    @endforeach
                                    <input type="hidden" name="questions[{{ $index }}][question]"
                                        value="{{ $question['question'] }}">
                                    <input type="hidden" name="questions[{{ $index }}][answer]"
                                        value="{{ $question['answer'] }}">
                                </div>
                            @endforeach
                            <button type="submit" style="padding: 7px 17px; font-size: 1rem;">Submit</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('quizForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to submit the quiz.');
                });
        });
    </script>
</x-app-layout>