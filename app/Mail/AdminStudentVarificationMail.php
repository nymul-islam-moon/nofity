<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminStudentVarificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $verificationUrl;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Student $student, $verificationUrl, $password)
    {
        $this->student = $student;
        $this->verificationUrl = $verificationUrl;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.adminStudentVarification')
                    ->subject('Email Verification');
    }
}
