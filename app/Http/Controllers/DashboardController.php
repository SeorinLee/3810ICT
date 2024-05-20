<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function show()
    {
        $user = Auth::user();
        $message = '';

        switch ($user->user_type) {
            case 'volunteer':
                return redirect()->route('volunteer.home');
            case 'expert':
                return redirect()->route('expert.home');
            case 'manager':
                return redirect()->route('manager.home');
            default:
                $message = 'Welcome';
        }

        return view('dashboard', ['message' => $message]);
    }
}
