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

class SendPotentialLetter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 7200;
    protected $applicant_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($applicant_id)
    {
        $this->applicant_id = $applicant_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $applicant = Applicant::where('id',$this->applicant_id)->get();
        foreach ($applicant as $key => $value) {
            $input['email'] = $value->applicant_email;
            $input['name'] = $value->applicant_name;

            $data = [
                'receiver_name' => $input['name'],
            ];

            Mail::send('applicant.potential-student', $data, function ($message) use ($input) {
                $message->subject('IMPORTANT :: Your Study Application At INTEC Education College');
                $message->to(!empty($input['email']) ? $input['email'] : 'jane-doe@email.com');
            });
        }
    }
}
