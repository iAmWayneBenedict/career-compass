@extends('emails.layout')

@section('title', 'Your Verification Code')

@section('content')
    <h2 class="greeting">Verification Code</h2>
    
    <div class="content">
        <p>Hello {{ $user->name }},</p>
        
        <p>Here's your verification code:</p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <div style="background: #f7fafc; border: 2px solid #38a169; border-radius: 12px; padding: 25px; display: inline-block; font-family: 'Courier New', monospace;">
            <div style="font-size: 32px; font-weight: bold; color: #2d3748; letter-spacing: 8px;">
                {{ $otp }}
            </div>
        </div>
    </div>
    
    @if(isset($verificationUrl))
    <div class="content">
        <p>Or click the button below to verify automatically:</p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $verificationUrl }}" class="btn">Verify Automatically</a>
    </div>
    @endif
    
    <div class="content">
        <p>This code expires in {{ $expiryMinutes ?? 10 }} minutes. If you didn't request this code, please ignore this email.</p>
        
        <p style="margin-top: 25px;">
            Best regards,<br>
            <strong>The Career Compass Team</strong>
        </p>
    </div>
@endsection