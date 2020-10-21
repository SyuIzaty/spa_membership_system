<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\ApplicantStatus;
use App\IntakeDetail;
use Illuminate\Http\Request;
use App\Intakes;
use App\IntakeType;
use App\Programme;
use App\Major;
use App\Batch;
use App\Http\Requests\StoreIntakeRequest;
use App\Http\Requests\StoreIntakeDetailRequest;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\AttachmentFile;
use File;
use Response;

class IntakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intakeInfo = Intakes::all();
        $programme = Programme::all();
        return view('intake.index', compact('intakeInfo', 'programme'));
        // return view('intake.index', compact('intake'));
    }

    public function data_allintake()
    {
        $applicant = Applicant::pluck('intake_id')->all();
        $intaked = Intakes::whereNotIn('id',$applicant)->pluck('id')->all();

        $intakeInfo = Intakes::select('*');

        return datatables()::of($intakeInfo)
        ->addColumn('action', function ($intakeInfo) use ($intaked) {
            if(in_array($intakeInfo->id, $intaked)){
                return '<a href="/intake/'.$intakeInfo->id.'/edit" class="btn btn-sm btn-primary"> Edit</a>
                <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/intake/' . $intakeInfo->id . '"> Delete</button>'
            ;
            }else{
                return '<a href="/intake/'.$intakeInfo->id.'/edit" class="btn btn-sm btn-primary"> Edit</a>';
            }

        })

        ->make(true);
    }

    public function create()
    {
        return view('intake.create');
    }

    public function createType()
    {
        return view('intake.createType');
    }

    public function view()
    {
        return view('intake.createIntake');
    }

    public function store(Request $request)
    {
        Intakes::where('status', '1')->update(['status' => 0]);
        Intakes::create([
            'intake_code' => $request->intake_type_code,
            'intake_description' => $request->intake_type_description,
            'intake_app_open' => $request->intake_app_open,
            'intake_app_close' => $request->intake_app_close,
            'intake_check_open' => $request->intake_check_open,
            'intake_check_close' => $request->intake_check_close,
            'status' => '1'
        ]);

        return redirect()->route('intake.index')
            ->with('success', 'Intake created successfully');
    }

    public function data($id) //Fetch Batch
    {
        $intake_batch = IntakeDetail::pluck('batch_code')->all();
        $batch = Batch::Active()->whereNotIn('batch_code', $intake_batch)->where('programme_code',$id)->get();
        return response()->json($batch);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) // Display Intake & Intake Details
    {
        $intake = Intakes::find($id);
        $programme = Programme::all();
        $intake_type = IntakeType::all();

        $intake_details = IntakeDetail::where('intake_code', $id)->get();
        $intake_detail = $intake_details->load('programme', 'intakeType');

        $intake_batch = IntakeDetail::pluck('batch_code')->all();
        $batch = Batch::Active()->whereNotIn('batch_code', $intake_batch)->get();

        $applicant_intake = Applicant::where('intake_id',$id)->pluck('offered_programme')->all();
        $offer_intake = $intake_details->whereNotIn('intake_programme',$applicant_intake)->pluck('intake_programme')->all();

        return view('intake.edit', compact('intake', 'intake_detail', 'programme', 'intake_type', 'batch', 'offer_intake'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreIntakeRequest $request, $id) // Update Intake
    {
        Intakes::find($id)->update($request->all());

        return redirect()->route('intake.index')
            ->with('success', 'Intake updated successfully');
    }

    public function intakeInfo()
    {
        $intakeInfo = Intakes::all();
        return view('intake.info', compact('intakeInfo'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id) // Delete Intakes
    {
        $exist = Intakes::find($id);
        $exist->delete();
        return redirect()->route('intakes.index');
    }

    public function showProgramInfo($intake_code)
    {
        $intakedetail = IntakeDetail::where('intake_code', $intake_code)->get();
        $programme = Programme::all();
        $intake = Intakes::where('id', $intake_code)->get();
        return redirect()->back();
    }

    public function createProgramInfo(Request $request)
    {
        IntakeDetail::where('intake_programme', $request->intake_programme)->where('intake_code', $request->intake_code)->where('status', '1')->update(['status' => 0]);
        IntakeDetail::create($request->all());
        IntakeDetail::where('status', Null)->where('intake_programme', $request->intake_programme)->where('intake_code', $request->intake_code)->update(['status' => 1]);
        $this->uploadFile($request->file,$request->batch_code);
        return $this->showProgramInfo($request->intake_code);
    }

    public function deleteProgramInfo($id)
    {
        $exist = IntakeDetail::find($id);
        $exist->delete();
        return response()->json(['success', 'Successfully deleted!']);
    }

    // public function offer()
    // {
    //     $applicants = Applicantstatus::where('applicant_status', 'Selected')->with(['applicant', 'programme'])->get();
    //     foreach ($applicants as $apps) {
    //         $app = IntakeDetail::where('intake_code', $apps->applicant->intake_id)->where('intake_programme', $apps->applicant_programme)
    //             ->where('status', '1')->with(['intakes'])->get();
    //     }

    //     return view('intake.offer', compact('applicants'));
    // }

    public function letter(Request $request)
    {
        $details = Applicant::where('id',$request->applicant_id)->with(['offeredMajor','offeredProgramme'])->get();
        foreach($details as $detail){
            $intakes = IntakeDetail::where('intake_code', $detail->intake_id)->where('intake_programme',$detail->offered_programme)
                ->where('status','1')->with(['intakes'])->first();
        }

        $pdf = PDF::loadView('intake.pdf', compact('detail','intakes'));
        return $pdf->stream('Offer Letter_' . $request->applicant_name . '.pdf');
    }

    public function sendEmail(Request $request)
    {
        $detail = Applicant::where('id',$request->applicant_id)->with(['offeredMajor','offeredProgramme'])->first();
        $intakes = IntakeDetail::where('status', '1')->where('intake_code', $request->intake_id)->where('intake_programme', $detail->offered_programme)
            ->first();

        $report = PDF::loadView('intake.pdf', compact('detail', 'intakes'));
        $data = [
            'receiver_name' => $detail->applicant_name,
            'details' => 'This offer letter is appended with this email. Please refer to the attachment for your registration instructions.',
        ];

        Mail::send('intake.offer-letter', $data, function ($message) use ($detail, $report) {
            $message->subject('Congratulations, ' . $detail->applicant_name);
            $message->to(!empty($detail->applicant_email) ? $detail->applicant_email : 'jane-doe@email.com');
            $message->attachData($report->output(), 'Offer_Letter_' . $detail->applicant_name . '.pdf');
        });

        Applicant::where('id',$request->applicant_id)->update(['email_sent'=>'1']);

        return redirect()->back()->with('message', 'Email send and status updated');
    }


    public function updateProgramInfo(StoreIntakeDetailRequest $request)
    {
        IntakeDetail::find($request->id)->update($request->all());

        $this->uploadFile($request->file,$request->batch_code);

        return $this->showProgramInfo($request->intake_code);
    }

    public function uploadFile($file,$bc)
    {
        $path=storage_path()."/batch/";
        for($x = 0; $x < count($file) ; $x ++)
        {
            $extension = $file[$x]->getClientOriginalExtension();
            $originalName= $file[$x]->getClientOriginalName();
            $fileSize= $file[$x]->getSize();
            $fileName= $originalName;
            $file[$x]->storeAs('/batch', $fileName);
            AttachmentFile::create(
                [
                 'batch_code' => $bc,
                 'file_name' => $originalName,
                 'file_size' => $fileSize,
                 'web_path' => "app/batch/".$fileName,
                ]
            );
        }
    }

    public function deleteStorage($id)
    {
        $myfile =  AttachmentFile::where('id',$id)->select('web_path')->first();
        if($myfile)
        {
            $path = storage_path().'/'.$myfile->web_path;
            unlink($path);
            AttachmentFile::where('id',$id)->delete();
        }
    }

    public function storageFile($filename,$type)
    {
        $path = storage_path().'/'.'app'.'/batch/'.$filename;

        if($type == "Download")
        {
            if (file_exists($path)) {
                return Response::download($path);
            }
        }
        else
        {
            $file = File::get($path);
            $filetype = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $filetype);

            return $response;
        }

    }

    public function getIntakeFiles($batchCode)
    {
        $files = AttachmentFile::where('batch_code',$batchCode)->get();

        return response()->json(compact('files'));
    }
}
