<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioDTE extends Mailable
{
    use Queueable, SerializesModels;
    public $rutaArchivoAdjunto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rutaArchivoAdjunto)
    {
        $this->rutaArchivoAdjunto = $rutaArchivoAdjunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Prueba de correo')->view('emails.dte')->attach($this->rutaArchivoAdjunto.'.pdf');
    }
}
