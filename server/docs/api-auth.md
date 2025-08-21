# Authentication API Documentation

This document provides details about the authentication endpoints available in the Career Compass API.

## Base URL

All endpoints are prefixed with: `/api/v1/auth`

## Authentication Endpoints

### Login

Authenticates a user and creates a session.

- **URL:** `/api/v1/auth/login`
- **Method:** `POST`
- **Auth Required:** No (Guest only)
- **Parameters:**
  - `email` (string, required): User's email address
  - `password` (string, required): User's password
  - `remember` (boolean, optional): Keep the user logged in

**Request Example:**
```json
{
  "email": "user@example.com",
  "password": "password123",
  "remember": true
}
```

**Response Example:**
```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  },
  "message": "Login successful",
  "status": "success"
}
```

### Register

Creates a new user account.

- **URL:** `/api/v1/auth/register`
- **Method:** `POST`
- **Auth Required:** No (Guest only)
- **Parameters:**
  - `name` (string, required): User's full name
  - `email` (string, required): User's email address
  - `password` (string, required): User's password (min 8 characters)
  - `password_confirmation` (string, required): Password confirmation

**Request Example:**
```json
{
  "name": "John Doe",
  "email": "user@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response Example:**
```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  },
  "message": "User registered successfully",
  "status": "success"
}
```

### Logout

Logs out the currently authenticated user.

- **URL:** `/api/v1/auth/logout`
- **Method:** `POST`
- **Auth Required:** Yes (Sanctum)
- **Parameters:** None

**Response Example:**
```json
{
  "message": "Logout successful",
  "status": "success"
}
```

### Email Verification

#### Verify Email

Verifies a user's email address using the verification link.

- **URL:** `/api/v1/auth/email/verify/{id}/{hash}`
- **Method:** `GET`
- **Auth Required:** Yes (Sanctum)
- **URL Parameters:**
  - `id` (integer, required): User ID
  - `hash` (string, required): Verification hash
- **Query Parameters:**
  - `expires` (integer, required): Timestamp when the link expires
  - `signature` (string, required): Signature to verify the URL

**Response Example:**
```json
{
  "message": "Email verified successfully",
  "status": "success"
}
```

#### Resend Verification Email

Resends the email verification link to the user.

- **URL:** `/api/v1/auth/email/verification-notification`
- **Method:** `POST`
- **Auth Required:** Yes (Sanctum)
- **Parameters:** None

**Response Example:**
```json
{
  "message": "Verification link sent",
  "status": "success"
}
```

### Password Reset

#### Request Password Reset

Sends a password reset link to the user's email.

- **URL:** `/api/v1/auth/forgot-password`
- **Method:** `POST`
- **Auth Required:** No (Guest only)
- **Parameters:**
  - `email` (string, required): User's email address

**Request Example:**
```json
{
  "email": "user@example.com"
}
```

**Response Example:**
```json
{
  "message": "Password reset link sent",
  "status": "success"
}
```

#### Reset Password

Resets the user's password using the token from the email.

- **URL:** `/api/v1/auth/reset-password`
- **Method:** `POST`
- **Auth Required:** No (Guest only)
- **Parameters:**
  - `token` (string, required): Reset token from the email
  - `email` (string, required): User's email address
  - `password` (string, required): New password
  - `password_confirmation` (string, required): New password confirmation

**Request Example:**
```json
{
  "token": "abcdef1234567890",
  "email": "user@example.com",
  "password": "newpassword123",
  "password_confirmation": "newpassword123"
}
```

**Response Example:**
```json
{
  "message": "Password reset successfully",
  "status": "success"
}
```

### Social Authentication

#### Initiate Social Login

Redirects the user to the OAuth provider's login page.

- **URL:** `/api/v1/auth/social/{provider}`
- **Method:** `GET`
- **Auth Required:** No (Guest only)
- **URL Parameters:**
  - `provider` (string, required): OAuth provider name (e.g., 'google', 'github', 'facebook')

#### Social Login Callback

Handles the callback from the OAuth provider.

- **URL:** `/api/v1/auth/social/{provider}/callback`
- **Method:** `GET`
- **Auth Required:** No (Guest only)
- **URL Parameters:**
  - `provider` (string, required): OAuth provider name (e.g., 'google', 'github', 'facebook')

**Response Example:**
```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  },
  "message": "Login successful",
  "status": "success"
}
```

## Protected Routes

The following routes require authentication and email verification:

### Get Current User

Returns the currently authenticated user's information.

- **URL:** `/api/v1/user`
- **Method:** `GET`
- **Auth Required:** Yes (Sanctum + Verified Email)

**Response Example:**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "user@example.com",
  "email_verified_at": "2023-01-01T00:00:00.000000Z",
  "created_at": "2023-01-01T00:00:00.000000Z",
  "updated_at": "2023-01-01T00:00:00.000000Z"
}
```

### Get All Users

Returns a list of all users (typically for admin purposes).

- **URL:** `/api/v1/users`
- **Method:** `GET`
- **Auth Required:** Yes (Sanctum + Verified Email)

**Response Example:**
```json
[
  {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "email_verified_at": "2023-01-01T00:00:00.000000Z",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  },
  {
    "id": 2,
    "name": "Jane Smith",
    "email": "jane@example.com",
    "email_verified_at": "2023-01-01T00:00:00.000000Z",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  }
]
```

## Error Responses

All endpoints follow a consistent error response format:

```json
{
  "error": {
    "message": "Error message",
    "code": "ERROR_CODE",
    "details": {}
  },
  "status": "error"
}
```

Common error codes:
- `VALIDATION_ERROR`: Request validation failed
- `AUTHENTICATION_ERROR`: Authentication required
- `INVALID_CREDENTIALS`: Login credentials are incorrect
- `EMAIL_NOT_VERIFIED`: Email verification required