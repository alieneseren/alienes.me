<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Yeni İletişim Mesajı - ' . $this->contact->subject)
            ->greeting('Merhaba ' . $notifiable->name . ',')
            ->line('Porfoliyo web sitenizden yeni bir mesaj geldi.')
            ->line('**Gönderici Adı:** ' . $this->contact->name)
            ->line('**Gönderici E-postası:** ' . $this->contact->email)
            ->line('**Konu:** ' . $this->contact->subject)
            ->line('**Mesaj:**')
            ->line($this->contact->message)
            ->action('Admin Panele Git', route('admin.dashboard'))
            ->line('Teşekkür ederim.');
    }
}
