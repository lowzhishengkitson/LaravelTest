<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class InvoiceDownloaderController extends Controller
{
    public function download(Request $request, $id)
    {
        logger("InvoiceDownloadController@download called with id: $id, from IP: " . $request->ip());

        // Optional: limit to Twilio IP range
        // if (!$this->isTwilio($request->ip())) {
        //     logger("Access denied: IP {$request->ip()} is not in Twilio range.");
        //     abort(403, 'Access denied');
        // }

        // Optional: Prevent reuse
        $key = "invoice_downloaded_$id";
        // if (Cache::has($key)) {
        //     logger("Link expired or already used for key: $key");
        //     abort(410, 'Link expired or already used');
        // }
        Cache::put($key, true, now()->addMinutes(10)); // Mark as used
        logger("Marked link as used with key: $key");

        $path = "invoices/$id.pdf";

        if (!Storage::disk('public')->exists($path)) {
            logger("Invoice not found at path: $path");
            abort(404, 'Invoice not found');
        }
        logger("Invoice found at path: $path. Preparing to serve file.");

        return response()->file(storage_path("app/public/$path"), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
    }

    private function isTwilio($ip)
    {
        // Optionally implement: https://www.twilio.com/docs/usage/security#validating-requests
        return true; // or use IP range check
    }
}
