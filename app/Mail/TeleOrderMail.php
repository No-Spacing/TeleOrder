<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;

class TeleOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf, $title;
    /**
     * Create a new message instance.
     */
    public function __construct($pdfData, $pdfTitle)
    {
        $this->pdf = $pdfData;
        $this->title = $pdfTitle;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@inmed.com.ph', 'No-Reply Inmed'),
            subject: 'TeleOrder Approved',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'Emails.teleorder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdf, $this->title.'.pdf')
            ->withMime('application/pdf'),
        ];
    }
}
