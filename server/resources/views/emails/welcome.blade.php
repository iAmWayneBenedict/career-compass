@extends('emails.layout')

@section('title', 'Welcome to Career Compass!')

@section('content')
    <h2 class="greeting">Welcome to Career Compass, {{ $user->name }}!</h2>
    
    <div class="content">
        <p>We're excited to have you join our community of professionals focused on career growth.</p>
        
        <p>Your account is ready! Start building your professional profile and discover new opportunities.</p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $dashboardUrl ?? '#' }}" class="btn">Get Started</a>
    </div>
    
    <div class="content">
        <p>Need help? Our support team is here for you.</p>
        
        <p style="margin-top: 25px;">
            Best regards,<br>
            <strong>The Career Compass Team</strong>
        </p>
    </div>
@endsection