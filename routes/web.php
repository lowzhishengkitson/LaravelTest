<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\OtpController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\InvoiceDownloaderController;

Route::get('/secure-invoice/{id}', [InvoiceDownloaderController::class, 'download'])
    ->name('secure.invoice')
    ->middleware('signed'); // Enforce signature validation


Route::get('/tasks/{task}', function (Task $task) {
    return view('tasks.show', ['task' => $task]);
});
Route::get('/dashboard', function (Task $task) {
    return view('1');
});

Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

Route::get('/', [OtpController::class, 'showRequestForm'])->name('otp.request.form');
Route::post('/otp/request', [OtpController::class, 'sendOtp'])->name('otp.request');
Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::post('/otp/verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');
