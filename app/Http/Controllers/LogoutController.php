<?php

namespace App\Http\Controllers;

use App\Services\TwoFactorService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Log the user out and clear the 2FA session verification.
     */
    public function __invoke(Request $request, TwoFactorService $twoFactor)
    {
        $twoFactor->clearSessionVerification();

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
