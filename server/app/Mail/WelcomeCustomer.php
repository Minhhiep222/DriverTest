<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeCustomer extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    protected $showroom;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $showroom)
    {
        $this->data = $data;
        $this->showroom = $showroom;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome Customer',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'welcome-customer',
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

    public function build()
    {
        return $this->view('welcome')
                    ->subject('Chào mừng bạn đến với website của chúng tôi')
                    ->with([
                        'data' => $this->data,
                        'showroom' => $this->showroom
                    ]);
    }
}