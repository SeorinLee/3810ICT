<!-- resources/views/application/step1-VolunteerDetails.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span
                style="color: black; background-color: white; padding: 5px; width: 600px; height: 20px; display: inline-block;">
                Detail Pages
            </span>
        </h2>

        <!-- Progress Bar Section -->
        <div class="progress-bar-container"
            style="display: flex; justify-content: space-between; width: 70%; margin: 50px auto; position: relative;">
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
                    <p>Welcome to step1?</p>

                    <!-- Form Section -->
                    <form id="applicationForm" action="{{ route('application.storeStep1') }}" method="POST">
                        @csrf
                        <div style="font-weight: bold; font-size: 1.5rem; line-height: 3; padding-left: 300px;">
                            Name:
                            <input type="text" id="name" name="name"
                                style="width: 500px; padding: 10px; margin-left: 20px; font-size: 1.2rem; border: 1px solid #ccc; border-radius: 5px;"
                                value="{{ old('name', $application->name ?? '') }}" required>
                        </div>
                        <div style="font-weight: bold; font-size: 1.5rem; line-height: 3; padding-left: 300px;">
                            Contact:
                            <input type="text" id="contact" name="contact"
                                style="width: 500px; padding: 10px; margin-left: 20px; font-size: 1.2rem; border: 1px solid #ccc; border-radius: 5px;"
                                value="{{ old('contact', $application->contact ?? '') }}" required>
                        </div>
                        <div style="font-weight: bold; font-size: 1.5rem; line-height: 3; padding-left: 300px;">
                            Email:
                            <input type="email" id="email" name="email"
                                style="width: 500px; padding: 10px; margin-left: 20px; font-size: 1.2rem; border: 1px solid #ccc; border-radius: 5px;"
                                value="{{ old('email', $application->email ?? '') }}" required>
                        </div>
                        <div style="font-weight: bold; font-size: 1.5rem; line-height: 3; padding-left: 300px;">
                            Reason for participating:
                            <textarea id="reason" name="reason"
                                style="width: 500px; padding: 10px; margin-left: 20px; font-size: 1.2rem; border: 1px solid #ccc; border-radius: 5px;"
                                required>{{ old('reason', $application->reason ?? '') }}</textarea>
                        </div>

                        <!-- Save and Next Button Section -->
                        <div class="row justify-content-center"
                            style="margin-top: 1px; padding-right: 50px; margin-bottom: 50px;">
                            <div class="card-body" style="display: flex; justify-content: right;">
                                <button type="button" onclick="saveApplication()"
                                    style="padding: 7px 17px; font-size: 1rem;">Save</button>
                                <button type="button" onclick="confirmNextStep()"
                                    style="padding: 7px 17px; font-size: 1rem; margin-left: 10px;">Next</button>
                            </div>
                        </div>
                    </form>
                    <!-- End of Form Section -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let isSaved = false;

        function saveApplication() {
            const form = document.getElementById('applicationForm');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => {
                    return response.text().then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (err) {
                            console.error('Response is not valid JSON:', text);
                            throw err;
                        }
                    });
                })
                .then(data => {
                    console.log(data);  // 응답 데이터를 콘솔에 출력
                    if (data.success) {
                        isSaved = true;
                        alert('Application saved successfully!');
                    } else {
                        alert('Failed to save application.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to save application.');
                });
        }

        function confirmNextStep() {
            if (!isSaved) {
                if (confirm('The application has not been saved. Do you want to proceed without saving?')) {
                    window.location.href = '{{ route('application.step2') }}';
                }
            } else {
                window.location.href = '{{ route('application.step2') }}';
            }
        }
    </script>
</x-app-layout>