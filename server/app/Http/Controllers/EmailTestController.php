<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\ForgotPasswordNotification;
use App\Notifications\OTPVerificationNotification;
use App\Notifications\DynamicNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class EmailTestController extends Controller
{
    /**
     * List all available email templates
     */
    public function templates(): JsonResponse
    {
        return response()->json([
            'message' => 'Available Email Templates',
            'templates' => [
                'welcome' => [
                    'name' => 'Welcome Email',
                    'description' => 'Sent to new users after registration',
                    'view' => 'emails.welcome',
                    'notification' => 'WelcomeNotification'
                ],
                'verify' => [
                    'name' => 'Email Verification',
                    'description' => 'Email address verification request',
                    'view' => 'emails.verify-email',
                    'notification' => 'CustomVerifyEmail'
                ],
                'forgot-password' => [
                    'name' => 'Password Reset',
                    'description' => 'Password reset request email',
                    'view' => 'emails.forgot-password',
                    'notification' => 'ForgotPasswordNotification'
                ],
                'otp' => [
                    'name' => 'OTP Verification',
                    'description' => 'One-time password for verification',
                    'view' => 'emails.otp-verification',
                    'notification' => 'OTPVerificationNotification'
                ],
                'notification' => [
                    'name' => 'Dynamic Notification',
                    'description' => 'Customizable notification template',
                    'view' => 'emails.notification',
                    'notification' => 'DynamicNotification',
                    'types' => ['success', 'warning', 'info']
                ]
            ],
            'usage' => [
                'test' => 'GET /api/v1/emails/test/{type}/{userId} - Send test email',
                'preview' => 'GET /api/v1/emails/preview/{type} - Preview template HTML'
            ]
        ]);
    }

    /**
     * Send a test email of the specified type
     */
    public function sendTest(string $type, int $userId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);
            
            switch ($type) {
                case 'welcome':
                    $dashboardUrl = url('/dashboard');
                    $user->notify(new WelcomeNotification($dashboardUrl));
                    break;
                    
                case 'verify':
                    $user->sendEmailVerificationNotification();
                    break;
                    
                case 'forgot-password':
                    $token = 'test-reset-token-' . time();
                    $user->sendPasswordResetNotification($token);
                    break;
                    
                case 'otp':
                    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                    $user->notify(new OTPVerificationNotification(
                        $otp,
                        10, // 10 minutes expiry
                        'Login Verification',
                        'Two-Factor Authentication',
                        url('/verify-otp'),
                        request()->ip()
                    ));
                    break;
                    
                case 'success':
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
                    break;
                    
                case 'warning':
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
                    break;
                    
                case 'info':
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
                    break;
                    
                default:
                    return response()->json([
                        'error' => [
                            'message' => 'Invalid email type',
                            'code' => 'INVALID_EMAIL_TYPE',
                            'available_types' => ['welcome', 'verify', 'forgot-password', 'otp', 'success', 'warning', 'info']
                        ],
                        'status' => 'error'
                    ], 400);
            }
            
            return response()->json([
                'data' => [
                    'type' => $type,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email
                    ],
                    'sent_at' => now()->toISOString()
                ],
                'message' => ucfirst($type) . ' email sent successfully',
                'status' => 'success'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => 'Failed to send test email',
                    'code' => 'EMAIL_SEND_FAILED',
                    'details' => $e->getMessage()
                ],
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Preview email template HTML without sending
     */
    public function preview(string $type, Request $request)
    {
        try {
            // Create a sample user for preview
            $sampleUser = (object) [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'created_at' => now()
            ];
            
            $html = '';
            
            switch ($type) {
                case 'welcome':
                    $html = View::make('emails.welcome', [
                        'user' => $sampleUser,
                        'dashboardUrl' => url('/dashboard')
                    ])->render();
                    break;
                    
                case 'verify':
                    $verificationUrl = url('/email/verify/1/sample-hash');
                    $html = View::make('emails.verify-email', [
                        'user' => $sampleUser,
                        'verificationUrl' => $verificationUrl
                    ])->render();
                    break;
                    
                case 'forgot-password':
                    $resetUrl = url('/reset-password/sample-token');
                    $html = View::make('emails.forgot-password', [
                        'user' => $sampleUser,
                        'resetUrl' => $resetUrl
                    ])->render();
                    break;
                    
                case 'otp':
                    $html = View::make('emails.otp-verification', [
                        'user' => $sampleUser,
                        'otp' => '123456',
                        'expiryMinutes' => 10,
                        'purpose' => 'Login Verification',
                        'context' => 'Two-Factor Authentication',
                        'verificationUrl' => url('/verify-otp'),
                        'ipAddress' => '192.168.1.1'
                    ])->render();
                    break;
                    
                case 'notification':
                case 'basic':
                    $notification = [
                        'title' => 'Basic Notification',
                        'greeting' => 'Hello, ' . $sampleUser->name . '!',
                        'message' => 'This is a basic notification message for preview purposes.',
                        'description' => 'Additional description text goes here.'
                    ];
                    
                    $html = View::make('emails.notification', [
                        'user' => $sampleUser,
                        'notification' => $notification
                    ])->render();
                    break;
                    
                case 'action':
                    $notification = [
                        'title' => 'Action Required',
                        'greeting' => 'Hello, ' . $sampleUser->name . '!',
                        'message' => 'Please take action on your account.',
                        'description' => 'Click the button below to complete the required action.',
                        'action' => [
                            'text' => 'Take Action',
                            'url' => url('/dashboard')
                        ]
                    ];
                    
                    $html = View::make('emails.notification', [
                        'user' => $sampleUser,
                        'notification' => $notification
                    ])->render();
                    break;
                    
                case 'urgent':
                    $notification = [
                        'title' => 'Urgent: Security Alert',
                        'greeting' => 'Hello, ' . $sampleUser->name . '!',
                        'message' => 'We detected suspicious activity on your account.',
                        'description' => 'Please review your account security immediately.',
                        'urgent' => true,
                        'action' => [
                            'text' => 'Secure Account',
                            'url' => url('/security')
                        ]
                    ];
                    
                    $html = View::make('emails.notification', [
                        'user' => $sampleUser,
                        'notification' => $notification
                    ])->render();
                    break;
                    
                case 'achievement':
                    $notification = [
                        'title' => 'Congratulations! Achievement Unlocked',
                        'greeting' => 'Hello, ' . $sampleUser->name . '!',
                        'message' => 'You\'ve reached a new milestone in your career journey!',
                        'description' => 'Keep up the great work and continue advancing your career.',
                        'highlight' => 'Profile Completion: 100%',
                        'action' => [
                            'text' => 'View Achievement',
                            'url' => url('/achievements')
                        ]
                    ];
                    
                    $html = View::make('emails.notification', [
                        'user' => $sampleUser,
                        'notification' => $notification
                    ])->render();
                    break;
                    
                case 'data-table':
                    $notification = [
                        'title' => 'Weekly Report',
                        'greeting' => 'Hello, ' . $sampleUser->name . '!',
                        'message' => 'Here\'s your weekly activity summary.',
                        'description' => 'Review your progress and achievements from this week.',
                        'data_table' => [
                            'Applications Sent' => '12',
                            'Profile Views' => '45',
                            'Messages Received' => '8',
                            'Interviews Scheduled' => '3'
                        ]
                    ];
                    
                    $html = View::make('emails.notification', [
                        'user' => $sampleUser,
                        'notification' => $notification
                    ])->render();
                    break;
                    
                case 'job-match':
                    $notification = [
                        'title' => 'New Job Matches Found!',
                        'greeting' => 'Hello, ' . $sampleUser->name . '!',
                        'message' => 'We found 5 new job opportunities that match your profile.',
                        'description' => 'These positions align with your skills and career goals.',
                        'highlight' => '5 New Matches',
                        'action' => [
                            'text' => 'View Jobs',
                            'url' => url('/jobs')
                        ],
                        'data_table' => [
                            'Senior Developer' => 'TechCorp Inc.',
                            'Full Stack Engineer' => 'StartupXYZ',
                            'Lead Developer' => 'BigTech Co.'
                        ]
                    ];
                    
                    $html = View::make('emails.notification', [
                        'user' => $sampleUser,
                        'notification' => $notification
                    ])->render();
                    break;
                    
                case 'security':
                    $notification = [
                        'title' => 'Security Update Required',
                        'greeting' => 'Hello, ' . $sampleUser->name . '!',
                        'message' => 'Please update your security settings to keep your account safe.',
                        'description' => 'We recommend enabling two-factor authentication for enhanced security.',
                        'sender' => 'Career Compass Security Team',
                        'sender_title' => 'Security Department',
                        'action' => [
                            'text' => 'Update Security',
                            'url' => url('/security')
                        ],
                        'footer_message' => 'This is an automated security reminder.'
                    ];
                    
                    $html = View::make('emails.notification', [
                        'user' => $sampleUser,
                        'notification' => $notification
                    ])->render();
                    break;
                    
                default:
                    return response()->json([
                        'error' => [
                            'message' => 'Invalid template type',
                            'code' => 'INVALID_TEMPLATE_TYPE',
                            'available_types' => ['welcome', 'verify', 'forgot-password', 'otp', 'notification', 'basic', 'action', 'urgent', 'achievement', 'data-table', 'job-match', 'security']
                        ],
                        'status' => 'error'
                    ], 400);
            }
            
            // Return HTML response for browser viewing
            if ($request->wantsJson()) {
                return response()->json([
                    'data' => [
                        'type' => $type,
                        'html' => $html,
                        'preview_url' => url("/api/v1/emails/preview/{$type}")
                    ],
                    'message' => 'Template preview generated',
                    'status' => 'success'
                ]);
            }
            
            return response($html)->header('Content-Type', 'text/html');
            
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => [
                        'message' => 'Failed to generate preview',
                        'code' => 'PREVIEW_GENERATION_FAILED',
                        'details' => $e->getMessage()
                    ],
                    'status' => 'error'
                ], 500);
            }
            
            return response('<h1>Preview Error</h1><p>' . $e->getMessage() . '</p>', 500)
                ->header('Content-Type', 'text/html');
        }
    }
}