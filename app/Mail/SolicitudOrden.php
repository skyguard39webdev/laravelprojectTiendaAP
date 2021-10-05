<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Carro;
use Illuminate\Support\Facades\Auth;

class SolicitudOrden extends Mailable
{
    use Queueable, SerializesModels;

    protected $carro;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($carro)
    {
        $this->carro = $carro;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.solicitud')->subject('Solicitud de compra de: ' . Auth::user()->name . ' Identificador ' . $this->carro[0]->id)->with('carro', $this->carro); //como pasar variables es con with()
    }
}
