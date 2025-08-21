@extends('emails.layout')

@section('title', 'Verify Your Email Address')

@section('content')
    <h2 class="greeting">Almost there, {{ $user->name }}!</h2>
    
    <div class="content">
        <p>Please verify your email address to complete your registration.</p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $verificationUrl }}" class="btn">Verify Email Address</a>
    </div>
    
    <div class="content">
        <p><strong>Having trouble?</strong> Copy and paste this link into your browser:</p>
        <div style="background: #f7fafc; padding: 15px; border-radius: 8px; margin: 15px 0; word-break: break-all; font-family: monospace; font-size: 14px; color: #4a5568;">
            {{ $verificationUrl }}
        </div>
    </div>
    
    <div class="content">
        <p>This link expires in 60 minutes. If you didn't create this account, please ignore this email.</p>
        
        <p style="margin-top: 25px;">
            Welcome aboard!<br>
            <strong>The Career Compass Team</strong>
        </p>
    </div>
@endsection