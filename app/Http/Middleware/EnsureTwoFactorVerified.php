<?php

namespace App\Http\Middleware;

use App\Services\TwoFactorService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorVerified
{
    /**
     * Handle an incoming request.
     *
     * If the authenticated user requires 2FA (MP/Committee Chair) and
     * the session has not yet been verified, redirect to the challenge page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        /** @var TwoFactorService $service */
        $service = app(TwoFactorService::class);

        if ($service->userRequiresTwoFactor($user) && ! $service->sessionIsVerified()) {
            return redirect()->route('two-factor.challenge');
        }

        return $next($request);
    }
}
