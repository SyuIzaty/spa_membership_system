<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Applicant;
use App\IntakeDetail;
use App\AttachmentFile;
use File;
use Response;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;

class SendOfferLetter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    protected $applicants_id;
    public $timeout = 7200;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$applicants_id)
    {
        $this->details = $details;
        $this->applicants_id = $applicants_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $detail = Applicant::where('id',$this->applicants_id)->where('applicant_status','5A')->with(['offeredMajor','offeredProgramme'])->first();

        $intakes = IntakeDetail::where('status', '1')->where('intake_code', $detail->intake_offer)->where('intake_programme', $detail->offered_programme)->where('batch_code',$detail->batch_code)->first();

        $input['subject'] = $this->details['subject'];

        $report = PDF::loadView('intake.pdf', compact('detail', 'intakes'));
        $data = [
            'receiver_name' => $detail->applicant_name,
        ];

        Mail::send('intake.offer-letter', $data, function ($message) use ($detail,$report){
            $message->subject('IMPORTANT :: Result Announcement To Further Study At INTEC Education College');
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


        Applicant::where('id',$this->applicants_id)->update(['email_sent'=>'1', 'applicant_status'=>'5C']);

        IntakeDetail::where('intake_code',$detail->intake_id)->where('batch_code',$detail['batch_code'])->update(['intake_status'=>'Offered']);

    }
}
