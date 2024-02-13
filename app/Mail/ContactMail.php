<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Illuminate\Mail\Mailables\Address;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    private $_input;
    private $_no;

    /**
     * Create a new message instance.
     */
    public function __construct($input, $no)
    {
        //
        $this->_input = $input;
        $this->_no = $no;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            //from: new Address('example@example.com', 'Herotchi_CMSサポート'),
            subject: 'お問い合わせの登録が完了しました。',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            //html: 'contact.mail',
            text: 'contact.mail_text',
            with: [
                'input' => $this->_input,
                'no' => $this->_no,
            ],
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
