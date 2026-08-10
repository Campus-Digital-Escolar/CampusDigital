<?php

namespace App\Notifications;

use App\Models\InternalCommunication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InternalComunicationNotification extends Notification
{
    use Queueable;

    public function __construct(public InternalCommunication $comunication) {}

    public function via($notifiable): array
    {
        // Ejecuta canal de correo y dispara la notificación Push
        $this->sendFcmPush($notifiable);
        return ['mail'];
    }

    /**
     * Contenido del correo electrónico
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuevo Comunicado: ' . $this->comunication->title)
            ->greeting('Hola, ' . $notifiable->name)
            ->line('Se ha publicado un nuevo comunicado en la plataforma:')
            ->line('"' . $this->comunication->description . '"')
            ->action('Ver en el sistema', url('/comunicaciones'))
            ->salutation('Atentamente, Dirección Escolar');
    }

    /**
     * Enviar Pop-up Push mediante Firebase FCM API
     */
    private function sendFcmPush($notifiable)
    {
        if (!$notifiable->fcm_token) return;

        $serverKey = config('services.firebase.server_key');

        Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'to' => $notifiable->fcm_token,
            'notification' => [
                'title' => '📢 ' . $this->comunication->title,
                'body' => $this->comunication->description,
                'sound' => 'default'
            ],
            'data' => [
                'comunication_id' => (string)$this->comunication->id
            ]
        ]);
    }
}
