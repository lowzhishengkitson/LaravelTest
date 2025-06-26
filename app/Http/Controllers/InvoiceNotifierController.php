<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\InvoiceNotification;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class InvoiceNotifierController extends Controller
{
    public function send(Request $request)
    {
        $mobile = "+6583684728";

        // Fetch user by mobile
        $user = User::where('mobile', $mobile)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found for mobile ' . $mobile,
                'data' => []
            ], 404);
        }

        // Generate a temporary signed URL (valid 10 minutes)
        $invoiceId = 'deploy-guide'; // filename without extension

        $signedUrl = URL::temporarySignedRoute(
            'secure.invoice',
            now()->addMinutes(10),
            ['id' => $invoiceId]
        );
        logger('Signed invoice URL: ' . $signedUrl);

        // Send notification with signed URL
        $user->notify(new InvoiceNotification("https://6ac6-101-127-30-49.ngrok-free.app/storage/invoices/deploy-guide.pdf"));

        return response()->json([
            'success' => true,
            'message' => 'Invoice sent to mobile: ' . $mobile,
            'data' => ['signed_url' => $signedUrl]
        ], 200);
    }
}
