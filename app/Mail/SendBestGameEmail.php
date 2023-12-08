<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendBestGameEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $game;

    //Recebendo no construct o resultado do SQL e disponibilizando essa variável no template de HTML
    public function __construct($game)
    {
        $this->game = $game;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Veja o melhor jogo do dia :)',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.BestGameRatedTemplate',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}