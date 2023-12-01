<?php

namespace App\Mail\Stationery;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StationeryConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $manager;
    public $application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($manager, $application)
    {
        $this->manager = $manager;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $manager = $this->manager;

        $application = $this->application;

        $recipient_address = $manager['email'];

        $recipient_name = $manager['name'];

        $subject = 'Reminder: Pending Confirmation for I-Stationery Application';

        $message = '

        <p>Assalamualaikum wbt. &amp; Greetings.</p>

        <p>Dear Sir/Madam/Mr/Ms.</p>

        <p>This is a friendly reminder that the application (Application ID #'.$application['id'].') from '.$application->staff['staff_name'].' has not been confirmed yet, even after the latest reminder.

        Kindly send a reminder to the applicant again to confirm the collection promptly.</p>

        <p>Please log in to <a href="https://ids.intec.edu.my/login">INTEC Digital System (IDS)</a> to review the application and take further action.</p>

        <p>Thank you for your prompt attention to this matter.</p>

        <p style="font-size: 10px;"><em>This is an automated email. Please do not reply.</em></p>
        ';

        return $this->replyTo($recipient_address, $recipient_name)
                    ->subject($subject)
                    ->html($message);
     }
}
