<!-- resources/views/application/step5-interview.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span
                style="color: black; background-color: white; padding: 5px; width: 800px; height: 20px; display: inline-block;">
                Interview
            </span>
        </h2>

        <!-- Progress Bar Section -->
        <div class="progress-bar-container"
            style="display: flex; justify-content: space-between; width: 80%; margin: 50px auto; position: relative;">
            @php
                // Define the current step
                $currentStep = "Interview";

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
                    @if($application)
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="interview_script">
                                Interview Script
                            </label>
                            <textarea id="interview_script" name="interview_script" rows="10"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>{{ $application->interview_script }}</textarea>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="interview_comments">
                                Comments
                            </label>
                            <textarea id="interview_comments" name="interview_comments" rows="5"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $application->interview_comments }}</textarea>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button id="saveButton"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Save
                            </button>
                            <a href="{{ route('application.step6') }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Next
                            </a>
                        </div>
                    @else
                        <p>No application found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('saveButton').addEventListener('click', function () {
            const interviewScript = document.getElementById('interview_script').value;
            const interviewComments = document.getElementById('interview_comments').value;

            fetch('{{ route('application.storeStep5') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    interview_script: interviewScript,
                    interview_comments: interviewComments
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Interview details saved successfully.');
                    } else {
                        alert('Failed to save interview details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to save interview details.');
                });
        });
    </script>
</x-app-layout>