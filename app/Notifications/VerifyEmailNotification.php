<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class VerifyEmailNotification extends Notification
{
    public function __construct() {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Generate signed URL for email verification
        $verificationUrl = env('FRONTEND_URL', 'localhost:5173') . "/" . "/verify-email?id={$notifiable->id}&hash=" . sha1($notifiable->getEmailForVerification());

        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->greeting('Hello ' . $notifiable->username ?? $notifiable->email . '!')
            ->line('Thank you for signing up. Please verify your email by clicking the button below:')
            ->action('Verify Email', $verificationUrl)
            ->line('If you did not create an account, no further action is required.');
    }
}
