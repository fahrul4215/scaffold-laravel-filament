<?php

namespace App\Listeners;

use App\Models\LoginAttempt;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogLoginAttempt
{
    /**
     * Track recent attempts to prevent duplicates
     */
    private static array $recentAttempts = [];

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle login success event.
     */
    public function handleLogin(Login $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;

        $this->logAttempt(
            user: $user,
            status: 'success',
            email: $user->email
        );
    }

    /**
     * Handle logout event.
     */
    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            /** @var \App\Models\User $user */
            $user = $event->user;

            $this->logAttempt(
                user: $user,
                status: 'logout',
                email: $user->email
            );
        }
    }

    /**
     * Handle failed login event.
     */
    public function handleFailed(Failed $event): void
    {
        $this->logAttempt(
            user: $event->user,
            status: 'failed',
            email: $event->credentials['email'] ?? null,
            failureReason: 'Invalid credentials'
        );
    }

    /**
     * Log the authentication attempt.
     */
    protected function logAttempt($user = null, string $status = 'success', ?string $email = null, ?string $failureReason = null): void
    {
        $request = request();

        // Create a unique key for this attempt to prevent duplicates
        $attemptKey = md5(
            ($user?->id ?? 'null') .
            $status .
            $email .
            $request->ip() .
            floor(now()->timestamp / 5) // 5-second window
        );

        // Skip if this exact attempt was logged within the last 5 seconds
        if (isset(self::$recentAttempts[$attemptKey])) {
            return;
        }

        // Mark this attempt as logged
        self::$recentAttempts[$attemptKey] = true;

        // Clean up old attempts (keep only last 100)
        if (count(self::$recentAttempts) > 100) {
            self::$recentAttempts = array_slice(self::$recentAttempts, -50, null, true);
        }

        LoginAttempt::create([
            'user_id' => $user?->id,
            'email' => $email,
            'status' => $status,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'location' => $this->getLocationFromIp($request->ip()),
            'failure_reason' => $failureReason,
            'attempted_at' => now(),
        ]);
    }

    /**
     * Get location from IP address (simplified version).
     * In production, you might want to use a service like MaxMind GeoIP.
     */
    protected function getLocationFromIp(?string $ip): ?string
    {
        // For local IPs, return null
        if (!$ip || $ip === '127.0.0.1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return 'Local';
        }

        // You can integrate with a GeoIP service here
        // For now, return null for external IPs
        return null;
    }
}
