<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span
                style="color: black; background-color: white; padding: 5px; width: 600px; height: 20px; display: inline-block;">Start
                Page</span>

        </h2>
    </x-slot>

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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Volunteer Details') }}
                    </h2>

                    <form id="volunteer-details-form" method="POST" action="{{ route('volunteer.details.save') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="contact_number" :value="__('Contact Number')" />
                            <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <!-- <x-primary-button>{{ __('Save') }}</x-primary-button> -->
                            <x-primary-button>{{ __('Next') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout> 