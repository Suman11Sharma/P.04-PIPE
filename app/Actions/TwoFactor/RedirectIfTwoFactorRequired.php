<?php

namespace App\Actions\TwoFactor;

use App\Models\User;

class RedirectIfTwoFactorRequired
{
    /**
     * Determine the redirect path after login based on 2FA requirements.
     */
    public function __invoke(User $user): ?string
    {
        // This is handled directly in FortifyServiceProvider via
        // the authenticateUsing callback. This action is kept for
        // future extensibility and testability.
        return null;
    }
}
