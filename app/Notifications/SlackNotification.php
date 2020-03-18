<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class SlackNotification extends Notification
{
    protected $content;
    protected $user_email;
    protected $payment_date;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct( $content, $user_email, $payment_date )
    {
        $this->content = $content;
        $this->user_email = $user_email;
        $this->payment_date = $payment_date;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    public function toSlack($notifiable)
    {
          return (new SlackMessage)->content(
$this->content.'
ユーザーメールアドレス：'.$this->user_email.'
決済日'.$this->payment_date

 );

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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
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
