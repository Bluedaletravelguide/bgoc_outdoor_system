<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailNotification extends Notification
{
    use Queueable;

    private $details;



//     @return void

    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
        $this->details=$details;
    }
    //
    // public function build()
    // {
    //     return $this->subject('New Task Assignment')
    //                 ->markdown('emails.task_assignment') // Using the Blade template
    //                 ->with('details', $this->details); // Passing data to the Blade template
    // }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->details['title'])
            ->view('emails.task_assignment', ['details' => $this->details]);
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
