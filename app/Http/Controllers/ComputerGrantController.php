<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DateTime;
use App\Staff;
use App\ComputerGrant;
use App\ComputerGrantPurchaseProof;
use App\ComputerGrantStatus;
use App\ComputerGrantType;
use App\ComputerGrantFile;
use App\ComputerGrantLog;
use App\ComputerGrantQuota;
use App\ComputerGrantFAQ;
use Carbon\Carbon;
use File;
use Response;



class ComputerGrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_details = Staff::where('staff_id',$user->id)->first();

        $ticket = Carbon::now()->format('dmY') . str_pad($user->id, STR_PAD_LEFT);

        $newApplication = ComputerGrant::where('staff_id', Auth::user()->id)->where('active', 'Y')->first();

        $quota = ComputerGrantQuota::where('active', 'Y')->first();

        $getdate = $quota->effective_date;
        $explodedate = explode(' - ', $getdate);
        $start_date = Carbon::parse($explodedate[0])->format('Y-m-d');
        $end_date = Carbon::parse($explodedate[1])->format('Y-m-d');

        $totalApplication = ComputerGrant::whereBetween('created_at', [$start_date, $end_date])->where('deleted_by', NULL)->count();

        $getData = ComputerGrant::with('getQuota')->where('staff_id', Auth::user()->id)->where('active', 'N', NULL)->get();

        $dateNow = now()->format('Y-m-d H:i:s');

        return view('computer-grant.grant-form', compact('user','user_details','ticket','newApplication','quota','start_date','end_date','totalApplication','quota','getData','dateNow'));
    }

    public function grantList()
    {
        return view('computer-grant.grant-list');
    }

    public function applicationDetail($id)
    {
        $user = Auth::user();
        $user_details = Staff::where('staff_id',$user->id)->first();

        $activeData = ComputerGrant::with(['getStatus','getType','staff'])->where('id',$id)->first();

        $deviceType = ComputerGrantType::all();

        $proof = ComputerGrantPurchaseProof::where('permohonan_id', $id)->get();

        $verified_doc = ComputerGrantFile::where('permohonan_id', $id)->where('user', 'ADM')->get();

        $agreement_doc = ComputerGrantFile::where('permohonan_id', $id)->where('user', 'APC')->get();

        return view('computer-grant.application-detail', compact('user','user_details','activeData','deviceType','proof','verified_doc','agreement_doc'));
    }

    public function datalist()
    {
        $quota = ComputerGrantQuota::where('active', 'Y')->first();

        $data = ComputerGrant::with(['getStatus','getType','staff'])->where('staff_id', Auth::user()->id)->select('cgm_permohonan.*');

        return datatables()::of($data)

            ->addColumn('details',function($data)
            {
                return '<div>' .($data->staff->staff_dept). '/'
                .($data->staff->staff_position).'</div>';
            })

            ->editColumn('status',function($data)
            {
                return $data->getStatus->description ?? '';
            })

            ->editColumn('price',function($data)
            {
                return $data->price ?? 'N/A';
            })

            ->addColumn('amount',function($data)
            {
                return '<div> RM' .$data->grant_amount. '/ 60 months </div>';
            })

            ->addColumn('type',function($data)
            {

                return isset($data->type) ? $data->getType->first()->description : 'N/A';
            })

            ->addColumn('purchase',function($data)
            {
                if (($data->brand) && ($data->model) && ($data->serial_no) != NULL)
                {
                    return '<div>' .($data->brand). '/ '
                    .($data->model). '/ ' .($data->serial_no). '</div>';
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('expiryDate',function($data)
            {

                if ($data->approved_at != NULL)
                {
                    $datetime = new DateTime($data->approved_at);
                    $getExpiryDate = date_add($datetime, date_interval_create_from_date_string($data->getQuota->duration. 'year'));
                    $expiryDate = $getExpiryDate->format('d-m-Y');

                    return $expiryDate;
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('remainingPeriod',function($data)
            {
                if ($data->status != 1)
                {
                    $datetime = new DateTime($data->approved_at);
                    $getExpiryDate = date_add($datetime, date_interval_create_from_date_string($data->getQuota->duration. 'year'));
                    $expiryDate = $getExpiryDate->format('Y-m-d H:i:s');

                    $dateNow = new DateTime('now');
                    $date = new DateTime($expiryDate);

                    $interval = $dateNow->diff($date);
                    $days = $interval->format('%a');

                    return '<div>' .$days. ' days </div>';
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('penalty',function($data)
            {
                if ($data->status == 2 || $data->status == 3 || $data->status == 4 || $data->status == 5 || $data->status == 6)
                {
                    $datetime = new DateTime($data->approved_at);
                    $getExpiryDate = date_add($datetime, date_interval_create_from_date_string($data->getQuota->duration. 'year'));
                    $expiry = $getExpiryDate->format('Y-m-d H:i:s');

                    $dateNow = strtotime(Carbon::now());
                    $expiryDate = strtotime($expiry);

                    $yearNow = date('Y', $dateNow);
                    $yearExpire = date('Y', $expiryDate);

                    $year = $yearExpire - $yearNow;

                    $penalty = $year * 300;

                    return '<div> RM ' .$penalty. '</div>';
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('action', function ($data) {
                return '<a href="/application-detail/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
            })

            ->addColumn('log', function ($data) {
                return '<a href="/log/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-list-alt"></i></a>';
            })

            ->rawColumns(['details','type','amount','purchase','action','remainingPeriod', 'penalty','log'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $quota = ComputerGrantQuota::where('active', 'Y')->first();

        $validated = $request->validate([
            'hp_no'           => 'required|regex:/(01)[0-8]{8}/',
            'office_no'       => 'nullable|regex:/(03)[0-8]{8}/'
        ], [
            'hp_no.regex'     => 'The phone number does not match the format',

            'office_no.regex' => 'The phone number does not match the format',
        ]);

        $user = Auth::user();
        $user_details = Staff::where('staff_id',$user->id)->first();

        $dateNow = new DateTime('now');
        $ticket = $dateNow->format('dmY') . str_pad($user->id, STR_PAD_LEFT);

        $newApplication               = new ComputerGrant();
        $newApplication->ticket_no    = $ticket;
        $newApplication->staff_id     = $user->id;
        $newApplication->hp_no        = $request->hp_no;
        $newApplication->office_no    = $request->office_no;
        $newApplication->status       = '1';
        $newApplication->grant_amount = '1500.00';
        $newApplication->active       = 'Y';
        $newApplication->quota        = $quota->id;
        $newApplication->created_by   = Auth::user()->id;
        $newApplication->updated_by   = Auth::user()->id;
        $newApplication->save();

        ComputerGrantLog::create([
            'permohonan_id'  => $newApplication->id,
            'activity'  => 'Apply new grant application',
            'created_by' => Auth::user()->id
        ]);

        return redirect('application-detail/'.$newApplication->id);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'price'           => 'required|numeric',
        ], [
            'price.numeric'     => 'The price must be numeric only',
        ]);

        $updateApplication = ComputerGrant::where('id', $request->id)->first();
        $updateApplication->update([
            'type'      =>$request->type,
            'serial_no' =>$request->serial_no,
            'brand'     =>$request->brand,
            'model'     =>$request->model,
            'price'     =>$request->price,
            'status'    =>'3'
        ]);

        $receipt = $request->file('receipt');
        $paths = storage_path()."/computerGrant/";

        $image = $request->file('upload_image');
        $paths = storage_path()."/computerGrant/";

        $fileSizes = $receipt->getSize();
        $fileNames = $request->id."_Receipt_".date('d-m-Y_hia');
        $receipt->storeAs('/computerGrant', $fileNames);
        ComputerGrantPurchaseProof::create([
            'permohonan_id'  => $request->id,
            'type'  => '1', //Receipt
            'upload' => $fileNames,
            'web_path'  => "app/computerGrant/".$fileNames,
            'created_by' => Auth::user()->id
        ]);

        $fileSizes = $image->getSize();
        $fileNames = $request->id."_Device Image_".date('d-m-Y_hia');
        $image->storeAs('/computerGrant', $fileNames);
        ComputerGrantPurchaseProof::create([
            'permohonan_id'  => $request->id,
            'type'  => '2', //Device image
            'upload' => $fileNames,
            'web_path'  => "app/computerGrant/".$fileNames,
            'created_by' => Auth::user()->id
        ]);

        ComputerGrantLog::create([
            'permohonan_id'  => $request->id,
            'activity'  => 'Upload purchase proof',
            'created_by' => Auth::user()->id
        ]);


        return redirect('application-detail/'.$request->id);
    }

    //Start Admin
    
    public function allGrantList($id) 
    {
        $data = ComputerGrantStatus::where('id', $id)->first();
        return view('computer-grant.all-grant-list', compact('data','id'));
    }

    public function allDatalists($id)
    {
        $data = ComputerGrant::where('status',$id)->get();

        return datatables()::of($data)

            ->addColumn('details',function($data)
            {
                return '<div>' .($data->staff->staff_dept). '/'
                .($data->staff->staff_position).'</div>';
            })

            ->editColumn('status',function($data)
            {
                return $data->getStatus->description ?? '';
            })

            ->editColumn('price',function($data)
            {
                return $data->price ?? 'N/A';
            })

            ->addColumn('amount',function($data)
            {
                return '<div> RM' .$data->grant_amount. '/ 60 months </div>';
            })

            ->addColumn('type',function($data)
            {

                return isset($data->type) ? $data->getType->first()->description : 'N/A';
            })

            ->addColumn('purchase',function($data)
            {
                if (($data->brand) && ($data->model) && ($data->serial_no) != NULL)
                {
                    return '<div>' .($data->brand). '/ '
                    .($data->model). '/ ' .($data->serial_no). '</div>';
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('expiryDate',function($data)
            {

                if ($data->approved_at != NULL)
                {
                    $datetime = new DateTime($data->approved_at);
                    $getExpiryDate = date_add($datetime, date_interval_create_from_date_string($data->getQuota->duration. 'year'));
                    $expiryDate = $getExpiryDate->format('d-m-Y');

                    return $expiryDate;
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('remainingPeriod',function($data)
            {
                if ($data->status != 1)
                {
                    $datetime = new DateTime($data->approved_at);
                    $getExpiryDate = date_add($datetime, date_interval_create_from_date_string($data->getQuota->duration. 'year'));
                    $expiryDate = $getExpiryDate->format('Y-m-d H:i:s');

                    $dateNow = new DateTime('now');
                    $date = new DateTime($expiryDate);

                    $interval = $dateNow->diff($date);
                    $days = $interval->format('%a');

                    return '<div>' .$days. ' days </div>';
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('penalty',function($data)
            {
                if ($data->status == 2 || $data->status == 3 || $data->status == 4 || $data->status == 5 || $data->status == 6)
                {
                    $datetime = new DateTime($data->approved_at);
                    $getExpiryDate = date_add($datetime, date_interval_create_from_date_string($data->getQuota->duration. 'year'));
                    $expiry = $getExpiryDate->format('Y-m-d H:i:s');

                    $dateNow = strtotime(Carbon::now());
                    $expiryDate = strtotime($expiry);

                    $yearNow = date('Y', $dateNow);
                    $yearExpire = date('Y', $expiryDate);

                    $year = $yearExpire - $yearNow;

                    $penalty = $year * 300;

                    return '<div> RM ' .$penalty. '</div>';
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('action', function ($data) {

                if ($data->status == 6)
                {
                    return '<button class="btn btn-sm btn-danger btn-delete" data-remote="/verifyCancellation/' . $data->id . '"><i class="fal fa-exclamation"></i></button>';
                }

                else
                {
                    return '<a href="/view-application-detail/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
                }
            })

            ->addColumn('log', function ($data) {
                return '<a href="/log/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-list-alt"></i></a>';
            })

            ->rawColumns(['details','type','amount','purchase','action','remainingPeriod', 'penalty','log'])
            ->make(true);
    }

    public function viewApplicationDetail($id)
    {
        $activeData = ComputerGrant::with(['getStatus','getType','staff'])->where('id',$id)->first();

        $user_details = Staff::where('staff_id',$activeData->staff_id)->first();

        $deviceType = ComputerGrantType::all();

        $status = ComputerGrantStatus::all();

        $verified_doc = ComputerGrantFile::where('permohonan_id', $id)->where('user', 'ADM')->get();

        $agreement_doc = ComputerGrantFile::where('permohonan_id', $id)->where('user', 'APC')->get();

        $proof = ComputerGrantPurchaseProof::where('permohonan_id', $id)->get();

        return view('computer-grant.view-application-detail', compact('user_details','activeData','deviceType','proof','verified_doc', 'agreement_doc'));

    }

        public function verifyApplication(Request $request)
    {
        $updateApplication = ComputerGrant::where('id', $request->id)->first();
        $updateApplication->update([
            'status'      => '2',
            'active'      => 'N',
            'approved_by' => Auth::user()->id,
            'updated_by'  => Auth::user()->id,
            'approved_at' => Carbon::now()->toDateTimeString()
        ]);

        $image = $request->file('upload_image');
        $paths = storage_path()."/computerGrantFile/";

        $timestamp = Carbon::now();

      
        $fileSizes = $image->getSize();
        $fileNames = $request->id."_Application Form_".date('d-m-Y_hia');
        $image->storeAs('/computerGrantFile', $fileNames);
        ComputerGrantFile::create([
            'permohonan_id'  => $request->id,
            'user'           => 'ADM', //for Admin
            'upload'         => $fileNames,
            'web_path'       => "app/computerGrantFile/".$fileNames,
            'created_by'     => Auth::user()->id
        ]);
        
    
        ComputerGrantLog::create([
            'permohonan_id'  => $request->id,
            'activity'  => 'Approve application',
            'created_by' => Auth::user()->id
        ]);


        return redirect('view-application-detail/'.$request->id);
    }

    public function verifyPurchase(Request $request)
    {
        $updateApplication = ComputerGrant::where('id', $request->id)->first();
        $updateApplication->update([
            'status'     =>'4',
            'updated_by' => Auth::user()->id
        ]);

        ComputerGrantLog::create([
            'permohonan_id'  => $request->id,
            'activity'  => 'Approve purchase',
            'created_by' => Auth::user()->id
        ]);

        return redirect('view-application-detail/'.$request->id);
    }

    public function rejectPurchase(Request $request)
    {
        $updateApplication = ComputerGrant::where('id', $request->id)->first();
        $updateApplication->update([
            'type'      => null,
            'serial_no' => null,
            'brand'     => null,
            'model'     => null,
            'price'     => null,
            'status'     =>'2',
            'updated_by' => Auth::user()->id
        ]);

        $exist = ComputerGrantPurchaseProof::where('permohonan_id',$request->id)->get();

        foreach ($exist as $e)
        {
            $e->delete();
            $e->update(['deleted_by' => Auth::user()->id]);
        }

        ComputerGrantLog::create([
            'permohonan_id'  => $request->id,
            'activity'  => 'Reject purchase',
            'created_by' => Auth::user()->id
        ]);

        return response() ->json(['success' => 'Rejected!']);
    }


    public function verifyReimbursement(Request $request)
    {
        $updateApplication = ComputerGrant::where('id', $request->id)->first();
        $updateApplication->update([
            'status'     =>'6',
            'updated_by' => Auth::user()->id
        ]);

        ComputerGrantLog::create([
            'permohonan_id'  => $request->id,
            'activity'  => 'Completed reimbursement',
            'created_by' => Auth::user()->id
        ]);

        return redirect('view-application-detail/'.$request->id);
    }

    //End Admin

    public function getReceipt($receipt)
    {
        $file = ComputerGrantPurchaseProof::where('id', $receipt)->first();

        $path = storage_path().'/'.'app'.'/computerGrant/'.$file->upload;

        $receipt = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($receipt, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function getImage($image)
    {
        $file = ComputerGrantPurchaseProof::where('id', $image)->first();

        $path = storage_path().'/'.'app'.'/computerGrant/'.$file->upload;

        $image = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($image, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function getFile($image)
    {
        $file = ComputerGrantFile::where('id', $image)->first();
        $path = storage_path().'/'.'app'.'/computerGrantFile/'.$file->upload;

        $image = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($image, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function applicationPDF(Request $request, $id)
    {
        $application = ComputerGrant::with(['staff'])->where('id',$id)->first();

        return view('computer-grant.application-pdf', compact('application'));
    }

    public function faq()
    {
        $faq = ComputerGrantFAQ::get();
        return view('computer-grant.faq', compact('faq'));
    }

    public function log($id)
    {
        return view('computer-grant.log', compact('id'));
    }

    public function allLog()
    {
        return view('computer-grant.all-log');
    }


    public function logList($id)
    {
        $log = ComputerGrantLog::where('permohonan_id',$id)->get();

        return datatables()::of($log)

            ->addColumn('ticket',function($log)
            {
                return $log->grant->first()->ticket_no ?? '';
            })

            ->addColumn('date',function($log)
            {
                return $log->created_at->format('d/m/Y g:ia') ?? '';
            })

            ->addColumn('admin',function($log)
            {
                return $log->staff->staff_name ?? '';
            })

            ->rawColumns(['ticket','date','admin'])
            ->make(true);
    }

    public function alllogList($id)
    {
        $allLog = ComputerGrantLog::with('grant', 'staff')->get();

        return datatables()::of($allLog)

        ->editColumn('ticket',function($allLog)
        {
            return $allLog->grant->first()->ticket_no ?? '';
        })

        ->addColumn('date',function($allLog)
        {
            return $allLog->created_at ?? '';
        })

        ->editColumn('admin',function($allLog)
        {
            return $allLog->staff->staff_name ?? '';
        })

        ->rawColumns(['ticket','date', 'admin'])
        ->make(true);
    }

    //Quota

    public function quotaList()
    {
        $quota = ComputerGrantQuota::get();

        return view('computer-grant.quota', compact('quota'));
    }


    public function quota()
    {
        $quota = ComputerGrantQuota::all();

        return datatables()::of($quota)

            ->addColumn('action', function ($quota) {
                return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$quota->id.'" data-quota="'.$quota->quota.'" data-dates="'.$quota->effective_date.'" data-duration="'.$quota->duration.'" data-status="'.$quota->active.'"
                class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->editColumn('status',function($quota)
            {

                if ($quota->active == 'Y')
                {
                    return 'Active';
                }

                else
                {
                    return 'Inactive';
                }
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function addQuota(Request $request)
    {
        ComputerGrantQuota::create([
            'quota'           => $request->quota,
            'effective_date'  => $request->dates,
            'duration'        => $request->duration,
            'active'          => $request->status,
            'created_by'      => Auth::user()->id
        ]);

        return redirect()->back()->with('message','Add Successfully');
    }

    public function editQuota(Request $request)
    {
        $update = ComputerGrantQuota::where('id', $request->id)->first();
        $update->update([
            'quota'           => $request->quota,
            'effective_date'  => $request->dates,
            'duration'        => $request->duration,
            'active'          => $request->status,
            'updated_by'      => Auth::user()->id
        ]);
        
        return redirect()->back()->with('message','Update Successfully');
    }

    //FAQ

    public function faqList()
    {
        $faq = ComputerGrantFAQ::get();

        return view('computer-grant.create-faq', compact('faq'));
    }

    public function getFAQ()
    {
        $faq = ComputerGrantFAQ::get();

        return datatables()::of($faq)

            ->addColumn('edit', function ($faq) {
                return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$faq->id.'" data-question="'.$faq->question.'" data-answer="'.$faq->answer.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->addColumn('delete', function ($faq) {
                return '<button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-faq/'.$faq->id.'"><i class="fal fa-trash"></i></button>';
                
            })

            ->rawColumns(['edit','delete'])
            ->make(true);
    }

    public function addFAQ(Request $request)
    {
        ComputerGrantFAQ::create([
            'question'   => $request->question,
            'answer'     => $request->answer,
            'created_by' => Auth::user()->id
        ]);

        return redirect()->back()->with('message','Add Successfully');
    }

    public function editFAQ(Request $request)
    {
        $update = ComputerGrantFAQ::where('id', $request->id)->first();
        $update->update([
            'question'   => $request->question,
            'answer'     => $request->answer,
            'updated_by' => Auth::user()->id
        ]);
        
        return redirect()->back()->with('message','Update Successfully');
    }

    public function deleteFAQ($id)
    {
        $exist = ComputerGrantFAQ::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);
    }

    public function agreementPDF($id)
    {
        $application = ComputerGrant::with(['staff'])->where('id',$id)->first();

        return view('computer-grant.agreement-pdf', compact('application'));
    }


    public function uploadAgreement(Request $request)
    {
        $image = $request->file('upload_image');
        $paths = storage_path()."/computerGrantFile/";

        if (isset($image)) { 
            for($y = 0; $y < count($image); $y++)
            {
                $originalsName = $image[$y]->getClientOriginalName();
                $fileSizes = $image[$y]->getSize();
                $fileNames = $originalsName;
                $image[$y]->storeAs('/computerGrantFile', $fileNames);
                ComputerGrantFile::create([
                    'permohonan_id'  => $request->id,
                    'user'           => 'APC', //for Admin
                    'upload'         => $originalsName,
                    'web_path'       => "app/computerGrantFile/".$fileNames,
                    'created_by'     => Auth::user()->id
                ]);
            }
        }

        ComputerGrantLog::create([
            'permohonan_id'  => $request->id,
            'activity'  => 'Upload signed agreement for grant acceptance',
            'created_by' => Auth::user()->id
        ]);


        return redirect('application-detail/'.$request->id);
    }

    public function requestCancellation(Request $request)
    {
        $updateApplication = ComputerGrant::where('id', $request->id)->first();
        $updateApplication->update([
            'status'     =>'7',
            'updated_by' => Auth::user()->id
        ]);

        ComputerGrantLog::create([
            'permohonan_id'  => $request->id,
            'activity'  => 'Request for application cancellation',
            'created_by' => Auth::user()->id
        ]);

        return response() ->json(['success' => 'Request for Cancellation Sent!']);
    }

    public function verifyCancellation($id)
    {
        $exist = ComputerGrant::find($id);
        $exist->delete();
        $exist->update(['status' => '8', 'active' => 'N']);

        ComputerGrantLog::create([
            'permohonan_id'  => $id,
            'activity'  => 'Verify request for cancellation',
            'created_by' => Auth::user()->id
        ]);

        return Redirect()->back()->with('message', 'Successful');
    }

}
