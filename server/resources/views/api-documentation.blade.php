<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Compass API Documentation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #3AAA6D, #2d8a54);
            color: white;
            padding: 40px 0;
            text-align: center;
            margin-bottom: 40px;
            border-radius: 12px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section h2 {
            color: #3AAA6D;
            font-size: 1.8rem;
            margin-bottom: 20px;
            border-bottom: 2px solid #3AAA6D;
            padding-bottom: 10px;
        }

        .section h3 {
            color: #2d8a54;
            font-size: 1.4rem;
            margin: 25px 0 15px 0;
        }

        .endpoint-group {
            margin-bottom: 30px;
        }

        .endpoint {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .endpoint-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .method {
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.9rem;
            margin-right: 15px;
            min-width: 60px;
            text-align: center;
        }

        .method.get { background: #d4edda; color: #155724; }
        .method.post { background: #d1ecf1; color: #0c5460; }
        .method.put { background: #fff3cd; color: #856404; }
        .method.delete { background: #f8d7da; color: #721c24; }

        .endpoint-url {
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 1rem;
            color: #495057;
            font-weight: 500;
        }

        .endpoint-description {
            color: #6c757d;
            margin-top: 8px;
            font-size: 0.95rem;
        }

        .base-url {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 1.1rem;
            margin-bottom: 20px;
            border-left: 4px solid #3AAA6D;
        }

        .note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }

        .note.warning {
            background: #f8d7da;
            border-color: #f5c6cb;
        }

        .note.info {
            background: #d1ecf1;
            border-color: #bee5eb;
        }

        .note h4 {
            margin-bottom: 8px;
            color: #856404;
        }

        .note.warning h4 {
            color: #721c24;
        }

        .note.info h4 {
            color: #0c5460;
        }

        ul {
            margin-left: 20px;
            margin-bottom: 15px;
        }

        li {
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .email-template-link {
            text-decoration: none;
            color: #3AAA6D;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .email-template-link:hover {
            color: #2d8a54;
            text-decoration: underline;
        }

        .email-template-link code {
            background: #f8f9fa;
            padding: 3px 8px;
            border-radius: 4px;
            font-family: 'Monaco', 'Consolas', monospace;
            transition: all 0.2s ease;
        }

        .email-template-link:hover code {
            background: #e9ecef;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .preview-hint {
            color: #6c757d;
            font-size: 0.85em;
            margin-left: 8px;
            font-style: italic;
        }

        code {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 0.9rem;
        }

        .footer {
            text-align: center;
            padding: 30px 0;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .section {
                padding: 20px;
            }

            .endpoint-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .method {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $documentation['app_name'] }} API</h1>
            <p>Complete API Documentation & Testing Interface</p>
        </div>

        <div class="section">
            <h2>Base URL</h2>
            <div class="base-url">
                {{ $documentation['base_url'] }}
            </div>
            <p>All API endpoints are prefixed with <code>/api/{{ $documentation['api_version'] }}</code> for versioning.</p>
        </div>

        <div class="section">
            <h2>{{ $documentation['categories']['authentication']['name'] }}</h2>
            <p>This API uses Laravel Sanctum for authentication. For SPA applications, use session-based authentication with CSRF protection.</p>
            
            <div class="endpoint-group">
                <h3>{{ $documentation['categories']['authentication']['name'] }} Endpoints</h3>
                <p>{{ $documentation['categories']['authentication']['description'] }}</p>
                
                @foreach($documentation['categories']['authentication']['endpoints'] as $endpoint)
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method {{ strtolower($endpoint['method']) }}">{{ $endpoint['method'] }}</span>
                        <span class="endpoint-url">{{ $documentation['base_url'] }}{{ $documentation['categories']['authentication']['base_path'] }}{{ $endpoint['path'] }}</span>
                    </div>
                    <div class="endpoint-description">
                        {{ $endpoint['description'] }}
                        @if($endpoint['authenticated'])
                            <span style="color: #856404; font-weight: 500;"> (Requires Authentication)</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="section">
            <h2>{{ $documentation['categories']['user_management']['name'] }}</h2>
            <p>{{ $documentation['categories']['user_management']['description'] }}</p>
            
            <div class="endpoint-group">
                <h3>{{ $documentation['categories']['user_management']['name'] }} Endpoints</h3>
                
                @foreach($documentation['categories']['user_management']['endpoints'] as $endpoint)
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method {{ strtolower($endpoint['method']) }}">{{ $endpoint['method'] }}</span>
                        <span class="endpoint-url">{{ $documentation['base_url'] }}{{ $documentation['categories']['user_management']['base_path'] }}{{ $endpoint['path'] }}</span>
                    </div>
                    <div class="endpoint-description">
                        {{ $endpoint['description'] }}
                        @if($endpoint['authenticated'])
                            <span style="color: #856404; font-weight: 500;"> (Requires Authentication)</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="section">
            <h2>{{ $documentation['categories']['email_testing']['name'] }}</h2>
            <div class="note warning">
                <h4>Development Only</h4>
                <p>{{ $documentation['categories']['email_testing']['description'] }}</p>
            </div>
            
            <div class="endpoint-group">
                <h3>{{ $documentation['categories']['email_testing']['name'] }} Endpoints</h3>
                
                @foreach($documentation['categories']['email_testing']['endpoints'] as $endpoint)
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method {{ strtolower($endpoint['method']) }}">{{ $endpoint['method'] }}</span>
                        <span class="endpoint-url">{{ $documentation['base_url'] }}{{ $documentation['categories']['email_testing']['base_path'] }}{{ $endpoint['path'] }}</span>
                    </div>
                    <div class="endpoint-description">
                        {{ $endpoint['description'] }}
                        @if($endpoint['authenticated'])
                            <span style="color: #856404; font-weight: 500;"> (Requires Authentication)</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="note info">
                <h4>Basic Email Templates</h4>
                <p>Our email templates follow a clean, simplified design with center-aligned content and card-style layout featuring green accents.</p>
                <ul>
                    @foreach($documentation['email_templates'] as $template)
                        @if($template['category'] === 'basic')
                        <li>
                            <a href="/test-emails/preview/{{ $template['type'] }}" target="_blank" class="email-template-link">
                                <code>{{ $template['type'] }}</code>
                            </a> 
                            - {{ $template['description'] }} <em>(Simplified design with essential content only)</em>
                            <span class="preview-hint">(Click to preview)</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <div class="note info">
                <h4>Dynamic Notification Templates</h4>
                <p>The notification template supports various use cases with a clean, focused design that removes unnecessary complexity:</p>
                <ul>
                    @foreach($documentation['email_templates'] as $template)
                        @if($template['category'] === 'notification')
                        <li>
                            <a href="/test-emails/preview/{{ $template['type'] }}" target="_blank" class="email-template-link">
                                <code>{{ $template['type'] }}</code>
                            </a> 
                            - {{ $template['description'] }} <em>(Streamlined content)</em>
                            <span class="preview-hint">(Click to preview)</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
                <p><strong>Note:</strong> All notification templates use the same base template (<code>notification.blade.php</code>) with different parameters. Templates are designed with simplified content and center-aligned layout.</p>
            </div>
        </div>

        <div class="section">
            <h2>{{ $documentation['categories']['api_documentation']['name'] }}</h2>
            <p>{{ $documentation['categories']['api_documentation']['description'] }}</p>
            
            <div class="endpoint-group">
                <h3>{{ $documentation['categories']['api_documentation']['name'] }} Endpoints</h3>
                
                @foreach($documentation['categories']['api_documentation']['endpoints'] as $endpoint)
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method {{ strtolower($endpoint['method']) }}">{{ $endpoint['method'] }}</span>
                        <span class="endpoint-url">{{ $documentation['base_url'] }}{{ $documentation['categories']['api_documentation']['base_path'] }}{{ $endpoint['path'] }}</span>
                    </div>
                    <div class="endpoint-description">
                        {{ $endpoint['description'] }}
                        @if($endpoint['authenticated'])
                            <span style="color: #856404; font-weight: 500;"> (Requires Authentication)</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="section">
            <h2>Email Template Design</h2>
            <p>All email templates have been redesigned with a focus on simplicity and user experience:</p>
            
            <div class="note info">
                <h4>Design Features</h4>
                <ul>
                    <li><strong>Card-style Layout:</strong> Clean white background with subtle green borders (2-3px) at top and bottom</li>
                    <li><strong>Center Alignment:</strong> All content is center-aligned for better visual balance</li>
                    <li><strong>Simplified Content:</strong> Removed verbose explanations and unnecessary details</li>
                    <li><strong>Essential Information Only:</strong> Focus on core message and required actions</li>
                    <li><strong>Consistent Branding:</strong> Career Compass green accent color throughout</li>
                    <li><strong>Mobile Responsive:</strong> Optimized for all device sizes</li>
                </ul>
            </div>
        </div>

        <div class="section">
            <h2>Email Template Parameters</h2>
            <p>The notification template supports the following parameters for customization. All parameters are designed to work with the simplified, center-aligned layout:</p>
            
            <div class="endpoint-group">
                <h3>Notification Template Parameters</h3>
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">title</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> string | <strong>Required:</strong> Yes<br>
                        Main heading of the notification email
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">greeting</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> string | <strong>Required:</strong> No<br>
                        Personal greeting (defaults to "Hello!")
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">message</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> string | <strong>Required:</strong> Yes<br>
                        Main message content of the notification
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">description</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> string | <strong>Required:</strong> No<br>
                        Additional descriptive text below the main message
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">highlight</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> string | <strong>Required:</strong> No<br>
                        Important information displayed in a highlighted box
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">action</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> array | <strong>Required:</strong> No<br>
                        Action button with 'text' and 'url' keys
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">data_table</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> array | <strong>Required:</strong> No<br>
                        Structured data displayed as a table with key-value pairs
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">urgent</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> boolean | <strong>Required:</strong> No<br>
                        Applies urgent styling with red accents and priority indicators
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">footer_message</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> string | <strong>Required:</strong> No<br>
                        Custom footer message (defaults to standard footer)
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">sender</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> string | <strong>Required:</strong> No<br>
                        Custom sender name (defaults to app name)
                    </div>
                </div>
                
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method get">PARAM</span>
                        <span class="endpoint-url">sender_title</span>
                    </div>
                    <div class="endpoint-description">
                        <strong>Type:</strong> string | <strong>Required:</strong> No<br>
                        Sender's title or role (e.g., "Security Team", "HR Department")
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Response Formats</h2>
            <p>All API responses follow a consistent JSON structure for better predictability and error handling.</p>
            
            @foreach($documentation['response_formats'] as $format)
            <div class="response-example">
                <h3>{{ $format['name'] }}</h3>
                <pre><code>{{ json_encode($format['example'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
            </div>
            @endforeach
        </div>

        <div class="section">
            <h2>Authentication Requirements</h2>
            <p>This API uses Laravel Sanctum for authentication with the following requirements:</p>
            
            <ul>
                @foreach($documentation['authentication_info'] as $info)
                <li><strong>{{ $info['title'] }}:</strong> {{ $info['description'] }}</li>
                @endforeach
            </ul>
            
            <div class="note warning">
                <h4>Important Security Notes</h4>
                <ul>
                    @foreach($documentation['security_notes'] as $note)
                    <li>{{ $note }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Career Compass. Built with Laravel & Vue.js</p>
            <p>API Version: v1 | Last Updated: {{ date('F j, Y') }}</p>
        </div>
    </div>
</body>
</html>