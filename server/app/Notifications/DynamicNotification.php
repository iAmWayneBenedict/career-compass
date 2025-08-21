<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DynamicNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $notificationData;
    protected $channels;

    /**
     * Create a new notification instance.
     *
     * @param array $notificationData
     * @param array $channels
     */
    public function __construct(array $notificationData, array $channels = ['mail'])
    {
        $this->notificationData = $notificationData;
        $this->channels = $channels;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = $this->notificationData['subject'] ?? 
                  $this->notificationData['title'] ?? 
                  'Career Compass Notification';
        
        return (new MailMessage)
            ->subject($subject)
            ->view('emails.notification', [
                'user' => $notifiable,
                'notification' => $this->notificationData
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return array_merge([
            'type' => 'dynamic',
            'created_at' => now(),
        ], $this->notificationData);
    }
    
    /**
     * Create a success notification.
     *
     * @param string $title
     * @param string $message
     * @param array $additionalData
     * @return static
     */
    public static function success($title, $message, array $additionalData = [])
    {
        $data = array_merge([
            'type' => 'success',
            'icon' => '✅',
            'title' => $title,
            'greeting' => $title,
            'message' => $message,
        ], $additionalData);
        
        return new static($data);
    }
    
    /**
     * Create a warning notification.
     *
     * @param string $title
     * @param string $message
     * @param array $additionalData
     * @return static
     */
    public static function warning($title, $message, array $additionalData = [])
    {
        $data = array_merge([
            'type' => 'warning',
            'icon' => '⚠️',
            'title' => $title,
            'greeting' => $title,
            'message' => $message,
        ], $additionalData);
        
        return new static($data);
    }
    
    /**
     * Create an info notification.
     *
     * @param string $title
     * @param string $message
     * @param array $additionalData
     * @return static
     */
    public static function info($title, $message, array $additionalData = [])
    {
        $data = array_merge([
            'type' => 'info',
            'icon' => 'ℹ️',
            'title' => $title,
            'greeting' => $title,
            'message' => $message,
        ], $additionalData);
        
        return new static($data);
    }
    
    /**
     * Create an urgent notification.
     *
     * @param string $title
     * @param string $message
     * @param array $additionalData
     * @return static
     */
    public static function urgent($title, $message, array $additionalData = [])
    {
        $data = array_merge([
            'type' => 'warning',
            'icon' => '🚨',
            'title' => $title,
            'greeting' => $title,
            'message' => $message,
            'urgent' => true,
        ], $additionalData);
        
        return new static($data);
    }
}