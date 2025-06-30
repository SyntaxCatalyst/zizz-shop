<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    // Properti untuk menampung data pesan dari form
    public array $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Mengatur subjek email dan dari siapa email ini dikirim
        return new Envelope(
            from: config('mail.from.address'),
            replyTo: $this->data['email'], // Memudahkan Anda me-reply langsung ke email pengunjung
            subject: 'Pesan Baru dari Form Kontak: ' . ($this->data['subject'] ?? 'Tanpa Subjek'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Menentukan file view mana yang akan digunakan sebagai template email
        return new Content(
            view: 'emails.contact-message',
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