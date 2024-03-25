<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PharIo\Manifest\Url;

class ConfirmAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $contenido;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param mixed $contenido
     */
    public function __construct($contenido = null, $url)
    {
        $this->contenido = $contenido;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.confirm')
                    ->with(['contenido' => $this->contenido, 'url' => $this->url]); // Pasamos el contenido a la vista
    }
}

