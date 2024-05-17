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
        $volunteers = [];

        switch ($user->user_type) {
            case 'volunteer':
                $message = 'Welcome';
                break;
            case 'expert':
                $message = 'Hello';
                $volunteers = User::where('user_type', 'volunteer')->get();
                break;
            case 'manager':
                $message = 'Hello Manager';
                break;
            default:
                $message = 'Welcome';
        }

        return view('dashboard', ['message' => $message, 'volunteers' => $volunteers]);
    }
}
