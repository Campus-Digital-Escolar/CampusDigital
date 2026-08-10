<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MarcadorActualizado implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // Propiedades públicas: Todo lo que sea público se enviará automáticamente a Vue
    public $partidoId;
    public $golesLocal;
    public $golesVisitante;

    public function __construct($partidoId, $golesLocal, $golesVisitante)
    {
        $this->partidoId = $partidoId;
        $this->golesLocal = $golesLocal;
        $this->golesVisitante = $golesVisitante;
    }

    /**
     * Define el nombre del canal.
     * Usamos Channel para canales públicos (cualquiera puede verlo sin iniciar sesión).
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('deportes.partido.' . $this->partidoId),
        ];
    }

    /**
     * Opcional: Nombre personalizado del evento que escuchará Echo en Vue
     */
    public function broadcastAs(): string
    {
        return 'GolAnotado';
    }
}
