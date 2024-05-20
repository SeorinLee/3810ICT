<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
            <p>volunteer page</p>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <P>Welcome to step0?</P>


                    <!-- Content -->
                    <div class="container" style="text-align: center;">
                        <!-- Start Page Section -->
                        <h2 style="font-size: 1rem; font-weight: bold; color: black; margin: 0; text-align: center;">
                            <nav class="navbar navbar-expand-lg navbar-light"
                                style="background-color: #F3F4F6; padding: 5px;">
                                <span
                                    style="color: black; background-color: white; padding: 5px; width: 600px; height: 20px; display: inline-block;">Start
                                    Page</span>
                            </nav>
                        </h2>

                        <!-- Progress Bar Section -->
                        <div class="progress-bar-container"
                            style="display: flex; justify-content: space-between; width: 70%; margin: 50px auto; position: relative;">
                            <?php
// Define the current step
$currentStep = "Start";

// Define all steps
$steps = [
    "Start",
    "Volunteer Details",
    "Video & Doc",
    "Quiz",
    "Workshop",
    "Interview",
    "Unique Job Plan",
    "Finish"
];

// Go through all the steps and generate the corresponding HTML
foreach ($steps as $index => $step) {
    $isCompleted = ($step == $currentStep) ? 'color: black;' : 'color: #888;';
    $circleColor = ($step == $currentStep) ? 'background-color: dodgerblue;' : '';

    // Set the target link for each step
    switch ($step) {
        case "Volunteer Details":
            $linkTarget = "step1-VolunteerDetails.blade.php";
            break;
        case "Video & Doc":
            $linkTarget = "step2-video&doc.blade.php";
            break;
        case "Quiz":
            $linkTarget = "step3-Quiz.blade.php";
            break;
        case "Workshop":
            $linkTarget = "step4-Workshop.blade.php";
            break;
        case "Interview":
            $linkTarget = "step5-Interview.blade.php";
            break;
        case "Unique Job Plan":
            $linkTarget = "step6-UniqueJobPlan.blade.php";
            break;
        case "Finish":
            $linkTarget = "step7-Finish.blade.php";
            break;
        default:
            $linkTarget = "#";
            break;
    }

    // Add hyperlinks and step circles
            ?>
                            <div class="progress-step"
                                style="position: relative; padding: 10px; <?php    echo $isCompleted; ?> font-size: 14px; text-align: center; flex: 1; cursor: pointer; margin-top: 20px;">
                                <a href="<?php    echo $linkTarget; ?>" style="text-decoration: none; color: inherit;">
                                    <div
                                        style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); width: 20px; height: 20px; border: 2px solid #ccc; border-radius: 50%; <?php    echo $circleColor; ?>;">
                                    </div>
                                    <?php    echo $step; ?>
                                </a>
                                <?php
    //Add lines between steps
    if ($index > 0) {
        // Set the color of the left line
        $lineColor = ($step == $currentStep) ? 'background-color: dodgerblue;' : 'background-color: black;';
                  ?>
                                <div
                                    style="position: absolute; top: -10px; left: 0%; width: 80%; transform: translateX(-50%); height: 2px; <?php        echo $lineColor; ?>;">
                                </div>
                                <?php
    }
                ?>
                            </div>
                            <?php
}
        ?>
                        </div>

                        <!-- Start Button Section -->
                        <div class="row justify-content-center" style="margin-top: 200px;">
                            <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                                <button onclick="startFunction()" style="padding: 10px 20px; font-size: 1.5rem;">Start
                                    Button</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>