<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserResetPasswordNotification extends Notification
{
    use Queueable;


    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
                    ->from('cryptoplushr@gmail.com')
                    ->subject('Resetovanje šifre korinika - Crypto Plus')
                    ->greeting('Poštovani,')
                    ->line('Poslali ste zahtev za resetovanje šifre, kliknite na dugme ispod')
                    ->action('Resetovanje šifre', url('/reset-password/' . $this->token))
                    ->line('Ukoliko niste vi poslali zahtev, molimo zanemarite ovaj mejl')
                    ->salutation('S poštovanjem, Vaš Crypto Plus');
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
