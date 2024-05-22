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
                // 'name' => 'Default Name',
                // 'contact' => 'default contact',
                // 'experience' => 'default@example.com',
                // 'reason' => 'Default reason',
                'quiz_passed' => false,
                'quiz_answers' => json_encode([])
            ]
        );


        $questions = [
            ['question' => '2 + 2 = ?', 'choices' => [3, 4, 5, 6], 'answer' => 4],
            ['question' => '5 - 3 = ?', 'choices' => [1, 2, 3, 4], 'answer' => 2],
            ['question' => '3 * 3 = ?', 'choices' => [6, 7, 8, 9], 'answer' => 9],
            ['question' => '10 / 2 = ?', 'choices' => [2, 3, 4, 5], 'answer' => 5],
            ['question' => '7 + 2 = ?', 'choices' => [8, 9, 10, 11], 'answer' => 9]
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
        $validatedData = $request->validate([
            'interview_script' => 'required|string',
            'interview_comments' => 'nullable|string',
        ]);

        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->firstOrFail();

        $application->interview_script = $validatedData['interview_script'];
        $application->interview_comments = $validatedData['interview_comments'];
        $application->save();

        return response()->json(['success' => true]);
    }

    // public function step6()
    // {
    //     $user = Auth::user();
    //     $application = Application::where('user_id', $user->id)->first();
    //     $comments = Comment::where('application_id', $application->id)->with('user')->get();

    //     return view('application.step6-uniqueJobPlan', compact('application', 'comments'));
    // }

    // public function storeComment(Request $request)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'comment' => 'required|string|max:1000',
    //         ]);

    //         $user = Auth::user();
    //         $application = Application::where('user_id', $user->id)->firstOrFail();

    //         $comment = new Comment();
    //         $comment->application_id = $application->id;
    //         $comment->user_id = $user->id; // 추가
    //         $comment->comment = $validatedData['comment'];
    //         $comment->save();

    //         $comment = $comment->load('user'); // 추가

    //         return response()->json(['success' => true, 'comment' => $comment]);
    //     } catch (\Exception $e) {
    //         Log::error('Error storing comment: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Failed to add comment.'], 500);
    //     }
    // }

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
