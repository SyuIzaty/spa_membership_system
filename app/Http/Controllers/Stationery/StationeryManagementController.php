<?php

namespace App\Http\Controllers\Stationery;

use Auth;
use App\User;
use App\Staff;
use App\Stock;
use Session;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\IsmStationery;
use App\IsmApplication;
use App\IsmApplicationTrack;
use App\StockTransaction;
use App\IsmConfirmationReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class StationeryManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stationery.application-form-list');
    }

    public function data_application_form()
    {
        $data = IsmApplication::where('applicant_id', Auth::user()->id)->with(['status'])->get();

        return datatables()::of($data)

        ->editColumn('current_status', function ($data) {

            $status = $data->current_status;
            $color = '';

            if($status == 'NA'){

                $color = 'blue';
            } else if($status == 'PA'){

                $color = 'orange';
            } else if($status == 'RC'){

                $color = 'purple';
            } else if($status == 'AC'){

                $color = 'red';
            } else if($status == 'RV' || $status == 'RA'){

                $color = 'black';
            }else {

                $color = 'green';
            }

            return '<span style="text-transform: uppercase; color:' . $color . ';"><b>' . $data->status->status_name . '</b></span>';
        })

        ->addColumn('action', function ($data) {

            if($data->current_status != 'NA'){

                return '<div class="btn-group"><a href="/application-info/' . $data->id . '" class="btn btn-sm btn-info"><i class="fal fa-eye"></i></a></div>';

            }else{

                return '<div class="btn-group"><a href="/application-info/' . $data->id . '" class="btn btn-sm btn-info mr-2"><i class="fal fa-eye"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/application-list/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
            }

            return '';
        })

        ->editColumn('id', function ($data) {

            return '#'.$data->id;
        })

        ->editColumn('created_at', function ($data) {

            return isset($data->created_at) ? date('Y-m-d', strtotime($data->created_at)) . ' | ' . date('h:i A', strtotime($data->created_at)) : '';
        })

        ->rawColumns(['action', 'current_status', 'id','created_at'])
        ->make(true);
    }

    public function application_form()
    {
        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        $stock = Stock::where('status','1')->where('applicable_for_stationary','1')->get();

        return view('stationery.application-form', compact('staff','stock'));
    }

    public function application_store(Request $request)
    {
        $request->validate([
            'applicant_id'              => 'required',
            'applicant_phone'           => 'required',
            'applicant_verification'    => 'required',
        ]);

        $staff = Staff::where('staff_id', $request->applicant_id)->first();

        $application = IsmApplication::create([
            'applicant_id'              => $staff->staff_id,
            'applicant_email'           => $staff->staff_email,
            'applicant_phone'           => $request->applicant_phone,
            'applicant_dept'            => $staff->staff_code,
            'applicant_verification'    => 'Y',
            'current_status'            => 'NA',
        ]);

        $track = IsmApplicationTrack::create([
            'application_id'      => $application->id,
            'status_id'           => 'NA',
            'created_by'          => $staff->staff_id,
        ]);

        if (isset($request->stock_id)) {

            foreach($request->input('stock_id') as $key => $value) {

                IsmStationery::create([
                    'application_id'        => $application->id,
                    'stock_id'              => $value,
                    'request_quantity'      => $request->request_quantity[$key],
                    'request_remark'        => $request->request_remark[$key],
                ]);
            }
        }

        $admin = User::whereHas('roles', function($query){
            $query->where('id', 'ISM002');
        })->get();

        foreach ($admin as $admin_list) {
            $data = [
                'app_recipient'     => $admin_list->name,
                'app_description'   => 'For your information, you have just received a new application (APPLICATIONID #'.$application->id.') from '.$application->staff->staff_name.' on '
                                        .date('d/m/Y', strtotime($application->created_at)).'. Please review the application at your earliest convenience.',
            ];

            Mail::send('stationery.mail-template', $data, function($message) use ($application, $admin_list) {
                $message->to($admin_list->email)->subject('I-Stationery : New Application');
                $message->from($application->applicant_email);
            });
        }

        Session::flash('message', 'Your application has been submitted for processing. Please refer to the application list below for any information related to your submission.');
        return redirect('application-list');
    }

    public function application_delete($id)
    {
        $exist = IsmApplication::findOrFail($id);

        IsmApplicationTrack::where('application_id', $exist->id)->delete();

        IsmStationery::where('application_id', $exist->id)->delete();

        $exist->delete();

        return response()->json(['message' => 'Application deleted successfully']);
    }

    public function application_info($id)
    {
        $application = IsmApplication::where('id', $id)->first();

        return view('stationery.application-info', compact('application'));
    }

    public function application_verify(Request $request)
    {
        if ($request->status == '1') { //Accepted

            $request->validate([
                'status' => 'required',
            ]);

            $staff = Staff::where('staff_id', Auth::user()->id)->first();

            $application = IsmApplication::where('id', $request->id)->first();

            $application->update([
                'current_status' => 'PA',
            ]);

            $track = IsmApplicationTrack::create([
                'application_id'    => $application->id,
                'status_id'         => 'PA',
                'created_by'        => $staff->staff_id,
            ]);

            foreach ($request->stationery_id as $key => $stationeryId) {
                $stationery = IsmStationery::find($stationeryId);

                $approveQuantity = $request->approve_quantity[$key] ?? null;
                $approveRemark = $request->approve_remark[$key] ?? null;

                $stationery->approve_quantity = $approveQuantity;
                $stationery->approve_remark = $approveRemark;

                $stationery->save();
            }

            $admin = User::whereHas('roles', function ($query) {
                $query->where('id', 'ISM001');
            })->get();

            foreach ($admin as $admin_list) {
                $data = [
                    'app_recipient'     => $admin_list->name,
                    'app_description'   => 'Please be informed that you have received an application (APPLICATIONID #'.$application->id.') requiring approval from '.$application->staff->staff_name.' on '
                                            . date('d/m/Y', strtotime(Carbon::now())). '. Review and approve the application at your earliest convenience.',
                ];

                Mail::send('stationery.mail-template', $data, function($message) use ($staff, $admin_list) {
                    $message->to($admin_list->email)->subject('I-Stationery : Pending Approval');
                    $message->from($staff->staff_email);
                });
            }

            Session::flash('message', 'The application has been accepted and verified. It is now pending on approval.');

        } else { //Rejected

            $request->validate([
                'status' => 'required',
                'remark' => 'required',
            ]);

            $staff = Staff::where('staff_id', Auth::user()->id)->first();

            $application = IsmApplication::where('id', $request->id)->first();

            $application->update([
                'current_status' => 'RV',
            ]);

            $track = IsmApplicationTrack::create([
                'application_id'    => $application->id,
                'status_id'         => 'RV',
                'created_by'        => $staff->staff_id,
                'remark'            => $request->remark,
            ]);

            $data = [
                'app_recipient'     => $application->applicant_email,
                'app_description'   => 'Please be informed that your application (APPLICATIONID #'.$application->id.') has been rejected on ' . date('d/m/Y', strtotime($track->created_at))
                                        . ' because: "' . ucwords($track->remark) . '".',

            ];

            Mail::send('stationery.mail-template', $data, function($message) use ($application, $staff) {
                $message->to($application->applicant_email)->subject('I-Stationery : Application Rejected');
                $message->from($staff->staff_email);
            });

            Session::flash('message', 'The application has been rejected, and an email notification has been sent to the applicant.');
        }

        return redirect()->back();
    }

    public function application_manage($status)
    {
        return view('stationery.application-manage', compact('status'));
    }

    public function data_application_manage($status)
    {
        if($status == 'RV'){

            $data = IsmApplication::whereIn('current_status', ['RV','RA'])->with(['staff','status'])->get();

        } else {

            $data = IsmApplication::where('current_status', $status)->with(['staff','status'])->get();
        }

        return datatables()::of($data)

        ->editColumn('applicant_name', function ($data) {

            return isset($data->staff->staff_name) ? $data->staff->staff_name : '';
        })

        ->editColumn('current_status', function ($data) {

            return '<span style="text-transform: uppercase"><b>' . (isset($data->status->status_name) ? $data->status->status_name : 'N/A') . '</b></span>';
        })

        ->addColumn('remark', function ($data) {

            $track = IsmApplicationTrack::where('application_id', $data->id)->where('status_id', $data->current_status)->first();

            return isset($track->remark) ? '<span style="color:red">'.ucwords($track->remark).'</span>' : 'N/A';
        })

        ->addColumn('action', function ($data) {

            return '<div class="btn-group"><a href="/application-info/' . $data->id . '" class="btn btn-sm btn-info"><i class="fal fa-eye"></i></a></div>';
        })

        ->addColumn('duration', function ($data) {

            $duration = Carbon::parse($data->created_at)->diffInDays(Carbon::now()) + 1;

            return '<b style="color:red">'.$duration.' day(s)</b>';

        })

        ->addColumn('reminder', function ($data) {

            $reminder = IsmApplicationTrack::where('application_id', $data->id)->where('status_id', $data->current_status)->first();

            $reminderCount = $reminder->confirmationReminders ? $reminder->confirmationReminders->count() : 'N/A';

            return '<b style="color:red">' . $reminderCount . ' times(s)</b>';

        })

        ->editColumn('id', function ($data) {

            return '#'.$data->id;
        })

        ->editColumn('created_at', function ($data) {

            return isset($data->created_at) ? date('Y-m-d', strtotime($data->created_at)) . ' | ' . date('h:i A', strtotime($data->created_at)) : '';
        })

        ->rawColumns(['action', 'applicant_name', 'id','created_at', 'applicant_id','duration','remark','current_status','reminder'])
        ->make(true);
    }

    public function application_approve(Request $request)
    {
        if ($request->status == 'RC') { //Ready For Collection RC

            $request->validate([
                'status' => 'required',
            ]);

            $staff = Staff::where('staff_id', Auth::user()->id)->first();

            $application = IsmApplication::where('id', $request->id)->first();

            $application->update([
                'current_status' => 'RC',
            ]);

            $track = IsmApplicationTrack::create([
                'application_id'    => $application->id,
                'status_id'         => 'RC',
                'created_by'        => $staff->staff_id,
            ]);

            // Email To Manager : for stationery preparation

            $admin = User::whereHas('roles', function ($query) {
                $query->where('id', 'ISM002');
            })->get();

            foreach ($admin as $admin_list) {
                $data = [
                    'app_recipient'     => $admin_list->name,
                    'app_description'   => 'Please be informed that application (APPLICATIONID #'.$application->id.') by ' . $application->staff->staff_name . ' on ' .
                                            date('d/m/Y', strtotime($application->created_at)). ' have been approved. Review and make preparation for collection at your earliest convenience.',
                ];

                Mail::send('stationery.mail-template', $data, function($message) use ($admin_list) {
                    $message->to($admin_list->email)->subject('I-Stationery : Collection Preparation');
                    $message->from(Auth::user()->email);
                });
            }

            // Email To Applicant

            $data = [
                'app_recipient'     => $application->applicant_email,
                'app_description'   => 'Please be informed that your application (APPLICATIONID #'.$application->id.') on ' .
                                        date('d/m/Y', strtotime($application->created_at)). ' has been approved and is now ready for collection.
                                        For further inquiries regarding collection, please directly contact PUAN NORZALILATUL AKMA at 0386037085.',
            ];

            Mail::send('stationery.mail-template', $data, function($message) use ($application, $staff) {
                $message->to($application->applicant_email)->subject('I-Stationery : Ready For Collection');
                $message->from($staff->staff_email);
            });

            Session::flash('message', 'The application has been approved successfully.');

        } else { //Rejected Application - Approval RA

            $request->validate([
                'status' => 'required',
            ]);

            $staff = Staff::where('staff_id', Auth::user()->id)->first();

            $application = IsmApplication::where('id', $request->input('id'))->first();

            $application->update([
                'current_status' => 'RA',
            ]);

            $track = IsmApplicationTrack::create([
                'application_id'    => $application->id,
                'status_id'         => $request->input('status'),
                'created_by'        => $staff->staff_id,
                'remark'            => $request->input('rejectReason'),
            ]);

            $data = [
                'app_recipient'     => $application->applicant_email,
                'app_description'   => 'Please be informed that your application (APPLICATIONID #'.$application->id.') has been rejected on ' . date('d/m/Y', strtotime($track->created_at))
                                        . ' because: "' . ucwords($track->remark) . '".',

            ];

            Mail::send('stationery.mail-template', $data, function($message) use ($application, $staff) {
                $message->to($application->applicant_email)->subject('I-Stationery : Application Rejected');
                $message->from($staff->staff_email);
            });

            Session::flash('message', 'The application has been rejected, and an email notification has been sent to the applicant.');
        }

        return redirect()->back();
    }

    public function application_reminder(Request $request)
    {
        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        $application = IsmApplication::where('id', $request->id)->first();

        if($application->current_status == 'RC'){

            $application->update([
                'current_status' => 'AC',
            ]);

            $track = IsmApplicationTrack::create([
                'application_id'    => $application->id,
                'status_id'         => 'AC',
                'created_by'        => $staff->staff_id,
            ]);

            // transaction out from stock

            $stationery = IsmStationery::where('application_id', $application->id)->get();

            foreach($stationery as $stationery_list){

                if($stationery_list->approve_quantity != ''){

                    StockTransaction::create([
                        'stock_id'      => $stationery_list->stock_id,
                        'stock_in'      => '0',
                        'stock_out'     => $stationery_list->approve_quantity,
                        'created_by'    => $staff->staff_id,
                        'reason'        => 'FOR I-STATIONERY USE',
                        'supply_type'   => 'INT',
                        'supply_to'     => $application->applicant_id,
                        'trans_date'    => $track->created_at,
                        'status'        => '0',
                    ]);
                }
            }

        } else {

            $track = IsmApplicationTrack::where('application_id', $application->id)->where('status_id', 'AC')->first();
        }

        $reminder = IsmConfirmationReminder::create([
            'application_track_id'      => $track->id,
            'created_by'                => $staff->staff_id,
        ]);

        $data = [
            'app_recipient'     => $application->applicant_email,
            'app_description'   => 'Please be advised that this email serves as a reminder. You have already picked up your stationery with designed staff.
                                    Please confirm this action in respective application (APPLICATIONID #'.$application->id.') at your earliest convenience.',

        ];

        Mail::send('stationery.mail-template', $data, function($message) use ($application, $staff) {
            $message->to($application->applicant_email)->subject('I-Stationery : Collection Confirmation');
            $message->from($staff->staff_email);
        });

        Session::flash('message', 'The reminder for this application have been sent to respective applicant.');

        return redirect()->back();
    }

    public function application_confirm(Request $request)
    {
        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        $application = IsmApplication::where('id', $request->id)->first();

        $application->update([
            'current_status' => 'CP',
        ]);

        $track = IsmApplicationTrack::create([
            'application_id'    => $application->id,
            'status_id'         => 'CP',
            'created_by'        => $staff->staff_id,
        ]);

        Session::flash('message', 'This application have been successfully confirmed as complete.');
        return redirect()->back();
    }

    public function application_pdf($id)
    {
        $application = IsmApplication::where('id', $id)->first();

        return view('stationery.application-pdf', compact('application'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
