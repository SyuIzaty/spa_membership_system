<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Applicant;
use Mail;

class SendBulkQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    public $timeout = 7200;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $applicant = Applicant::where('sponsor_code','!=','Private')->where('email_jpa',NULL)->where('applicant_status','2')->get();
        $input['subject'] = $this->details['subject'];

        foreach ($applicant as $key => $value) {
            $input['email'] = $value->applicant_email;
            $input['name'] = $value->applicant_name;
            $input['applicant_id'] = $value->id;

            // Mail::send('mails.email', [], function($message) use($input){
            //     $message->to($input['email'], $input['name'])
            //         ->subject($input['subject']);
            // });

            $data = [
                'receiver_name' => $input['name'],
                'details' => 'Please complete your Application Form',
            ];

            Mail::send('applicant.first-reminder', $data, function ($message) use ($input) {
                $message->subject('Dear, ' . $input['name']);
                $message->to(!empty($input['email']) ? $input['email'] : 'jane-doe@email.com');
            });

            Applicant::where('id',$input['applicant_id'])->update(['email_jpa'=>'1']);
        }
    }
}
