@extends('emails.layout')

@section('title', 'Reset Your Password')

@section('content')
    <h2 class="greeting">Password Reset Request</h2>
    
    <div class="content">
        <p>Hello {{ $user->name }},</p>
        
        <p>We received a request to reset your password. Click the button below to create a new password:</p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $resetUrl }}" class="btn">Reset My Password</a>
    </div>
    
    <div class="content">
        <p><strong>Having trouble?</strong> Copy and paste this link into your browser:</p>
        <div style="background: #f7fafc; padding: 15px; border-radius: 8px; margin: 15px 0; word-break: break-all; font-family: monospace; font-size: 14px; color: #4a5568;">
            {{ $resetUrl }}
        </div>
    </div>
    
    <div class="content">
        <p>This link expires in 60 minutes. If you didn't request this reset, please ignore this email.</p>
        
        <p style="margin-top: 25px;">
            Stay secure,<br>
            <strong>The Career Compass Team</strong>
        </p>
    </div>
@endsection