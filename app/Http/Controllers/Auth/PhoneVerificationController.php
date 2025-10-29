<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PhoneVerification;
use App\Services\SmsService;
use Illuminate\Http\Request;

class PhoneVerificationController extends Controller
{
    public function __construct(protected SmsService $smsService)
    {
    }

    public function show()
    {
        if (auth()->user()->phone_verified_at) {
            return redirect()->route('home');
        }

        return view('auth.verify-phone');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $user = auth()->user();
        
        // Check rate limiting (max 3 attempts per 10 minutes)
        $recentAttempts = PhoneVerification::where('phone', $request->phone)
            ->where('created_at', '>', now()->subMinutes(10))
            ->count();

        if ($recentAttempts >= 3) {
            return back()->with('error', 'لقد تجاوزت الحد الأقصى من المحاولات. الرجاء الانتظار 10 دقائق.');
        }

        // Generate and save OTP
        $verification = PhoneVerification::generateCode($request->phone);

        // Send SMS
        $sent = $this->smsService->sendOTP($request->phone, $verification->code);

        if ($sent) {
            // Update user phone if different
            if ($user->phone !== $request->phone) {
                $user->update(['phone' => $request->phone]);
            }

            return back()->with('success', 'تم إرسال كود التحقق إلى ' . $request->phone);
        }

        return back()->with('error', 'فشل في إرسال الرسالة. الرجاء المحاولة لاحقاً.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string|size:4',
        ]);

        $verified = PhoneVerification::verify($request->phone, $request->code);

        if ($verified) {
            auth()->user()->update([
                'phone' => $request->phone,
                'phone_verified_at' => now(),
            ]);

            return redirect()->route('home')->with('success', 'تم التحقق من رقم جوالك بنجاح!');
        }

        return back()->with('error', 'كود التحقق غير صحيح أو منتهي الصلاحية.');
    }

    public function resend(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        // Check if can resend (60 seconds cooldown)
        $lastCode = PhoneVerification::where('phone', $request->phone)
            ->where('created_at', '>', now()->subSeconds(60))
            ->first();

        if ($lastCode) {
            $remainingSeconds = 60 - now()->diffInSeconds($lastCode->created_at);
            return back()->with('error', "يمكنك إعادة الإرسال بعد {$remainingSeconds} ثانية");
        }

        return $this->sendCode($request);
    }
}

