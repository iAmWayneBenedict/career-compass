<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Handle social login request
     */
    public function socialLogin(string $provider): JsonResponse
    {
        $validProviders = ['google'];
        
        if (!in_array($provider, $validProviders)) {
            return response()->json([
                'error' => [
                    'message' => 'Invalid social provider',
                    'code' => 'INVALID_PROVIDER'
                ],
                'status' => 'error'
            ], 400);
        }
        
        return response()->json([
            'redirect_url' => Socialite::driver($provider)->redirect()->getTargetUrl(),
            'status' => 'success'
        ]);
    }

    /**
     * Handle social login callback
     */
    public function socialCallback(string $provider): JsonResponse
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Find existing user or create new one
            $user = User::where('email', $socialUser->getEmail())->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(\Illuminate\Support\Str::random(16)),
                    'email_verified_at' => now(),
                ]);
                
                event(new Registered($user));
            }
            
            Auth::login($user);
            
            return response()->json([
                'data' => $user,
                'message' => 'Social login successful',
                'status' => 'success'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Social login error: ' . $e->getMessage());
            
            return response()->json([
                'error' => [
                    'message' => 'Failed to authenticate with ' . $provider,
                    'code' => 'SOCIAL_AUTH_ERROR'
                ],
                'status' => 'error'
            ], 500);
        }
    }
}