<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ApiDocumentationController;
use App\Http\Controllers\EmailTestController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;

// API Documentation Routes (Public)
Route::get('/docs', [ApiDocumentationController::class, 'index']);
Route::get('/docs/{category}', [ApiDocumentationController::class, 'category']);

// All routes prefixed with api/v1
Route::prefix('v1')->group(function () {
    
    // API Documentation Routes
    Route::get('/docs', [ApiDocumentationController::class, 'index']);
    Route::get('/docs/{category}', [ApiDocumentationController::class, 'category']);
    
    // Email Testing Routes (Development only)
    Route::prefix('emails')->group(function () {
        Route::get('/templates', [EmailTestController::class, 'templates']);
        Route::get('/test/{type}/{userId}', [EmailTestController::class, 'sendTest'])
            ->where('type', 'welcome|verify|forgot-password|otp|success|warning|info')
            ->where('userId', '[0-9]+');
        Route::get('/preview/{type}', [EmailTestController::class, 'preview'])
            ->where('type', 'welcome|verify|forgot-password|otp|notification|basic|action|urgent|achievement|data-table|job-match|security');
    });
    // Public routes
    Route::group(['prefix' => 'auth'], function () {
        // Login and Registration
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware(['guest']);
        
        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware(['guest']);
        
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware(['auth:sanctum']);
        
        // Email Verification
        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
            ->middleware(['auth:sanctum', 'signed', 'throttle:6,1'])
            ->name('verification.verify');
        
        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware(['auth:sanctum', 'throttle:6,1'])
            ->name('verification.send');
        
        // Password Reset
        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware(['guest'])
            ->name('password.email');
        
        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->middleware(['guest'])
            ->name('password.update');
        
        // Social Login
        Route::get('/social/{provider}', [AuthController::class, 'socialLogin'])
            ->middleware(['guest']);
        
        Route::get('/social/{provider}/callback', [AuthController::class, 'socialCallback'])
            ->middleware(['guest']);
    });

    Route::get("/user", function (Request $request) {
            return $request->user();
    });
    // Sanctum Routes
    Route::middleware(["auth:sanctum"])->group(function () {
        // Protected routes
        Route::middleware(['verified'])->group(function () {
            

            Route::get("/users", function (Request $request) {
                return User::all();
            });
        });
    });
});
Route::get('/db-config', function () {
    return [
        'host' => config('database.connections.mysql.host'),
        'port' => config('database.connections.mysql.port'),
        'database' => config('database.connections.mysql.database'),
        'username' => config('database.connections.mysql.username'),
        'driver' => config('database.connections.mysql.driver'),
    ];
});