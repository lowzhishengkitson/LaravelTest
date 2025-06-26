<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Tzsk\Otp\Facades\Otp;
use App\Models\User;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use Illuminate\Http\Request;
use App\Notifications\OtpNotification;


class OtpController extends Controller
{
    public function showRequestForm()
    {
        return view('otp.request');
    }

    public function showVerifyForm()
    {
        $mobile = session('otp_mobile');

        if (!$mobile) {
            return redirect()->route('otp.request.form')->withErrors('Please request an OTP first.');
        }

        return view('otp.verify', compact('mobile'));
    }

    // Send OTP to mobile via WhatsApp
    public function sendOtp(SendOtpRequest $request)
    {
        $mobile = $request->mobile;
        $otp = Otp::generate($mobile);
        $user = User::where('mobile', $mobile)->first();
        if (!$user)
            return response()->json([
                'success' => false,
                'message' => 'User not found for this mobile number.',
                'data' => []
            ], 404);
        $user->notify(new OtpNotification($otp));
        session(['otp_mobile' => $mobile]);
        return response()->json([
                'success' => true,
                'message' => 'OTP sent to mobile.' . $mobile,
                'data' => []
            ], 200);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $mobile = $request->mobile;

        $user = User::where('mobile', $mobile)->first();
        if (!$user)
            return response()->json([
                'success' => false,
                'message' => 'User not found for this mobile number.',
                'data' => []
            ], 404);

        $token = $user->createToken('mobile-otp-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if ($token)
            $token->delete();

        return response()->json([
            'success' => true,
            'message' => 'User logged out.',
            'data' => [
            ]
        ], 200);
    }
}
