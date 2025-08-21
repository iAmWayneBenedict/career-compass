<?php

use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\ForgotPasswordNotification;
use App\Notifications\OTPVerificationNotification;
use App\Notifications\DynamicNotification;
use App\Http\Controllers\EmailTestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Email Testing Routes
|--------------------------------------------------------------------------
|
| These routes are for testing email templates during development.
| Remove or secure these routes in production.
|
*/

// Test Welcome Email
Route::get('/test-email/welcome/{userId}', function ($userId) {
    $user = User::findOrFail($userId);
    $dashboardUrl = url('/dashboard');
    
    $user->notify(new WelcomeNotification($dashboardUrl));
    
    return response()->json([
        'message' => 'Welcome email sent successfully',
        'user' => $user->name,
        'email' => $user->email
    ]);
});

// Test Email Verification
Route::get('/test-email/verify/{userId}', function ($userId) {
    $user = User::findOrFail($userId);
    
    $user->sendEmailVerificationNotification();
    
    return response()->json([
        'message' => 'Email verification sent successfully',
        'user' => $user->name,
        'email' => $user->email
    ]);
});

// Test Forgot Password Email
Route::get('/test-email/forgot-password/{userId}', function ($userId) {
    $user = User::findOrFail($userId);
    $token = 'test-reset-token-' . time();
    
    $user->sendPasswordResetNotification($token);
    
    return response()->json([
        'message' => 'Password reset email sent successfully',
        'user' => $user->name,
        'email' => $user->email,
        'token' => $token
    ]);
});

// Test OTP Verification Email
Route::get('/test-email/otp/{userId}', function ($userId) {
    $user = User::findOrFail($userId);
    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    
    $user->notify(new OTPVerificationNotification(
        $otp,
        10, // 10 minutes expiry
        'Login Verification',
        'Two-Factor Authentication',
        url('/verify-otp'),
        request()->ip()
    ));
    
    return response()->json([
        'message' => 'OTP verification email sent successfully',
        'user' => $user->name,
        'email' => $user->email,
        'otp' => $otp
    ]);
});

// Test Dynamic Success Notification
Route::get('/test-email/success/{userId}', function ($userId) {
    $user = User::findOrFail($userId);
    
    $notification = DynamicNotification::success(
        'Profile Updated Successfully',
        'Your profile information has been updated successfully. All changes are now active.',
        [
            'description' => 'We\'ve updated your profile with the latest information you provided.',
            'action_text' => 'View Profile',
            'action_url' => url('/profile'),
            'additional_info' => 'If you didn\'t make these changes, please contact our support team immediately.',
            'data' => [
                'Updated Fields' => ['Name', 'Email', 'Phone'],
                'Update Time' => now()->format('M j, Y g:i A'),
                'IP Address' => request()->ip()
            ]
        ]
    );
    
    $user->notify($notification);
    
    return response()->json([
        'message' => 'Success notification sent successfully',
        'user' => $user->name,
        'email' => $user->email
    ]);
});

// Test Dynamic Warning Notification
Route::get('/test-email/warning/{userId}', function ($userId) {
    $user = User::findOrFail($userId);
    
    $notification = DynamicNotification::warning(
        'Security Alert: New Login Detected',
        'We detected a new login to your Career Compass account from an unrecognized device.',
        [
            'description' => 'If this was you, you can safely ignore this message. If not, please secure your account immediately.',
            'action_text' => 'Secure Account',
            'action_url' => url('/security'),
            'urgent' => true,
            'data' => [
                'Device' => 'Chrome on Windows',
                'Location' => 'San Francisco, CA',
                'IP Address' => request()->ip(),
                'Time' => now()->format('M j, Y g:i A')
            ]
        ]
    );
    
    $user->notify($notification);
    
    return response()->json([
        'message' => 'Warning notification sent successfully',
        'user' => $user->name,
        'email' => $user->email
    ]);
});

// Test Dynamic Info Notification
Route::get('/test-email/info/{userId}', function ($userId) {
    $user = User::findOrFail($userId);
    
    $notification = DynamicNotification::info(
        'New Features Available',
        'We\'ve added exciting new features to help you advance your career even faster.',
        [
            'description' => 'Check out our latest updates designed to enhance your job search experience.',
            'action_text' => 'Explore Features',
            'action_url' => url('/features'),
            'data' => [
                'New Features' => ['AI Resume Builder', 'Interview Scheduler', 'Salary Insights'],
                'Release Date' => now()->format('M j, Y'),
                'Users Benefited' => '10,000+'
            ]
        ]
    );
    
    $user->notify($notification);
    
    return response()->json([
        'message' => 'Info notification sent successfully',
        'user' => $user->name,
        'email' => $user->email
    ]);
});

// List all test routes
Route::get('/test-email', function () {
    return response()->json([
        'message' => 'Email Testing Routes Available',
        'routes' => [
            'GET /test-email/welcome/{userId}' => 'Test welcome email',
            'GET /test-email/verify/{userId}' => 'Test email verification',
            'GET /test-email/forgot-password/{userId}' => 'Test forgot password email',
            'GET /test-email/otp/{userId}' => 'Test OTP verification email',
            'GET /test-email/success/{userId}' => 'Test success notification',
            'GET /test-email/warning/{userId}' => 'Test warning notification',
            'GET /test-email/info/{userId}' => 'Test info notification',
            'GET /test-emails/preview/{type}' => 'Preview email template (no sending)',
        ],
        'note' => 'Replace {userId} with an actual user ID from your database'
    ]);
});

// Email Template Preview Routes (for API documentation)
Route::get('/test-emails/preview/{type}', [EmailTestController::class, 'preview'])
    ->where('type', 'welcome|verify|forgot-password|otp|notification|basic|action|urgent|achievement|data-table|job-match|security')
    ->name('email.preview');

// Additional notification preview routes for backward compatibility
Route::get('/test-emails/preview/notification/{subtype}', function($subtype) {
    return app(EmailTestController::class)->preview($subtype, request());
})->where('subtype', 'basic|action|urgent|achievement|data-table|job-match|security');