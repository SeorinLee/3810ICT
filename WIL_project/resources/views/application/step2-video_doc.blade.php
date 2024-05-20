<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span
                style="color: black; background-color: white; padding: 5px; width: 600px; height: 20px; display: inline-block;">View
                Page</span>

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

                    <P>Welcome to step2?</P>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>