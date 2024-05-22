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
            style="display: flex; justify-content: space-between; width: 100%; margin: 50px auto; position: relative;">
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
                                    style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); width: 30px; height: 30px; border: 2px solid #ccc; border-radius: 50%; {{ $circleColor }}">
                                </div>
                                {{ $step }}
                            </a>
                            @if (!$loop->first)
                                        @php
                                            $lineColor = ($step == $currentStep) ? 'background-color: dodgerblue;' : 'background-color: black;';
                                        @endphp
                                        <div
                                            style="position: absolute; top: -12px; left: 0%; width: 80%; transform: translateX(-50%); height: 2px; {{ $lineColor }}">
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
                                Interview information
                            </label>
                            <textarea id="interview_script" name="interview_script" rows="5"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>{{ $application->interview_script }}</textarea>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <button id="saveButton"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Check and Confirm
                            </button>
                            <a href="{{ route('application.step6') }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Next
                            </a>
                        </div>

                        <div id="commentsSection" class="mt-4" style="display: none;">
                            <div class="flex">
                                <div class="w-1/2 p-2 border-r">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="interview_finding">
                                        Interview Session
                                    </label>
                                    <textarea id="interview_finding" name="interview_finding" rows="5"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $application->interview_finding }}</textarea>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="interview_finding">
                                        Interview Findings
                                    </label>
                                    <textarea id="interview_finding" name="interview_finding" rows="5"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $application->interview_finding }}</textarea>
                                </div>
                                <div class="w-1/2 p-2">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="interview_comments">
                                        Add Comments
                                    </label>
                                    <div id="commentsChat" class="mt-4 overflow-y-auto"
                                        style="height: 200px; border: 1px solid #ccc; padding: 10px;">
                                        @foreach ($comments as $comment)
                                            <div class="mb-2">
                                                <strong>{{ $comment->user->first_name }}:</strong> {{ $comment->comment }}
                                                <br>
                                                <small>[{{ $comment->created_at->format('Y-m-d H:i') }}]</small>
                                            </div>
                                        @endforeach
                                    </div>

                                    <textarea id="interview_comments" name="interview_comments" rows="2"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                    <button id="addCommentButton"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-2">
                                        Add Comment
                                    </button>

                                </div>
                            </div>
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
            const interviewFinding = document.getElementById('interview_finding').value;

            fetch('{{ route('application.storeStep5') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    interview_script: interviewScript,
                    interview_finding: interviewFinding
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Interview details saved successfully.');
                        document.getElementById('commentsSection').style.display = 'block';
                    } else {
                        alert('Failed to save interview details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to save interview details.');
                });
        });

        document.getElementById('addCommentButton').addEventListener('click', function () {
            const interviewComments = document.getElementById('interview_comments').value;

            fetch('{{ route('application.storeStep5') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    interview_comments: interviewComments
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const commentsChat = document.getElementById('commentsChat');
                        const newComment = document.createElement('div');
                        newComment.classList.add('mb-2');
                        newComment.innerHTML = `
                            <strong>${data.comment.user.name}:</strong> ${data.comment.comment}
                        `;
                        commentsChat.appendChild(newComment);
                        document.getElementById('interview_comments').value = '';
                    } else {
                        alert('Failed to add comment.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to add comment.');
                });
        });
    </script>
</x-app-layout>