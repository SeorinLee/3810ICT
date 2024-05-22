<?php

// app/Http/Controllers/ApplicationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{


    public function step0()
    {
        return view('application.step0-start');
    }

    public function step1()
    {
        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->first();

        Log::info('Step1 - Loaded application', ['application' => $application]);

        return view('application.step1-VolunteerDetails', compact('application'));
    }

    public function storeStep1(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'club_name' => 'nullable|string|max:255',
                'position_title' => 'nullable|string|max:255',
                'gender' => 'nullable|string|max:10',
                'dob' => 'nullable|date',
                'volunteering_experience' => 'nullable|string',
                'reason' => 'nullable|string',
            ]);

            $user = Auth::user();

            $application = Application::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $validatedData['club_name'],
                    'position_title' => $validatedData['position_title'],
                    'gender' => $validatedData['gender'],
                    'dob' => $validatedData['dob'],
                    'experience' => $validatedData['volunteering_experience'],
                    'reason' => $validatedData['reason'],
                ]
            );

            Log::info('Step1 - Stored application', ['application' => $application]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error storing step1 data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save details.'], 500);
        }
    }
    public function step2()
    {
        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->first();

        return view('application.step2-video_doc', compact('application'));
    }

    public function storeStep2(Request $request)
    {
        $validatedData = $request->validate([
            'video_link' => 'required|string|max:255',
            'document_link' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->firstOrFail();

        $application->update($validatedData);

        return response()->json(['success' => true]);
    }



    public function step3()
    {
        $user = Auth::user();
        $application = Application::firstOrCreate(
            ['user_id' => $user->id],
            [
                'quiz_passed' => false,
                'quiz_answers' => json_encode([])
            ]
        );

        $questions = [
            [
                'question' => 'What below statement does explain job crafting?',
                'choices' => [
                    'a) Job crafting is only for volunteers who do not care about their job.',
                    'b) Job crafting is a bottom-up approach that involves volunteer voice in volunteering job.',
                    'c) Job crafting is a top-down approach that involves managers to design volunteers’ work.'
                ],
                'answer' => 'b) Job crafting is a bottom-up approach that involves volunteer voice in volunteering job.'
            ],
            [
                'question' => 'Why job crafting is important for volunteers?',
                'choices' => [
                    'a) It leads to volunteer engagement, well-being, and performance.',
                    'b) It leads to escape from volunteering job.',
                    'c) It leads to escape from the club.'
                ],
                'answer' => 'a) It leads to volunteer engagement, well-being, and performance.'
            ],
            [
                'question' => 'Approach job crafting is about ….?',
                'choices' => [
                    'a) … removing tasks from volunteering job.',
                    'b) … adding extra tasks to the volunteering job.',
                    'c) … leaving volunteering job because of work overload.'
                ],
                'answer' => 'b) … adding extra tasks to the volunteering job.'
            ],
            [
                'question' => 'Avoidance job crafting is about ….?',
                'choices' => [
                    'a) … removing tasks from volunteering job.',
                    'b) … adding extra tasks to the volunteering job.',
                    'c) … leaving volunteering job because of work overload.'
                ],
                'answer' => 'a) … removing tasks from volunteering job.'
            ],
            [
                'question' => 'What does “job co-crafting” mean?',
                'choices' => [
                    'a) Each volunteer collaborates with club manager to co-create customised work plan.',
                    'b) Only managers develop the customised work plan.',
                    'c) Only volunteers develop the customised work plan.'
                ],
                'answer' => 'a) Each volunteer collaborates with club manager to co-create customised work plan.'
            ]
        ];

        return view('application.step3-quiz', compact('application', 'questions'));
    }

    public function storeStep3(Request $request)
    {
        $correctAnswers = 0;
        $questions = $request->input('questions');
        $answers = $request->input('answers');

        foreach ($questions as $index => $question) {
            if ($question['answer'] == $answers[$index]) {
                $correctAnswers++;
            }
        }

        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->firstOrFail();

        $quizPassed = $correctAnswers >= 3;
        $application->quiz_passed = $quizPassed;
        $application->quiz_answers = json_encode($answers);
        $application->save();

        if ($quizPassed) {
            return response()->json(['success' => true, 'quiz_passed' => true, 'correct_answers' => $correctAnswers]);
        } else {
            return response()->json(['success' => false, 'quiz_passed' => false, 'message' => 'You must answer at least 3 questions correctly to proceed.']);
        }
    }


    public function step4()
    {
        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->first();

        return view('application.step4-workshop', compact('application'));
    }

    public function storeStep4(Request $request)
    {
        $validatedData = $request->validate([
            'workshop_info' => 'required|string|max:1000',
            'workshop_result' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->firstOrFail();

        $application->update($validatedData);

        return response()->json(['success' => true]);
    }



    public function step5()
    {
        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->first();
        $comments = Comment::where('application_id', $application->id)->with('user')->get();

        return view('application.step5-interview', compact('application', 'comments'));
    }

    public function storeStep5(Request $request)
    {
        try {

            $user = Auth::user();
            $application = Application::where('user_id', $user->id)->firstOrFail();

            if ($request->has('interview_script')) {
                $application->interview_script = $request->input('interview_script');
            }

            if ($request->has('interview_comments')) {
                $comment = new Comment();
                $comment->application_id = $application->id;
                $comment->user_id = $user->id;

                $comment->comment = $request->input('interview_comments');
                $comment->save();
                return response()->json(['success' => true, 'comment' => $comment->load('user')]);
            }

            $application->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error storing interview details: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save interview details.'], 500);
        }
    }

    public function step6()
    {
        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->first();
        $comments = Comment::where('application_id', $application->id)->with('user')->get();

        return view('application.step6-uniqueJobPlan', compact('application', 'comments'));
    }

    public function storeComment(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'comment' => 'required|string|max:1000',
            ]);

            $user = Auth::user();
            $application = Application::where('user_id', $user->id)->firstOrFail();

            $comment = new Comment();
            $comment->application_id = $application->id;
            $comment->user_id = $user->id;
            $comment->comment = $validatedData['comment'];
            $comment->save();

            $comment = $comment->load('user');

            return response()->json(['success' => true, 'comment' => $comment]);
        } catch (\Exception $e) {
            Log::error('Error storing comment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to add comment.'], 500);
        }
    }


    public function step7()
    {
        return view('application.step7-finish');
    }

    public function storeStep7(Request $request)
    {

        return response()->json(['success' => true]);
    }
}
