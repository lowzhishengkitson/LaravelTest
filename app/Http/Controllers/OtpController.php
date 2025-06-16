<?php

namespace App\Http\Controllers;

use Tzsk\Otp\Facades\Otp;
use App\Services\WhatsappService;
use App\Models\User;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;

class OtpController extends Controller
{
    // Show mobile input form
    public function showRequestForm()
    {
        return view('otp.request');
    }

    // Send OTP to mobile via WhatsApp
    public function sendOtp(SendOtpRequest $request, WhatsappService $sms)
    {
        $mobile = $request->mobile;
        $otp = Otp::generate($mobile);
        $sms->sendViaWhatsApp($mobile, "Your WhatsApp OTP is: $otp");
        session(['otp_mobile' => $mobile]);
        return redirect()->route('otp.verify.form')->with('success', 'OTP sent via WhatsApp!');
    }

    // Show OTP input form
    public function showVerifyForm()
    {
        $mobile = session('otp_mobile');
        return view('otp.verify', compact('mobile'));
    }

    // Verify entered OTP
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $mobile = $request->mobile;

        // Passed validation means OTP is correct
        $user = User::where('mobile', $mobile)->first();

        // Login and issue token, etc.
        $token = $user->createToken('mobile-otp-token')->plainTextToken;

        return response()->json([
            'message' => 'OTP verified successfully.',
            'token' => $token,
            'user' => $user
        ]);
    }
}
