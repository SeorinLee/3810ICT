<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function step0()
    {
        return view('application.step0-start');
    }

    public function step1()
    {
        return view('application.step1-VolunteerDetails');
    }

    public function step2()
    {
        return view('application.step2-video_doc');
    }

    public function step3()
    {
        return view('application.step3-quiz');
    }

    public function step4()
    {
        return view('application.step4-workshop');
    }

    public function step5()
    {
        return view('application.step5-interview');
    }

    public function step6()
    {
        return view('application.step6-uniqueJobPlan');
    }

    public function step7()
    {
        return view('application.step7-finish');
    }
}
