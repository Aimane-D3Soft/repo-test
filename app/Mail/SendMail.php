<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $mailData;
    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('aymane.chnaif@gmail.com', 'Aymane Chnaif'),
            subject: $this->mailData['sujet'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.send',
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
            // Attachment::fromStorageDisk('public', $this->mailData['attachment'])
            // ->as('attached.pdf')
            // ->withMime('application/pdf')
            // Attachment::fromStorageDisk('public', base64_decode(public_path('storage/files/my_file.pdf')))
            Attachment::fromData(fn () => base64_decode($this->mailData['attachment']) , 'Report.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
