<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Collaborator;

class NotifyCreator extends Mailable
{
    use Queueable, SerializesModels;

    public $collaborator;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collaborator $collaborator)
    {
        $this->collaborator =  $collaborator;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->from('mail@lancers.com')->view('emails.creator');
    }
}
