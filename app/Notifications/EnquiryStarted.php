<?php

namespace App\Notifications;

use App\Enquiry;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnquiryStarted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Enquiry
     */
    private $enquiry;

    /**
     * @var User
     */
    private $user;

    /**
     * EnquiryStarted constructor.
     * @param Enquiry $enquiry
     * @param User $user
     */
    public function __construct(Enquiry $enquiry, User $user)
    {
        $this->enquiry = $enquiry;
        $this->user = $user;
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
                    ->line('You have a new enquiry')
                    ->action('View Enquiry', url(config('nova.url').route('enquiry.list', ['userType' => 'seller', 'listType' => 'enquiries', 'enquiry_id' => [$this->enquiry->id]], false)))
                    ->line('Please contact the buyer to clear up all the details.')
                    ->line( "{$this->user->name}  <{$this->user->email}>, Telephone: {$this->user->mobile}")
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
