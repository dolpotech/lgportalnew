<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInformationCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email_templates.information_created')
            ->with([
                'title' => $this->title,
                'description' => $this->description
            ]);
    }
}
