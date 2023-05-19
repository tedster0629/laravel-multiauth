<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;
    public $email;

    /**
     * Create a new notification instance.
     *
     * @param $token
     * @param null $email
     */
    public function __construct($token, $email = null)
    {
        $this->token = $token;
        $this->email = $email;
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
        // Currently, In our action method:
        // The "admin.password.reset" route is the unique route that receiver will receive through email.
        // This receive email will contains user email & token.
        // route('admin.password.reset', $this->token)) translates into http://localhost/admin/password/reset/033860c11059dcc4c
       //  route('admin.password.reset', [$this->token, 'email' => $this->email]) translates into http://localhost/admin/password/reset/033860c11059dcc4c?email=h@h.com
        return (new MailMessage)
                    ->line('You request to reset your password.')
                    ->action('Reset Password Action', route('admin.password.reset', [$this->token, 'email' => $this->email]))
                    ->line('Thank you for using our application!');
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
            //
        ];
    }
}
