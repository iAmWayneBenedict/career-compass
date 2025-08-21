@extends('emails.layout')

@section('title', $notification['title'] ?? 'Notification')

@section('content')
    @if(isset($notification['greeting']))
        <h2 class="greeting">{{ $notification['greeting'] }}</h2>
    @endif
    
    <div class="content">
        @if(isset($notification['message']))
            <p>{{ $notification['message'] }}</p>
        @endif
        
        @if(isset($notification['description']))
            <p>{{ $notification['description'] }}</p>
        @endif
    </div>
    
    @if(isset($notification['highlight']))
        <div class="info-box">
            @if(is_array($notification['highlight']))
                <ul style="margin-left: 20px; color: #4a5568;">
                    @foreach($notification['highlight'] as $item)
                        <li style="margin-bottom: 8px;">{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p style="margin: 0; color: #4a5568;">{{ $notification['highlight'] }}</p>
            @endif
        </div>
    @endif
    
    @if(isset($notification['action']))
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $notification['action']['url'] }}" class="btn">
                {{ $notification['action']['text'] ?? 'Take Action' }}
            </a>
        </div>
    @endif
    
    @if(isset($notification['data_table']) && is_array($notification['data_table']))
        <div class="content">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    @foreach($notification['data_table'] as $key => $value)
                        <tr>
                            <td style="padding: 8px 12px; border-bottom: 1px solid #e2e8f0; font-weight: 600; color: #2d3748; width: 40%;">
                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                            </td>
                            <td style="padding: 8px 12px; border-bottom: 1px solid #e2e8f0; color: #4a5568;">
                                {{ is_array($value) ? implode(', ', $value) : $value }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
    
    @if(isset($notification['urgent']) && $notification['urgent'])
        <div class="info-box warning">
            <p style="margin: 0; color: #4a5568;"><strong>⚠️ Urgent:</strong> This requires immediate attention.</p>
        </div>
    @endif
    
    <div class="content">
        @if(isset($notification['footer_message']))
            <p>{{ $notification['footer_message'] }}</p>
        @endif
        
        <p style="margin-top: 25px;">
            @if(isset($notification['sender']))
                {{ $notification['sender'] }}<br>
            @endif
            <strong>{{ $notification['sender_title'] ?? 'The Career Compass Team' }}</strong>
        </p>
    </div>
@endsection