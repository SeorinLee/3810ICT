<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_code' => ['required', 'string', 'max:255', 'unique:' . User::class, 'regex:/^[emv][0-9]{6}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $userType = $this->determineUserType($request->user_code);

        $user = User::create([
            'name' => $request->name,
            'user_code' => $request->user_code,
            'user_type' => $userType,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Determine the user type based on the user code prefix.
     */
    protected function determineUserType(string $userCode): string
    {
        $prefix = strtolower($userCode[0]);
        return match ($prefix) {
            'v' => 'volunteer',
            'e' => 'expert',
            'm' => 'manager',
            default => 'volunteer', // 기본값은 volunteer로 설정합니다.
        };
    }
}
