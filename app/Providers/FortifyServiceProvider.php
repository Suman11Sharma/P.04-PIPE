<?php

namespace App\Providers;

use App\Services\TwoFactorService;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TwoFactorService::class);

        // Custom LoginResponse: after successful password authentication,
        // check if the user requires 2FA. If so, generate an OTP, dispatch it
        // (mock), and redirect to the challenge page instead of the dashboard.
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request): \Symfony\Component\HttpFoundation\Response
                {
                    $user = $request->user();

                    /** @var TwoFactorService $twoFactor */
                    $twoFactor = app(TwoFactorService::class);

                    if ($twoFactor->userRequiresTwoFactor($user) && ! $twoFactor->sessionIsVerified()) {
                        $twoFactor->generate($user);
                        return redirect()->route('two-factor.challenge');
                    }

                    return redirect()->intended(route('dashboard'));
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ── Register custom auth views ──────────────────────────────────
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

        // ── Custom authentication callback ──────────────────────────────
        // This simply validates the credentials and returns the user.
        // Post-login redirect logic is handled by the LoginResponse binding above.
        Fortify::authenticateUsing(function ($request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            if (! $user || ! password_verify($request->password, $user->password)) {
                return null;
            }

            return $user;
        });
    }
}
