<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * TwoFactorService handles the generation, storage, and verification
 * of one-time passcodes (OTP) for MP and Committee Chair roles.
 *
 * OTPs are stored in the session cache with a 5-minute TTL and
 * simulated delivery via a mock notification channel.
 */
class TwoFactorService
{
    /**
     * The cache key prefix for storing OTPs.
     */
    protected string $cachePrefix = 'pipe_2fa_otp_';

    /**
     * The TTL for OTP codes in minutes.
     */
    protected int $otpTtlMinutes = 5;

    /**
     * Generate a 6-digit OTP for the given user, store it in the
     * session cache, and simulate dispatching it.
     *
     * @return string The generated OTP code.
     */
    public function generate(User $user): string
    {
        // Generate a cryptographically secure 6-digit random string
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in cache with 5-minute expiry
        Cache::put(
            $this->cacheKey($user),
            $otp,
            now()->addMinutes($this->otpTtlMinutes)
        );

        // Mock dispatch — log to the application log for development
        $this->mockDispatch($user, $otp);

        // Flash OTP to session for development auto-fill
        session()->flash('pipe_2fa_otp', $otp);

        return $otp;
    }

    /**
     * Verify the provided OTP against the stored value for the user.
     *
     * @return bool True if the OTP is valid (also clears it from cache).
     */
    public function verify(User $user, string $otp): bool
    {
        $cacheKey = $this->cacheKey($user);
        $stored = Cache::get($cacheKey);

        if ($stored === null) {
            return false;
        }

        // Use hash_equals to prevent timing attacks
        $isValid = hash_equals($stored, $otp);

        if ($isValid) {
            Cache::forget($cacheKey);
        }

        return $isValid;
    }

    /**
     * Determine if the user's role requires 2FA on login.
     */
    public function userRequiresTwoFactor(User $user): bool
    {
        return in_array($user->role_enum->value, [
            'mp',
            'committee_chair',
        ], true);
    }

    /**
     * Check whether the current session has passed 2FA verification.
     */
    public function sessionIsVerified(): bool
    {
        return session()->has('pipe_2fa_verified_at');
    }

    /**
     * Mark the current session as 2FA-verified.
     */
    public function markSessionVerified(): void
    {
        session()->put('pipe_2fa_verified_at', now()->timestamp);
    }

    /**
     * Clear the 2FA verification flag from the session.
     */
    public function clearSessionVerification(): void
    {
        session()->forget('pipe_2fa_verified_at');
    }

    /**
     * Get the remaining seconds before the OTP expires.
     */
    public function getRemainingSeconds(User $user): int
    {
        $cacheKey = $this->cacheKey($user);
        $remaining = Cache::ttl($cacheKey);

        return max(0, $remaining);
    }

    /**
     * Simulate dispatching the OTP to the user's registered mobile device.
     * In production, replace with an actual SMS/email provider.
     */
    protected function mockDispatch(User $user, string $otp): void
    {
        logger(sprintf(
            '[PIPE 2FA] OTP for user [%s] (%s): %s | Expires in %d minutes',
            $user->id,
            $user->email,
            $otp,
            $this->otpTtlMinutes
        ));

        session()->flash('pipe_2fa_dispatched', true);
    }

    /**
     * Build the unique cache key for a user's OTP.
     */
    protected function cacheKey(User $user): string
    {
        return $this->cachePrefix . $user->id;
    }
}
