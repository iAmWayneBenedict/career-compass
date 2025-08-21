<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Career Compass')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8fafc;
            padding: 20px 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-top: 3px solid #3AAA6D;
            border-bottom: 3px solid #3AAA6D;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: #ffffff;
            padding: 30px;
            text-align: center;
            color: #3AAA6D;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .logo {
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 600;
            letter-spacing: -0.3px;
            margin: 0;
        }
        
        .logo-tagline {
            font-size: 13px;
            opacity: 0.9;
            margin-top: 8px;
            font-weight: 400;
        }
        
        .email-body {
            padding: 35px 30px;
            text-align: center;
        }
        
        .greeting {
            font-size: 22px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 24px;
            line-height: 1.3;
        }
        
        .content {
            font-size: 16px;
            line-height: 1.7;
            color: #4a5568;
            margin-bottom: 30px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #3AAA6D;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            font-size: 15px;
            text-align: center;
            transition: background-color 0.2s ease;
        }
        
        .btn:hover {
            background: #2d8a56;
        }
        
        .btn-secondary {
            background: #f7fafc;
            color: #4a5568;
            border: 1px solid #e2e8f0;
        }
        
        .btn-secondary:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }
        
        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 30px 0;
        }
        
        .info-box {
            background: #f8f9fa;
            border-left: 3px solid #6c757d;
            padding: 18px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }
        
        .info-box.warning {
            border-left-color: #6c757d;
            background: #f8f9fa;
        }
        
        .info-box.success {
            border-left-color: #3AAA6D;
            background: #f8fffe;
        }
        
        .otp-code {
            background: #3AAA6D;
            color: white;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 6px;
            text-align: center;
            padding: 18px;
            border-radius: 4px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
        }
        
        .email-footer {
            background: #ffffff;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-text {
            font-size: 14px;
            color: #718096;
            margin-bottom: 15px;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #3AAA6D;
            text-decoration: none;
            font-size: 14px;
        }
        
        .unsubscribe {
            font-size: 12px;
            color: #a0aec0;
            margin-top: 20px;
        }
        
        .unsubscribe a {
            color: #3AAA6D;
            text-decoration: none;
        }
        
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                width: 100%;
            }
            
            .email-header,
            .email-body,
            .email-footer {
                padding: 20px;
            }
            
            .logo-text {
                font-size: 24px;
            }
            
            .greeting {
                font-size: 20px;
            }
            
            .content {
                font-size: 14px;
            }
            
            .btn {
                display: block;
                width: 100%;
                text-align: center;
            }
            
            .otp-code {
                font-size: 24px;
                letter-spacing: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="logo">
                <h1 class="logo-text">Career Compass</h1>
                <p class="logo-tagline">Your Career Growth Partner</p>
            </div>
        </div>
        
        <div class="email-body">
            @yield('content')
        </div>
        
        <div class="email-footer">
            <p class="footer-text">
                This email was sent by Career Compass. We empower professionals to advance their careers and achieve their goals.
            </p>
            
            <div class="social-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact Support</a>
            </div>
            
            <div class="unsubscribe">
                <p>If you no longer wish to receive these emails, you can <a href="#">unsubscribe here</a>.</p>
                <p>&copy; {{ date('Y') }} Career Compass. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>