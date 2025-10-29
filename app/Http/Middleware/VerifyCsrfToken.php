<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/webhooks/*',
        'payment/callback',
        'payment/webhook',
    ];
    
    /**
     * Handle exceptions for expired tokens
     */
    protected function handleTokenMismatch($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Page expired. Please refresh and try again.'], 419);
        }
        
        return redirect()->back()
            ->withInput($request->except('password', '_token'))
            ->with('error', 'انتهت صلاحية الصفحة. يرجى تحديث الصفحة والمحاولة مرة أخرى.');
    }
}

