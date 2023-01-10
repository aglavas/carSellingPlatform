<?php

namespace App\Notifications;

use App\Enquiry;
use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionDeclined extends Notification
{
    use Queueable;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @var Enquiry
     */
    private $enquiry;

    /**
     * TransactionDeclined constructor.
     * @param Transaction $transaction
     * @param Enquiry $enquiry
     */
    public function __construct(Transaction $transaction, Enquiry $enquiry)
    {
        $this->transaction = $transaction;
        $this->enquiry = $enquiry;
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
            ->error()
            ->greeting('Hi!')
            ->line('The transaction for vehicle XYZ has been declined')
            ->action('View transaction', url(config('nova.url').route('transaction.show', ['enquiry' => $this->enquiry->id, 'transaction' => $this->transaction->id], false)))
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
