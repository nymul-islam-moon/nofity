<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $verificationUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student, $verificationUrl)
    {
        $this->student = $student;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    return $this->subject('Student Verification Mail')
                ->view('emails.studentVerification')
                ->with([
                    'student' => $this->student,
                    'verificationUrl' => $this->verificationUrl,
                ]);
    }
}
