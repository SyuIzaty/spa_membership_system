<?php

namespace App\Jobs;

use App\Applicant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Barryvdh\DomPDF\Facade as PDF;
use App\IntakeDetail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $applicants_id;

    public function __construct($applicants_id)
    {
        $applicants_id = $this->applicants_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $applicants_id = $this->applicants_id;
        $detail = Applicant::where('id',$applicants_id)->where('applicant_status','5A')->with(['offeredMajor','offeredProgramme'])->first();

        if($detail)
        {
            $intakes = IntakeDetail::where('status', '1')->where('intake_code', $detail->intake_id)->where('intake_programme', $detail->offered_programme)->first();

            $report = PDF::loadView('intake.pdf', compact('detail', 'intakes'));
            $data = [
                'receiver_name' => $detail->applicant_name,
                'details' => 'This offer letter is appended with this email. Please refer to the attachment for your registration instructions.',
            ];
            Mail::send('intake.offer-letter', $data, function ($message) use ($detail, $report) {
                $message->subject('Congratulations, ' . $detail->applicant_name);
                $message->to(!empty($detail->applicant_email) ? $detail->applicant_email : 'jane-doe@email.com');
                $message->attachData($report->output(), 'Offer_Letter_' . $detail->applicant_name . '.pdf');
                $file = AttachmentFile::where('batch_code',$detail['batch_code'])->get();
                foreach($file as $files){
                    $path = storage_path().'/app/batch/'.$files->file_name;
                    if(file_exists($path)){
                        $message->attach($path, [
                            'as' => $files->file_name,
                            'mime' => 'application/pdf',
                        ]);
                    }
                }
            });
        }
    }
}
