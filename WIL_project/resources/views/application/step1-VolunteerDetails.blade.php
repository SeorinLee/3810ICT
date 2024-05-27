<!-- resources/views/application/step1-VolunteerDetails.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span
                style="color: black; background-color: white; padding: 5px; width: 800px; height: 20px; display: inline-block;">
                Volunteer Details
            </span>
        </h2>

        <!-- Progress Bar Section -->
        <div class="progress-bar-container"
            style="display: flex; justify-content: space-between; width: 100%; margin: 50px auto; position: relative;">
            @php
                // Define the current step
                $currentStep = "Volunteer Details";

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
                            // Determine if the current step is completed or not
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
                                                // Determine the color of the line connecting the steps
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
                    <!-- Volunteer Details Form -->
                    <form id="applicationForm">
                        @csrf
                        <div class="mb-4">
                            <label for="club_name" class="block text-gray-700 text-sm font-bold mb-2">Club Name</label>
                            <input type="text" id="club_name" name="club_name" value="{{ $application->name ?? '' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="position_title" class="block text-gray-700 text-sm font-bold mb-2">Position
                                Title</label>
                            <input type="text" id="position_title" name="position_title"
                                value="{{ $application->position_title ?? '' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                            <select id="gender" name="gender"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="male" {{ ($application->gender ?? '') == 'male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="female" {{ ($application->gender ?? '') == 'female' ? 'selected' : '' }}>
                                    Female</option>
                                <option value="other" {{ ($application->gender ?? '') == 'other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="dob" class="block text-gray-700 text-sm font-bold mb-2">Date of Birth</label>
                            <input type="date" id="dob" name="dob" value="{{ $application->dob ?? '' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="volunteering_experience"
                                class="block text-gray-700 text-sm font-bold mb-2">Volunteering Experience</label>
                            <textarea id="volunteering_experience" name="volunteering_experience" rows="4"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $application->experience ?? '' }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Reason for
                                Participating</label>
                            <textarea id="reason" name="reason" rows="4"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $application->reason ?? '' }}</textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="button" id="saveButton"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Save & Next
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Event listener for save button
        document.getElementById('saveButton').addEventListener('click', function () {
            const form = document.getElementById('applicationForm');
            const formData = new FormData(form);
            let missingFields = [];

            formData.forEach((value, key) => {
                if (!value) {
                    missingFields.push(key);
                }
            });

            if (missingFields.length > 0) {
                if (!confirm('Some fields are empty. Do you want to proceed without filling them?')) {
                    return;
                }
            }

            // Submit form data to storeStep1 route
            fetch('{{ route('application.storeStep1') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Response:', data);
                    if (data.success) {
                        alert('Details saved successfully.');
                        window.location.href = '{{ route('application.step2') }}';
                    } else {
                        alert('Failed to save details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to save details.');
                });
        });

        // Auto-save form data on change
        document.querySelectorAll('#applicationForm input, #applicationForm textarea, #applicationForm select').forEach(element => {
            element.addEventListener('change', function () {
                const form = document.getElementById('applicationForm');
                const formData = new FormData(form);

                fetch('{{ route('application.storeStep1') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Auto-save Response:', data);
                        if (data.success) {
                            console.log('Details saved automatically.');
                        } else {
                            console.error('Failed to save details automatically.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</x-app-layout>