<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Applicant;
use Carbon\Carbon;
use Mail;

class SendIncompleteApplication implements ShouldQueue
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
        $applicant = Applicant::where('applicant_status','00')->where('sponsor_code','PRIVATE')->get();
        $input['subject'] = $this->details['subject'];

        foreach ($applicant as $key => $value) {
            $input['email'] = $value->applicant_email;
            $input['name'] = $value->applicant_name;
            $input['applicant_id'] = $value->id;

            $data = [
                'receiver_name' => $input['name'],
            ];

            Mail::send('applicant.first-reminder', $data, function ($message) use ($input) {
                $message->subject('IMPORTANT :: Notification to Complete your Study Application at INTEC Education College');
                $message->to(!empty($input['email']) ? $input['email'] : 'jane-doe@email.com');
            });
        }
    }
}
