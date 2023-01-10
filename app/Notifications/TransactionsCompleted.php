<?php

namespace App\Notifications;

use App\Enquiry;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionsCompleted extends Notification
{
    use Queueable;

    /**
     * @var integer
     */
    private $count;

    /**
     * @var User
     */
    private $user;


    public function __construct(int $count)
    {
        $this->count = $count;
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
                    ->greeting('Hi!')
                    ->line("You have a $this->count resolved transactions.")
                    ->action('View Transactions', url(config('nova.url').route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders', 'status' => ['approved']], false)))
            ;
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
