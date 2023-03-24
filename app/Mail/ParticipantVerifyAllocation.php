<?php

namespace App\Mail;

use App\Models\Allocation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParticipantVerifyAllocation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $allocation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Allocation $allocation)
    {
        $this->allocation = $allocation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.participant-verify-allocation');
    }
}
