<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTPVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $otp;
    protected $expiryMinutes;
    protected $action;
    protected $purpose;
    protected $verificationUrl;
    protected $ipAddress;

    /**
     * Create a new notification instance.
     *
     * @param string $otp
     * @param int $expiryMinutes
     * @param string|null $action
     * @param string|null $purpose
     * @param string|null $verificationUrl
     * @param string|null $ipAddress
     */
    public function __construct(
        $otp, 
        $expiryMinutes = 10, 
        $action = null, 
        $purpose = null, 
        $verificationUrl = null,
        $ipAddress = null
    ) {
        $this->otp = $otp;
        $this->expiryMinutes = $expiryMinutes;
        $this->action = $action;
        $this->purpose = $purpose;
        $this->verificationUrl = $verificationUrl;
        $this->ipAddress = $ipAddress;
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
            ->subject('Your Verification Code - Career Compass')
            ->view('emails.otp-verification', [
                'user' => $notifiable,
                'otp' => $this->otp,
                'expiryMinutes' => $this->expiryMinutes,
                'action' => $this->action,
                'purpose' => $this->purpose,
                'verificationUrl' => $this->verificationUrl,
                'ipAddress' => $this->ipAddress
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
            'type' => 'otp_verification',
            'otp' => $this->otp,
            'action' => $this->action,
            'expires_at' => now()->addMinutes($this->expiryMinutes),
            'ip_address' => $this->ipAddress
        ];
    }
}