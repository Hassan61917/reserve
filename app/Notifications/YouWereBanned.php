<?php

namespace App\Notifications;

use App\Models\Ban;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YouWereBanned extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Ban $ban
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "message" => $this->createMessage()
        ];
    }

    private function createMessage(): string
    {
        $result = "YOU HAVE BEEN BANNED ";
        $ban = $this->ban;
        $result .= " because not following our site rules ({$ban->reason}) ";
        if ($ban->term) {
            $result .= "you can continue you activity after {$ban->term} days";
        }
        return $result;
    }
}
