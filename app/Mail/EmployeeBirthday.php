<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeBirthday extends Mailable
{
    use Queueable, SerializesModels;
    public $person_fullname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($person_fullname)
    {
        $this->person_fullname = $person_fullname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.employeeBirthday');
    }
}
