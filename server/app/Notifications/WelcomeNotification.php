<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $dashboardUrl;

    /**
     * Create a new notification instance.
     *
     * @param string|null $dashboardUrl
     */
    public function __construct($dashboardUrl = null)
    {
        $this->dashboardUrl = $dashboardUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Career Compass!')
            ->view('emails.welcome', [
                'user' => $notifiable,
                'dashboardUrl' => $this->dashboardUrl ?? config('app.frontend_url') . '/dashboard'
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
        return [
            'type' => 'welcome',
            'message' => 'Welcome to Career Compass! Your account has been created successfully.',
            'dashboard_url' => $this->dashboardUrl
        ];
    }
}