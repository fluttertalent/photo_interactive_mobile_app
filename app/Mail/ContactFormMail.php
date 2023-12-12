<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;
    public $validatedData;

    /**
     * Create a new message instance.
     */

    public function __construct($validatedData)
    {
        //
        $this->validatedData = $validatedData;
    }

    /**
     * Get the message envelope.
     */

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->validatedData['subject'],
        );
    }

    /**
     * Get the message content definition.
     */

    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'contact',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->view('message')->with(['subject'=>$this->validatedData['subject'], 'name'=>$this->validatedData['name'], 'email'=>$this->validatedData['email'], 'messages'=>$this->validatedData['message']]);                    
    }
    
}
