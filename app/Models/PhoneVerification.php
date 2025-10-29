<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PhoneVerification extends Model
{
    protected $fillable = [
        'phone',
        'code',
        'expires_at',
        'verified',
        'verified_at',
        'ip_address',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'verified' => 'boolean',
    ];

    public static function generateCode(string $phone): self
    {
        // Generate 4-digit code
        $code = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
        
        // Delete old unverified codes for this phone
        self::where('phone', $phone)
            ->where('verified', false)
            ->where('expires_at', '<', now())
            ->delete();

        return self::create([
            'phone' => $phone,
            'code' => $code,
            'expires_at' => now()->addMinutes(5), // Valid for 5 minutes
            'ip_address' => request()->ip(),
        ]);
    }

    public static function verify(string $phone, string $code): bool
    {
        $verification = self::where('phone', $phone)
            ->where('code', $code)
            ->where('verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if ($verification) {
            $verification->update([
                'verified' => true,
                'verified_at' => now(),
            ]);
            
            return true;
        }

        return false;
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->verified && !$this->isExpired();
    }
}
