<!-- resources/views/application/step2-video&doc.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span
                style="color: black; background-color: white; padding: 5px; width: 600px; height: 20px; display: inline-block;">
                Step 2: Video & Document
            </span>
        </h2>

        <!-- Progress Bar Section -->
        <div class="progress-bar-container"
            style="display: flex; justify-content: space-between; width: 70%; margin: 50px auto; position: relative;">
            @php
                // Define the current step
                $currentStep = "Video & Doc";

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
                    <p>Step 2: Please watch the video and read the document</p>

                    <!-- Video and Document Section -->
                    <div style="display: flex; justify-content: space-around;">
                        <!-- Video Section -->
                        <div style="flex: 1; padding: 20px;">
                            <h3>Video</h3>
                            <iframe width="100%" height="315" src="{{ $application->video_link ?? '' }}" frameborder="0"
                                allowfullscreen></iframe>
                        </div>

                        <!-- Document Section -->
                        <div style="flex: 1; padding: 20px;">
                            <h3>Document</h3>
                            <iframe src="{{ $application->document_link ?? '' }}" width="100%" height="600px"></iframe>
                        </div>
                    </div>

                    <!-- Save and Next Button Section -->
                    <div class="row justify-content-center" style="margin-top: 20px;">
                        <div class="card-body" style="display: flex; justify-content: right;">
                            <button type="button" onclick="confirmNextStep()"
                                style="padding: 7px 17px; font-size: 1rem;">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmNextStep() {
            const video = document.querySelector('iframe[src="{{ $application->video_link ?? '' }}"]');
            const doc = document.querySelector('iframe[src="{{ $application->document_link ?? '' }}"]');

            if (video && doc) {
                if (confirm('Have you watched the video and read the document?')) {
                    window.location.href = '{{ route('application.step3') }}';
                }
            } else {
                alert('Please make sure the video and document are properly loaded.');
            }
        }
    </script>
</x-app-layout>