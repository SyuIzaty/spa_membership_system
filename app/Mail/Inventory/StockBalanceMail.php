<?php

namespace App\Mail\Inventory;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockBalanceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;

    /**
     * Create a new message instance.
     *
     * @param array $admin
     * @return void
     */
    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin = $this->admin;
        $address = $admin['staff_email'];
        $name = $admin['staff_name'];

        $subject = 'Reminder: Stock Balance Low';

        $message = '

        <p>Assalamualaikum wbt. &amp; Greetings.</p>

        <p>Dear Sir/Madam/Mr/Ms.</p>

        <p>Please take a reminder that the stock under your responsibility has reached a low balance, with a quantity of less than 10 units.</p>

        <p>Please log in to <a href="https://ids.intec.edu.my/login">INTEC Digital System (IDS)</a> to review the current stock status.</p>

        <p>Thank you for your prompt attention to this matter.</p>

        <p style="font-size: 10px;"><em>This is an automated email. Please do not reply.</em></p>
        ';

        return $this->replyTo($address, $name)
                    ->subject($subject)
                    ->html($message);
    }
}
