<!-- resources/views/application/step6-uniqueJobPlan.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span
                style="color: black; background-color: white; padding: 5px; width: 800px; height: 20px; display: inline-block;">
                Unique Job Plan
            </span>
        </h2>

        <!-- Progress Bar Section -->
        <div class="progress-bar-container"
            style="display: flex; justify-content: space-between; width: 100%; margin: 50px auto; position: relative;">
            @php
                // Define the current step
                $currentStep = "Unique Job Plan";

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
                        <div class="flex flex-wrap -mx-4">
                            <div class="w-full md:w-2/3 px-4">
                                <label class="block text-gray-700 text-sm font-bold mb-4" for="unique_job_plan">
                                    Unique Job Plan
                                </label>
                                <p><small>Note: If you agree with the Unique Job Plan, click on the Confirm button. If you
                                        do not agree, leave your comments. We will revise your Unique Job Plan
                                        shortly!</small></p>
                                <textarea id="unique_job_plan" name="unique_job_plan" rows="20"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>{{ $application->unique_job_plan }}</textarea>
                            </div>
                            <div class="w-full md:w-1/3 px-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="comment">
                                    Feedback
                                </label>
                                <div id="comments-section"
                                    style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px; border-radius: 5px; margin-bottom: 1rem;">
                                    @foreach ($comments as $comment)
                                        <div class="comment mb-2">
                                            <div><strong>{{ $comment->user->first_name ?? 'Unknown User' }}</strong>:
                                                {{ $comment->comment }}
                                            </div>
                                            <small>{{ $comment->created_at->format('Y-m-d H:i') }}</small>
                                        </div>
                                    @endforeach
                                </div>
                                <textarea id="comment" name="comment" rows="4"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Type your comment here..." required></textarea>
                                <div class="text-right mt-2">
                                    <button id="addCommentButton"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Add Comment
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center space-x-4">
                                <button id="confirmButton"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Confirm
                                </button>
                                <a href="{{ route('application.step7') }}"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Next
                                </a>
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
        document.getElementById('confirmButton').addEventListener('click', function () {
            const uniqueJobPlan = document.getElementById('unique_job_plan').value;

            fetch('{{ route('application.storeStep6') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    unique_job_plan: uniqueJobPlan
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Unique Job Plan details saved successfully.');
                    } else {
                        alert('Failed to save Unique Job Plan details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to save Unique Job Plan details.');
                });
        });

        document.getElementById('addCommentButton').addEventListener('click', function () {
            const comment = document.getElementById('comment').value;

            fetch('{{ route('application.storeComment') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    comment: comment
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const commentsSection = document.getElementById('comments-section');
                        const newComment = document.createElement('div');
                        newComment.classList.add('comment', 'mb-2');
                        newComment.innerHTML = `<div><strong>${data.comment.user ? data.comment.user.name : 'Unknown User'}</strong>: ${data.comment.comment}</div><small>${new Date(data.comment.created_at).toLocaleString()}</small>`;
                        commentsSection.appendChild(newComment);
                        document.getElementById('comment').value = '';
                    } else {
                        alert(data.message || 'Failed to add comment.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to add comment.');
                });
        });
    </script>
</x-app-layout>