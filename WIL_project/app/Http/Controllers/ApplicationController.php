<?php

// app/Http/Controllers/ApplicationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

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

        return view('application.step1-VolunteerDetails', compact('application'));
    }

    public function storeStep1(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'reason' => 'required|string',
        ]);

        $user = Auth::user();

        $application = Application::updateOrCreate(
            ['user_id' => $user->id],
            $validatedData
        );

        return response()->json(['success' => true]);
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
        return view('application.step3-quiz');
    }

    public function storeStep3(Request $request)
    {
        $validatedData = $request->validate([
            'quiz_result' => 'required|string',
        ]);

        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->firstOrFail();

        $application->update($validatedData);

        return response()->json(['success' => true]);
    }

    public function step4()
    {
        return view('application.step4-workshop');
    }

    public function storeStep4(Request $request)
    {
        $validatedData = $request->validate([
            'workshop_info' => 'required|string',
            'workshop_result' => 'required|string',
        ]);

        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->firstOrFail();

        $application->update($validatedData);

        return response()->json(['success' => true]);
    }

    public function step5()
    {
        return view('application.step5-interview');
    }

    public function storeStep5(Request $request)
    {
        $validatedData = $request->validate([
            'interview_notes' => 'required|string',
            'interview_result' => 'required|string',
        ]);

        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->firstOrFail();

        $application->update($validatedData);

        return response()->json(['success' => true]);
    }

    public function step6()
    {
        return view('application.step6-uniqueJobPlan');
    }

    public function storeStep6(Request $request)
    {
        $validatedData = $request->validate([
            'unique_job_plan' => 'required|string',
            'unique_job_plan_comments' => 'required|string',
        ]);

        $user = Auth::user();
        $application = Application::where('user_id', $user->id)->firstOrFail();

        $application->update($validatedData);

        return response()->json(['success' => true]);
    }

    public function step7()
    {
        return view('application.step7-finish');
    }

    public function storeStep7(Request $request)
    {
        // 마지막 단계의 데이터를 저장하는 로직을 여기에 추가합니다.
        return response()->json(['success' => true]);
    }
}
