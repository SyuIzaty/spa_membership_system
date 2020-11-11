<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\User;
use App\Lead;
use App\LeadGroup;
use App\Source;
use App\Intakes;
use App\LeadNote;
use App\LeadStatus;
use App\FollowType;
use App\Programme;
use App\Applicant;
use App\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadExport;
use App\Http\Requests\StoreLeadRequest;
use App\Jobs\SendEmail;
use Carbon\Carbon;

class LeadController extends Controller
{

    public function activeLead(Request $request)
    {  
        $lead = Lead::all();

        $members = User::whereHas('roles', function($query){
            $query->where('id', 6);
        })->get();
        
        return view('lead.active_lead', compact('members', 'lead'))->with('no', 1);

    }

    public function data_lead_list()
    {
        if( Auth::user()->hasRole('sales manager|admin assistant') )
        { 
            $lead = Lead::all()->whereIn('leads_status', ['NI','NC','OG','AC','DC','CO','OO']);
        }
        else
        {
            $lead = Lead::select('*')->whereIn('leads_status', ['NI','NC','OG','AC','DC','CO','OO'])->where('assigned_to', Auth::user()->id)->get();
        }

        return datatables()::of($lead)
        ->addColumn('action', function ($lead) {

        if( Auth::user()->hasRole('sales manager|admin assistant') )
        { 
            return '<a href="/lead/follow_lead/' . $lead->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Follow Up</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/lead/active_lead/' . $lead->id . '"><i class="fal fa-trash"></i>  Delete</button>
                    <a href="" data-target="#crud-modal" data-toggle="modal" data-lead="'.$lead->id.'" data-create="'.$lead->assigned_to.'"  class="btn btn-sm btn-warning"><i class="fal fa-user"></i> Assign To</a>';
        }

        else
        {
            return '<a href="/lead/follow_lead/' . $lead->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Follow Up</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/lead/active_lead/' . $lead->id . '"><i class="fal fa-trash"></i>  Delete</button>';
        }
            
        })

        ->editColumn('created_at', function ($lead) {

            return date(' Y-m-d | H:i A', strtotime($lead->updated_at) );
        })

        ->editColumn('leads_group', function ($lead) {

             return $lead->lead_group->group_name;
        })

        ->editColumn('leads_status', function ($lead) {

            return $lead->lead_status->status_name;
        })

        ->editColumn('assigned_to', function ($lead) {

            return '<div>[ ' .$lead->user->name. ' ]</div>';
             
        })
        
        ->rawColumns(['leads_status', 'assigned_to', 'action', 'created_at'])
        ->make(true);
    }

    public function newLead()
    {
        $source = Source::orderBy('source_name')->get(); 
        $programme = Programme::all();
        $qualification = Qualification::orderBy('qualification_name')->get(); 
        $group = LeadGroup::orderBy('group_name')->where('group_status', 1)->get();

        $members = User::whereHas('roles', function($query){
            $query->where('id', 6);
        })->get();

        $lead = new Lead();
        return view('lead.new_lead', compact('programme', 'lead', 'qualification', 'source', 'group', 'members'));
    }

    public function newLeadStore(StoreLeadRequest $request)
    {
        $id = Auth::user()->id;

        if(isset($request->assigned_to) && !empty($request->assigned_to))
            $assigned_to = $request->assigned_to;
        else 
            $assigned_to = $id;

        // array_search to search in $request for NULL val. None send false. If $key not equal false (have Null val), status id = 0

        // $key = array_search(null, $request->toArray());

        // if ($key !== false)
        //     $status_id = 0;
        // else
        //     $status_id = 1;

        if (array_search(null, $request->toArray()) !== false)
            $status_id = 'NI';
        else
            $status_id = 'NC';

        Lead::create([
            'leads_name'    => strtoupper($request->leads_name),
            'leads_email'   => $request->leads_email,
            'leads_phone'   => $request->leads_phone,
            'leads_ic'      => $request->leads_ic,
            'leads_source'  => $request->leads_source, 
            'leads_event'   => strtoupper($request->leads_event), 
            'edu_level'     => $request->edu_level,
            'leads_prog1'   => $request->leads_prog1, 
            'leads_prog2'   => $request->leads_prog2, 
            'leads_prog3'   => $request->leads_prog3, 
            'leads_group'   => $request->leads_group,
            'leads_status'  => $status_id,
            'created_by'    => $id,
            'assigned_to'   => $assigned_to,
        ]);
        
        // dd($request);
        return redirect('lead/active_lead');
    }

    public function deleteLeadInfo($id)
    {
        $exist = Lead::find($id);
        $exist->delete();
        return response()->json(['success'=>'Lead deleted successfully.']);
    }

    public function followLead($id)
    {
        $lead = Lead::where('id', $id)->first(); 
        $lead_note = LeadNote::where('leads_id', $id)->get()->last(); 
        
        $applicant = ''; 

        if(isset($lead->leads_ic) && !empty($lead->leads_ic))
            $applicant = Applicant::where('applicant_ic', $lead->leads_ic)->get();
            
        $members = User::whereHas('roles', function($query){
            $query->where('id', 6);
        })->get();

        $programme = Programme::all();
        $intakes = Intakes::all();
        $status = LeadStatus::orderBy('status_name')->get();
        $followType = FollowType::all();
        $source = Source::orderBy('source_name')->get(); 
        $qualification = Qualification::orderBy('qualification_name')->get(); 
        $group = LeadGroup::orderBy('group_name')->where('group_status', 1)->get();

        return view('lead.follow_lead', compact('lead', 'programme', 'status', 'followType', 'lead_note', 'applicant', 'qualification', 'source', 'group', 'members'))->with('no', 1);
    }

    public function updateFollow(StoreLeadRequest $request) 
    {

        $lead = Lead::where('id', $request->id)->first();

        $lead->update([
            'leads_name'    => strtoupper($request->leads_name),
            'leads_email'   => $request->leads_email,
            'leads_phone'   => $request->leads_phone,
            'leads_ic'      => $request->leads_ic,
            'leads_source'  => $request->leads_source, 
            'leads_event'   => strtoupper($request->leads_event),
            'edu_level'     => $request->edu_level,
            'leads_group'   => $request->leads_group,
            'leads_prog1'   => $request->leads_prog1,
            'leads_prog2'   => $request->leads_prog2,
            'leads_prog3'   => $request->leads_prog3,
        ]);

        Session::flash('message', 'Lead Information Updated Successfully');
        return redirect('lead/follow_lead/'.$lead->id);
    }

    public function createFollowInfo(Request $request)
    {
        $lead = Lead::where('id', $request->id)->first();

        $lead->update([
            'leads_status'  => $request->status_id,
        ]);

        LeadNote::create([
                'leads_id'          => $lead->id,  
                'follow_type_id'    => $request->follow_type_id,
                'follow_date'       => $request->follow_date,
                'follow_remark'     => $request->follow_remark,
                'status_id'         => $request->status_id, 
            ]);
        
        return redirect('lead/follow_lead/'.$lead->id);
    }

    public function deleteFollowInfo($id)
    {
        $exist = LeadNote::find($id);
        $exist->delete();
        return response()->json(['success', 'Successfully deleted!']);
    }

    public function editFollowLead($id)
    {
        $leadNote = LeadNote::where('id', $id)->first();
        $followType = FollowType::all();
        $status = LeadStatus::all();
        return view('lead.edit_followLead', compact('leadNote', 'followType', 'status'));
    }

    public function updateEditFollow(Request $request) 
    {
        $leadNote = LeadNote::where('id', $request->id)->first();

        $leadNote->update([
            'follow_remark' => $request->follow_remark,
            'timestamps' => false,
        ]);

        Session::flash('notification', 'Follow Up updated successfully');
        return redirect('lead/follow_lead/'.$leadNote->leads_id);
    }

    public function inactiveLead()
    {
        $lead = Lead::all();

        $members = User::whereHas('roles', function($query){
            $query->where('id', 2);
        })->get();

        return view('lead.inactive_lead', compact('members', 'lead'))->with('no', 1);
    }

    public function inactiveUnLead()
    {
        $lead = Lead::all();

        $members = User::whereHas('roles', function($query){
            $query->where('id', 2);
        })->get();

        return view('lead.inactive_lead_un', compact('members', 'lead'))->with('no', 1);
    }

    public function data_inactiveLead_list()
    {
        if( Auth::user()->hasRole('sales manager|admin assistant') )
        { 
            $lead = Lead::all()->whereIn('leads_status', ['LR']);
        }
        else
        {
            $lead = Lead::select('*')->whereIn('leads_status', ['LR'])->where('assigned_to', Auth::user()->id)->get();
        }

        return datatables()::of($lead)
        ->addColumn('action', function ($lead) {

        if( Auth::user()->hasRole('sales manager|admin assistant') )
        { 
            return '<a href="/lead/follow_lead/' . $lead->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Follow Up</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/lead/active_lead/' . $lead->id . '"><i class="fal fa-trash"></i>  Delete</button>
                    <a href="" data-target="#crud-modal" data-toggle="modal" data-lead="'.$lead->id.'" data-create="'.$lead->assigned_to.'"  class="btn btn-sm btn-warning"><i class="fal fa-user"></i> Assign To</a>';         
        }
        else
        {
            return '<a href="/lead/follow_lead/' . $lead->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Follow Up</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/lead/active_lead/' . $lead->id . '"><i class="fal fa-trash"></i>  Delete</button>';
        }

            
        })

        ->editColumn('created_at', function ($lead) {

            return date(' Y-m-d | H:i A', strtotime($lead->updated_at) );
        })

        ->editColumn('leads_status', function ($lead) {

            $color = '#52d704';
            
            return '<div style="text-transform: uppercase; color:' . $color . '"><b>' .$lead->lead_status->status_name. '</b></div>';
        })

        ->editColumn('leads_group', function ($lead) {

            return $lead->lead_group->group_name;
       })

        ->editColumn('assigned_to', function ($lead) {

            return '<div>[ ' .$lead->user->name. ' ]</div>';
             
        })
        
        ->rawColumns(['leads_status', 'action', 'assigned_to'])
        ->make(true);
    }

    public function data_inactiveUnLead_list()
    {
        if( Auth::user()->hasRole('sales manager|admin assistant') )
        { 
            $lead = Lead::all()->whereIn('leads_status', ['NS','DB']);
        }
        else
        {
            $lead = Lead::select('*')->whereIn('leads_status', ['NS','DB'])->where('assigned_to', Auth::user()->id)->get();
        }

        return datatables()::of($lead)
        ->addColumn('action', function ($lead) {

        if( Auth::user()->hasRole('sales manager|admin assistant') )
        { 
            return '<a href="/lead/follow_lead/' . $lead->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Follow Up</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/lead/active_lead/' . $lead->id . '"><i class="fal fa-trash"></i>  Delete</button>
                    <a href="" data-target="#crud-modal" data-toggle="modal" data-lead="'.$lead->id.'" data-create="'.$lead->assigned_to.'"  class="btn btn-sm btn-warning"><i class="fal fa-user"></i> Assign To</a>';    
        }
        else
        {
            return '<a href="/lead/follow_lead/' . $lead->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Follow Up</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/lead/active_lead/' . $lead->id . '"><i class="fal fa-trash"></i>  Delete</button>';
        }

            
        })

        ->editColumn('created_at', function ($lead) {

            return date(' Y-m-d | H:i A', strtotime($lead->updated_at) );
        })

        ->editColumn('leads_status', function ($lead) {
          
            $color = '#FC1349';
      
            return '<div style="text-transform: uppercase; color:' . $color . '"><b>' .$lead->lead_status->status_name. '</b></div>';
        })

        ->editColumn('leads_group', function ($lead) {

            return $lead->lead_group->group_name;
       })

        ->editColumn('assigned_to', function ($lead) {

            return '<div>[ ' .$lead->user->name. ' ]</div>';
             
        })
        
        ->rawColumns(['leads_status', 'action', 'assigned_to'])
        ->make(true);
    }

    public function updateAssign(Request $request) 
    {
        $lead = Lead::where('id', $request->lead_id)->first();

        $lead->update([
            'assigned_to'    => $request->assigned_to,
        ]);
        
        return redirect('lead/active_lead');
    }

    public function groupList(Request $request)
    {  
        
        return view('lead.group_list');

    }

    public function groupNew()
    {
        $lead = new LeadGroup();
        return view('lead.group_new');
    }

    public function groupNewStore(Request $request)
    {
        
        LeadGroup::create([
            'group_code'    => strtoupper($request->group_code),
            'group_name'    => strtoupper($request->group_name),
            'group_desc'    => $request->group_desc,
            'group_status'  => $request->group_status,
        ]);

        return redirect('lead/group_list');
    }

    public function editGroup($id)
    {
        $group = LeadGroup::where('id', $id)->first();
        return view('lead.group_edit', compact('group'));
    }

    public function updateGroup(Request $request) 
    {
        $group = LeadGroup::where('id', $request->id)->first();

        $group->update([
            'group_code'    => strtoupper($request->group_code),
            'group_name'    => strtoupper($request->group_name),
            'group_desc'    => $request->group_desc,
            'group_status'  => $request->group_status,
        ]);

        Session::flash('message', 'Group updated successfully');
        return redirect('lead/group_list/');
    }

    public function deleteGroupInfo($id)
    {
        $exist = LeadGroup::find($id);
        $exist->delete();
        return response()->json(['success'=>'Group deleted successfully.']);
    }

    public function data_group_list()
    {

        $group = LeadGroup::all();

        return datatables()::of($group)
        ->addColumn('action', function ($group) {

            return '<a href="/lead/group_edit/'.$group->id.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/lead/group_list/' . $group->id . '"><i class="fal fa-trash"></i>  Delete</button>';
            
        })

        ->editColumn('created_at', function ($group) {

            return date(' Y-m-d | H:i A', strtotime($group->updated_at) );
        })

        ->editColumn('group_status', function ($group) {
            
            return strtoupper($group->group_status ? 'Active' : 'Inactive');
        })

        ->make(true);
    }

    public function sendEmail(Request $request)
    {
        $lead = Lead::where('id', $request->id)->where('leads_status','NC')->first();

        // dd($request->id);

        $report = PDF::loadView('lead.lead_pdf', compact('lead'));
        $data = [
            'receiver_name' => $lead->leads_name,
            'details' => 'This offer letter is appended with this email. Please refer to the attachment for your registration instructions.',
        ];

        Mail::send('lead.cond-offer-letter', $data, function ($message) use ($lead, $report) {
            $message->subject('Congratulations, ' . $lead->leads_name);
            $message->from(Auth::user()->email);
            $message->to(!empty($lead->leads_email) ? $lead->leads_email : 'jane-doe@email.com');
            $message->attachData($report->output(), 'Conditional_Offer_Letter_' . $lead->leads_name . '.pdf');
        });
    
        $leads = Lead::where('id', $request->id)->first();

        $leads->update([
            'leads_status'  => 'CO',
        ]);

        LeadNote::create([
                'leads_id'          => $leads->id,  
                'follow_type_id'    => 1,
                'follow_date'       => Carbon::now()->toDateTimeString(),
                'follow_remark'     => 'Conditional Offer Letter generated and published',
                'status_id'         => $leads->leads_status, 
            ]);
    
        return redirect('lead/follow_lead/'.$lead->id);
    }

    public function letter(Request $request)
    {
        $lead = Lead::where('id', $request->id)->first();

        $pdf = PDF::loadView('lead.lead_pdf', compact('lead'));
        return $pdf->stream('Conditional_Offer_Letter_' . $lead->leads_name . '.pdf');
    }

    public function lead_all(Request $request)
    {
        $group = LeadGroup::select('id', 'group_code')->get();
        $status = LeadStatus::select('status_code', 'status_name')->get();

        $cond = "1"; // 1 = selected

        $selectedgroup = $request->group; //ambil data dari dropdown
        $selectedstatus = $request->status;
        $list = [];

        return view('lead.lead_report', compact('group', 'status', 'request', 'list', 'selectedgroup', 'selectedstatus'));
    }

    public function exports($group = null,$status = null)
    {
        return Excel::download(new LeadExport($group, $status), 'lead.xlsx');
    }

    public function data_leadexport(Request $request) // Datatable: all lead
    {
        $cond = "1";
        if($request->group && $request->group != "All")
        {
            $cond .= " AND leads_group = ".$request->group;
        }

        if( $request->status != "" && $request->status != "All")
        {
            $cond .= " AND leads_status = '".$request->status."' ";
        }

        $lead = Lead::whereRaw($cond)->get();
        
        return datatables()::of($lead)

        ->editColumn('leads_group', function ($lead) {

            return $lead->lead_group->group_name;
       })

       ->editColumn('leads_status', function ($lead) {

           return $lead->lead_status->status_name;
       })

       ->editColumn('assigned_to', function ($lead) {

           return '<div> ' .$lead->user->name. ' </div>';
       })

       ->editColumn('created_at', function ($lead) {

            return date(' Y-m-d | H:i A', strtotime($lead->updated_at) );
        })
    
       ->rawColumns(['assigned_to'])
       ->make(true);
    }

    public function emailBlast(Request $request)
    {
        $status = LeadStatus::orderBy('status_name')->get();
        $groups = LeadGroup::orderBy('group_name')->where('group_status', 1)->get();
        // @dd($groups);
        return view('lead.email_blast', compact('status', 'groups'));
    }

    public function sendEmailBlast(Request $request)
    {
        $list = Lead::where('leads_status', $request->status)->where('leads_group', $request->group)->get();

        //$email = array_filter(array_column($list->toArray(), 'leads_email'));

        foreach($list as $value)
        {
            $data = [
                    'receiver_name' => $value->leads_name, //leads_name
                    'details' => $request->email_cont,
                ];

            $email = $value->leads_email;

            Mail::send('lead.email', $data, function($message) use ($email, $request) {
                $message->to($email)->subject($request->email_sub);
                // $message->setBody($request->email_cont);
                $message->from(Auth::user()->email);
            });
        }

        Session::flash('message', 'Email was sent');
        return redirect('/lead/email_blast');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function edit()
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
