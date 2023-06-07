<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ICTRental extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $detail = $this->data;
        $address = isset($detail->staff->staff_email) ? $detail->staff->staff_email : 'itadmin@intec.edu.my';
        $subject = 'ICT Rental Application: Reminder';
        $name = isset($detail->staff->staff_name) ? $detail->staff->staff_name : '';

        $message = '<p><b><u>ICT Rental Application: Reminder</u></b></p>
        <p>Assalamualaikum & Good Day, Sir/Madam/Mrs./Mr./Ms. '.$name.'</p>
        

        <p>Your ICT Equipment is overdue. Please return the equipment to the IT Department immediately. Thank you.</p>
        ';

        return $this->from('itadmin@intec.edu.my', 'IT INTEC')
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->html($message);
    }
}
