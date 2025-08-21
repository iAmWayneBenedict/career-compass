<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class ApiDocumentationController extends Controller
{
    /**
     * Get centralized API documentation
     */
    public function index(): JsonResponse
    {
        $documentation = $this->getDocumentationData();
        return response()->json($documentation);
    }

    /**
     * Get API documentation within v1 namespace
     */
    public function v1Documentation(): JsonResponse
    {
        return $this->index();
    }

    /**
     * Display API documentation web interface
     */
    public function webInterface(): View
    {
        $documentation = $this->getDocumentationData();
        return view('api-documentation', compact('documentation'));
    }

    /**
     * Get structured documentation data
     */
    private function getDocumentationData(): array
    {
        return [
            'api_version' => 'v1',
            'base_url' => config('app.url') . '/api/v1',
            'app_name' => config('app.name', 'Career Compass'),
            'categories' => [
                'authentication' => [
                    'name' => 'Authentication',
                    'description' => 'User authentication and authorization endpoints',
                    'base_path' => '/auth',
                    'endpoints' => [
                        [
                            'method' => 'POST',
                            'path' => '/register',
                            'description' => 'Register a new user account',
                            'authenticated' => false
                        ],
                        [
                            'method' => 'POST',
                            'path' => '/login',
                            'description' => 'Authenticate user and create session',
                            'authenticated' => false
                        ],
                        [
                            'method' => 'POST',
                            'path' => '/logout',
                            'description' => 'Logout user and invalidate session',
                            'authenticated' => true
                        ],
                        [
                            'method' => 'POST',
                            'path' => '/forgot-password',
                            'description' => 'Send password reset email',
                            'authenticated' => false
                        ],
                        [
                            'method' => 'POST',
                            'path' => '/reset-password',
                            'description' => 'Reset password using token',
                            'authenticated' => false
                        ]
                    ]
                ],
                'user_management' => [
                    'name' => 'User Management',
                    'description' => 'User profile and account management',
                    'base_path' => '',
                    'endpoints' => [
                        [
                            'method' => 'GET',
                            'path' => '/user',
                            'description' => 'Get authenticated user profile',
                            'authenticated' => true
                        ],
                        [
                            'method' => 'PUT',
                            'path' => '/user/profile',
                            'description' => 'Update user profile information',
                            'authenticated' => true
                        ],
                        [
                            'method' => 'POST',
                            'path' => '/email/verification-notification',
                            'description' => 'Resend email verification notification',
                            'authenticated' => true
                        ]
                    ]
                ],
                'email_testing' => [
                    'name' => 'Email Testing & Preview',
                    'description' => 'Development endpoints for testing email templates',
                    'base_path' => '/emails',
                    'note' => 'Available only in development environment',
                    'endpoints' => [
                        [
                            'method' => 'GET',
                            'path' => '/templates',
                            'description' => 'List all available email templates',
                            'authenticated' => false
                        ],
                        [
                            'method' => 'POST',
                            'path' => '/send-test/{type}',
                            'description' => 'Send test email of specified type to authenticated user',
                            'authenticated' => true
                        ],
                        [
                            'method' => 'GET',
                            'path' => '/preview/{type}',
                            'description' => 'Preview email template HTML without sending',
                            'authenticated' => false
                        ]
                    ]
                ],
                'api_documentation' => [
                    'name' => 'API Documentation',
                    'description' => 'Endpoints for accessing API documentation in different formats',
                    'base_path' => '',
                    'endpoints' => [
                        [
                            'method' => 'GET',
                            'path' => '/docs',
                            'description' => 'View this documentation page',
                            'authenticated' => false
                        ],
                        [
                            'method' => 'GET',
                            'path' => '/routes',
                            'description' => 'Get centralized API documentation (JSON format)',
                            'authenticated' => false
                        ],
                        [
                            'method' => 'GET',
                            'path' => '/v1/routes',
                            'description' => 'Get API documentation within v1 namespace',
                            'authenticated' => false
                        ]
                    ]
                ]
            ],
            'email_templates' => [
                // Basic Email Templates
                [
                    'type' => 'welcome',
                    'description' => 'Welcome email for new users',
                    'category' => 'basic'
                ],
                [
                    'type' => 'verify',
                    'description' => 'Email verification notification',
                    'category' => 'basic'
                ],
                [
                    'type' => 'forgot-password',
                    'description' => 'Password reset email',
                    'category' => 'basic'
                ],
                [
                    'type' => 'otp',
                    'description' => 'OTP verification email',
                    'category' => 'basic'
                ],
                // Dynamic Notification Templates
                [
                    'type' => 'basic',
                    'description' => 'Basic notification with title and message',
                    'category' => 'notification'
                ],
                [
                    'type' => 'action',
                    'description' => 'Notification with action button',
                    'category' => 'notification'
                ],
                [
                    'type' => 'urgent',
                    'description' => 'Urgent notification with priority styling',
                    'category' => 'notification'
                ],
                [
                    'type' => 'achievement',
                    'description' => 'Achievement notification with celebration',
                    'category' => 'notification'
                ],
                [
                    'type' => 'data-table',
                    'description' => 'Notification with structured data table',
                    'category' => 'notification'
                ],
                [
                    'type' => 'job-match',
                    'description' => 'Job matching notification with details',
                    'category' => 'notification'
                ],
                [
                    'type' => 'security',
                    'description' => 'Security alert notification',
                    'category' => 'notification'
                ]
            ],
            'response_formats' => [
                [
                    'name' => 'Success Response',
                    'example' => [
                        'data' => '{ /* actual data */ }',
                        'meta' => [
                            'pagination' => '{ /* pagination info */ }',
                            'timestamp' => '2024-01-01T00:00:00Z'
                        ],
                        'message' => 'Success message',
                        'status' => 'success'
                    ]
                ],
                [
                    'name' => 'Error Response',
                    'example' => [
                        'error' => [
                            'message' => 'Error description',
                            'code' => 'ERROR_CODE',
                            'details' => '{ /* additional error details */ }'
                        ],
                        'status' => 'error'
                    ]
                ]
            ],
            'authentication_info' => [
                [
                    'title' => 'Session-based Authentication',
                    'description' => 'For same-domain SPA applications'
                ],
                [
                    'title' => 'CSRF Protection',
                    'description' => 'Required for state-changing operations'
                ],
                [
                    'title' => 'Token-based Authentication',
                    'description' => 'Available for external applications'
                ],
                [
                    'title' => 'Email Verification',
                    'description' => 'Required for accessing protected resources'
                ]
            ],
            'security_notes' => [
                'Always use HTTPS in production environments',
                'Email testing endpoints are disabled in production',
                'Rate limiting is applied to all authentication endpoints',
                'Sessions expire after 2 hours of inactivity'
            ]
        ];
    }

    /**
     * Get documentation for a specific category
     */
    public function category(string $category): JsonResponse
    {
        $categories = [
            'authentication' => [
                'title' => 'Authentication API',
                'description' => 'Endpoints for user authentication, registration, and password management',
                'base_path' => '/api/v1/auth',
                'endpoints' => [
                    [
                        'method' => 'POST',
                        'path' => '/login',
                        'description' => 'Authenticate user with email and password',
                        'parameters' => [
                            'email' => 'string|required|email',
                            'password' => 'string|required|min:8'
                        ],
                        'response' => [
                            'data' => 'User object',
                            'message' => 'Login successful'
                        ]
                    ],
                    [
                        'method' => 'POST',
                        'path' => '/register',
                        'description' => 'Register a new user account',
                        'parameters' => [
                            'name' => 'string|required|max:255',
                            'email' => 'string|required|email|unique:users',
                            'password' => 'string|required|min:8|confirmed'
                        ],
                        'response' => [
                            'data' => 'User object',
                            'message' => 'Registration successful'
                        ]
                    ]
                ]
            ],
            'user' => [
                'title' => 'User Management API',
                'description' => 'Endpoints for user profile and account management',
                'base_path' => '/api/v1',
                'endpoints' => [
                    [
                        'method' => 'GET',
                        'path' => '/user',
                        'description' => 'Get current authenticated user profile',
                        'authentication' => 'required',
                        'response' => [
                            'data' => 'Current user object'
                        ]
                    ]
                ]
            ],
            'email_testing' => [
                'title' => 'Email Testing API',
                'description' => 'Development endpoints for testing and previewing email templates',
                'base_path' => '/api/v1/emails',
                'note' => 'These endpoints should be disabled in production',
                'endpoints' => [
                    [
                        'method' => 'GET',
                        'path' => '/test/{type}/{userId}',
                        'description' => 'Send a test email of the specified type',
                        'parameters' => [
                            'type' => 'welcome|verify|forgot-password|otp|success|warning|info',
                            'userId' => 'integer|exists:users,id'
                        ]
                    ],
                    [
                        'method' => 'GET',
                        'path' => '/preview/{type}',
                        'description' => 'Preview email template HTML without sending',
                        'parameters' => [
                            'type' => 'welcome|verify|forgot-password|otp|notification'
                        ]
                    ]
                ]
            ]
        ];

        if (!isset($categories[$category])) {
            return response()->json([
                'error' => [
                    'message' => 'Category not found',
                    'code' => 'CATEGORY_NOT_FOUND',
                    'available_categories' => array_keys($categories)
                ],
                'status' => 'error'
            ], 404);
        }

        return response()->json([
            'category' => $category,
            'documentation' => $categories[$category],
            'status' => 'success'
        ]);
    }
}