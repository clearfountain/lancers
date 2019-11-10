<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\project;
use App\Invoice;

class TrackingCode extends Mailable
{
    use Queueable, SerializesModels;

    
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->from('noreply@lancers.app','Lancers')
        ->subject("Your tracking Code for ".$this->$invoice->estimate->project->title." project on lancers")
        ->view('emails.trackingcode');
    }
}
