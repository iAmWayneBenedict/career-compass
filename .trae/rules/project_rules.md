# Laravel API + Vue TypeScript Development Rules

## 1. Project Architecture & Separation

### Backend-Frontend Separation
- **Laravel**: Serves as pure API backend (no Blade views for main app)
- **Vue TypeScript**: Handles all frontend logic and UI
- **Communication**: REST API with JSON responses only
- **Authentication**: API-based (Sanctum/Passport) with token management
- **File Structure**: Keep frontend and backend completely separate

### API-First Approach
- Design APIs before implementing frontend features
- Document APIs before development begins
- Version your APIs from the start (`/api/v1/`)
- Use consistent response structures across all endpoints

## 2. Laravel Backend Rules

### API Controller Guidelines
- Return JSON responses exclusively
- Use API Resources for data transformation
- Implement consistent response wrapper
- Handle CORS properly for Vue app

```php
// Good - API Controller
class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::paginate(15);
        return UserResource::collection($users)
            ->response()
            ->header('X-Total-Count', $users->total());
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());
        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }
}
```

### API Response Structure
- Use consistent response format across all endpoints
- Include metadata for pagination and status
- Standardize error response format

```php
// Consistent API Response Structure
{
    "data": { /* actual data */ },
    "meta": {
        "pagination": { /* pagination info */ },
        "timestamp": "2024-01-01T00:00:00Z"
    },
    "message": "Success message",
    "status": "success"
}

// Error Response Structure
{
    "error": {
        "message": "Validation failed",
        "code": "VALIDATION_ERROR",
        "details": { /* validation errors */ }
    },
    "status": "error"
}
```

### API Resource Rules
- Create API Resources for all model responses
- Use Resource Collections for list endpoints
- Transform dates to ISO 8601 format
- Hide sensitive fields (passwords, tokens)
- Include related data conditionally

```php
// Good API Resource
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar_url,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}
```

### Authentication for SPA
- Use Laravel Sanctum for SPA authentication
- Implement CSRF protection for same-domain requests
- Use stateful authentication (sessions) for same-domain SPAs
- Provide token-based auth for mobile/external apps

```php
// Sanctum Configuration
// In config/sanctum.php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost,127.0.0.1')),

// API Routes for Vue App
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', UserController::class);
});
```

## 3. API Development Standards

### Endpoint Naming Conventions
- Use RESTful resource naming
- Plural nouns for resources (`/users`, `/blog-posts`)
- Nested resources for relationships (`/users/{id}/posts`)
- Use query parameters for filtering/sorting

```php
// Good API Routes
Route::prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('users.posts', UserPostController::class)->shallow();
    Route::get('users/{user}/posts', [UserController::class, 'posts']);
    
    // Filtering examples
    // GET /api/v1/users?filter[status]=active&sort=-created_at
});
```

### Request Validation
- Create Form Requests for all API endpoints
- Use consistent validation rules
- Return validation errors in structured format
- Validate JSON payloads strictly

```php
// API Form Request
class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error' => [
                    'message' => 'Validation failed',
                    'code' => 'VALIDATION_ERROR',
                    'details' => $validator->errors()
                ],
                'status' => 'error'
            ], 422)
        );
    }
}
```

### CORS Configuration
```php
// config/cors.php - Configured for Vue development
'allowed_origins' => [
    'http://localhost:3000', // Vue dev server
    'http://localhost:5173', // Vite dev server
    env('FRONTEND_URL', 'https://yourapp.com')
],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'exposed_headers' => ['X-Total-Count'],
'supports_credentials' => true,
```

## 4. Frontend Integration Guidelines

### API Client Setup (TypeScript)
- Create typed API client using Axios
- Define interfaces for all API responses
- Implement request/response interceptors
- Handle authentication tokens automatically

```typescript
// api/types.ts
export interface User {
  id: number;
  name: string;
  email: string;
  avatar?: string;
  created_at: string;
  updated_at: string;
}

export interface ApiResponse<T> {
  data: T;
  meta?: {
    pagination?: PaginationMeta;
    timestamp: string;
  };
  message: string;
  status: 'success' | 'error';
}

// api/client.ts
import axios, { AxiosResponse } from 'axios';

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api/v1',
  withCredentials: true, // For Sanctum
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
});

export default apiClient;
```

### Data Validation on Frontend
- Validate data on frontend before sending to API
- Use libraries like Vuelidate or VeeValidate
- Match validation rules with backend requirements
- Show real-time validation feedback

### State Management
- Use Pinia for Vue state management
- Create stores for different domain entities
- Handle API loading states consistently
- Implement optimistic updates where appropriate

```typescript
// stores/userStore.ts
import { defineStore } from 'pinia';
import type { User, ApiResponse } from '@/api/types';
import apiClient from '@/api/client';

export const useUserStore = defineStore('user', () => {
  const users = ref<User[]>([]);
  const loading = ref(false);
  const error = ref<string | null>(null);

  const fetchUsers = async () => {
    loading.value = true;
    error.value = null;
    
    try {
      const response = await apiClient.get<ApiResponse<User[]>>('/users');
      users.value = response.data.data;
    } catch (err) {
      error.value = 'Failed to fetch users';
      console.error(err);
    } finally {
      loading.value = false;
    }
  };

  return { users, loading, error, fetchUsers };
});
```

## 5. Authentication Flow

### Laravel Backend Auth Setup
```php
// Login endpoint
public function login(LoginRequest $request): JsonResponse
{
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'error' => [
                'message' => 'Invalid credentials',
                'code' => 'INVALID_CREDENTIALS'
            ],
            'status' => 'error'
        ], 401);
    }

    $request->session()->regenerate();
    
    return response()->json([
        'data' => new UserResource(Auth::user()),
        'message' => 'Login successful',
        'status' => 'success'
    ]);
}

// Logout endpoint
public function logout(): JsonResponse
{
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    
    return response()->json([
        'message' => 'Logout successful',
        'status' => 'success'
    ]);
}
```

### Vue Authentication Composable
```typescript
// composables/useAuth.ts
import { ref, computed } from 'vue';
import type { User } from '@/api/types';
import apiClient from '@/api/client';

const user = ref<User | null>(null);
const loading = ref(false);

export const useAuth = () => {
  const isAuthenticated = computed(() => !!user.value);

  const login = async (credentials: LoginCredentials) => {
    loading.value = true;
    
    try {
      // Get CSRF cookie first
      await apiClient.get('/sanctum/csrf-cookie');
      
      const response = await apiClient.post('/auth/login', credentials);
      user.value = response.data.data;
      
      return { success: true };
    } catch (error) {
      return { success: false, error };
    } finally {
      loading.value = false;
    }
  };

  const logout = async () => {
    try {
      await apiClient.post('/auth/logout');
      user.value = null;
    } catch (error) {
      console.error('Logout error:', error);
    }
  };

  return {
    user: readonly(user),
    isAuthenticated,
    loading: readonly(loading),
    login,
    logout,
  };
};
```

## 6. Error Handling Strategy

### Backend Error Handling
```php
// Custom Exception Handler
public function render($request, Throwable $exception)
{
    if ($request->expectsJson()) {
        return $this->handleApiException($exception);
    }

    return parent::render($request, $exception);
}

private function handleApiException(Throwable $exception): JsonResponse
{
    $statusCode = 500;
    $errorCode = 'INTERNAL_ERROR';
    $message = 'An error occurred';

    if ($exception instanceof ValidationException) {
        $statusCode = 422;
        $errorCode = 'VALIDATION_ERROR';
        $message = 'Validation failed';
    } elseif ($exception instanceof AuthenticationException) {
        $statusCode = 401;
        $errorCode = 'AUTHENTICATION_ERROR';
        $message = 'Authentication required';
    }

    return response()->json([
        'error' => [
            'message' => $message,
            'code' => $errorCode,
            'details' => $exception instanceof ValidationException ? $exception->errors() : null
        ],
        'status' => 'error'
    ], $statusCode);
}
```

### Frontend Error Handling
```typescript
// composables/useApi.ts
export const useApi = () => {
  const handleApiError = (error: any) => {
    if (error.response?.status === 401) {
      // Handle authentication error
      router.push('/login');
    } else if (error.response?.status === 422) {
      // Handle validation errors
      return error.response.data.error.details;
    } else {
      // Handle other errors
      console.error('API Error:', error);
      throw new Error(error.response?.data?.error?.message || 'An error occurred');
    }
  };

  return { handleApiError };
};
```

## 7. Development Workflow

### Local Development Setup
1. **Laravel API**: Run on `http://localhost:8000`
2. **Vue App**: Run on `http://localhost:3000` or `http://localhost:5173`
3. **Database**: Use consistent seeding for both environments
4. **CORS**: Configure for local development domains

### Environment Configuration
```bash
# Laravel .env
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000

# Vue .env
VITE_API_URL=http://localhost:8000/api/v1
VITE_APP_NAME="Your App Name"
```

### Testing Strategy
- **Backend**: Test API endpoints with Feature tests
- **Frontend**: Test components and composables with Vitest
- **Integration**: Test API integration with MSW (Mock Service Worker)
- **E2E**: Use Playwright for end-to-end testing

### Deployment Considerations
- Build Vue app as static assets
- Serve Laravel API and Vue app from same domain (recommended)
- Use CDN for static assets
- Implement proper caching headers
- Monitor API performance and frontend metrics

## 8. Performance Optimization

### Backend Performance
- Use API Resources to optimize data transfer
- Implement pagination for all list endpoints
- Cache frequently accessed data (Redis)
- Use database indexing for API queries
- Implement API rate limiting

### Frontend Performance
- Lazy load routes and components
- Implement virtual scrolling for large lists
- Use proper caching strategies (HTTP cache, SWR)
- Optimize bundle size with code splitting
- Implement skeleton loading states