<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Answers extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private string $text)
    {
        //
    }

    public function build()
    {
        return $this->view('mail.quiz')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Nowe zapytanie z konfiguratora laphard')
            ->with(['text' => $this->text]);
    }
}
