<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEmployeeCredential extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Employee $employee,
        public string $password
    ) {}

    public function build()
    {
        return $this->subject('Welcome to Kodebyte - Your Account Access')
                    ->markdown('emails.new-employee-credential');
    }
}