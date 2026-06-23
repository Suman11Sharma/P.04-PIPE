<?php

namespace App\Http\Controllers;

use App\Services\TwoFactorService;
use Illuminate\Http\Request;

class TwoFactorChallengeController extends Controller
{
    /**
     * Verify the OTP submitted by the user.
     */
    public function verify(Request $request, TwoFactorService $twoFactor)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/'],
        ]);

        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($twoFactor->verify($user, $request->otp)) {
            $twoFactor->markSessionVerified();

            // Check if the user needs onboarding (MP with no constituency)
            if ($user->role_enum->value === 'mp' && is_null($user->constituency_id)) {
                return redirect()->route('onboarding');
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'otp' => 'The provided authentication code is invalid or has expired.',
        ]);
    }

    /**
     * Resend a new OTP to the user.
     */
    public function resend(Request $request, TwoFactorService $twoFactor)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $twoFactor->generate($user);

        return back()->with('status', 'A new verification code has been dispatched.');
    }
}
