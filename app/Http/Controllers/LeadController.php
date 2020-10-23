<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\User;
use App\Lead;
use App\Intakes;
use App\LeadNote;
use App\LeadStatus;
use App\FollowType;
use App\Programme;
use App\Applicant;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLeadRequest;

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

        if(Auth::user()->id == '13') 
        { 
            $lead = Lead::all()->whereIn('leads_status', [0,1]);
        }
        else
        {
            $lead = Lead::select('*')->whereIn('leads_status', [0,1])->where('created_by', Auth::user()->id)->get();
        }

        return datatables()::of($lead)
        ->addColumn('action', function ($lead) {

            if(Auth::user()->id == '13')  
        { 
            return '<a href="/lead/follow_lead/' . $lead->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Follow Up</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/lead/active_lead/' . $lead->id . '"><i class="fal fa-trash"></i>  Delete</button>
                    <a href="" data-target="#crud-modal" data-toggle="modal" data-lead="'.$lead->id.'" data-create="'.$lead->created_by.'"  class="btn btn-sm btn-warning"><i class="fal fa-user"></i> Assign To</a>';
                    
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

            if ($lead->lead_status->status_name == 'New Lead')
            {
                $color = 'black';
            }
            elseif ($lead->lead_status->status_name == 'Ongoing')
            {
                $color = '#2198F3';
            }
            
            return '<div style="color:' . $color . '"><b>' .$lead->lead_status->status_name. '</b></div>';
        })

        ->editColumn('created_by', function ($lead) {

            return '<div>[ ' .$lead->user->name. ' ]</div>';
             
        })
        
        ->rawColumns(['leads_status', 'created_by', 'action', 'created_at'])
        ->make(true);
    }

    public function newLead()
    {
        $programme = Programme::all();
        $lead = new Lead();
        return view('lead.new_lead', compact('programme', 'lead'));
    }

    public function newLeadStore(StoreLeadRequest $request)
    {
        $id = Auth::user()->id;

        Lead::create([
            'leads_name'    => $request->leads_name,
            'leads_email'   => $request->leads_email,
            'leads_phone'   => $request->leads_phone,
            'leads_ic'      => $request->leads_ic,
            'leads_source'  => $request->leads_source, 
            'leads_prog1'   => $request->leads_prog1, 
            'leads_prog2'   => $request->leads_prog2, 
            'leads_prog3'   => $request->leads_prog3, 
            'leads_status'  => 0, 
            'created_by'    => $id,
        ]);

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
        
        $applicant = Applicant::where('applicant_ic', $lead->leads_ic)->first();
        $programme = Programme::all();
        $intakes = Intakes::all();
        $status = LeadStatus::all();
        $followType = FollowType::all();

        return view('lead.follow_lead', compact('lead', 'programme', 'status', 'followType', 'lead_note', 'applicant'))->with('no', 1);
    }

    public function updateFollow(StoreLeadRequest $request) 
    {
        $lead = Lead::where('id', $request->id)->first();

        $lead->update([
            'leads_name'    => $request->leads_name,
            'leads_email'   => $request->leads_email,
            'leads_phone'   => $request->leads_phone,
            'leads_ic'      => $request->leads_ic,
            'leads_source'  => $request->leads_source,
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
                'follow_title'      => $request->follow_title,
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

    public function data_inactiveLead_list()
    {
        if(Auth::user()->id == '13') 
        { 
            $lead = Lead::all()->whereIn('leads_status', [2,3]);
        }
        else
        {
            $lead = Lead::select('*')->whereIn('leads_status', [2,3])->where('created_by', Auth::user()->id)->get();
        }

        return datatables()::of($lead)
        ->addColumn('action', function ($lead) {

            if(Auth::user()->id == '13')  
        { 
            return '<a href="/lead/follow_lead/' . $lead->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Follow Up</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/lead/active_lead/' . $lead->id . '"><i class="fal fa-trash"></i>  Delete</button>
                    <a href="" data-target="#crud-modal" data-toggle="modal" data-lead="'.$lead->id.'" data-create="'.$lead->created_by.'"  class="btn btn-sm btn-warning"><i class="fal fa-user"></i> Assign To</a>';
                    
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

            if ($lead->lead_status->status_name == 'Closed Registered')
            {
                $color = '#52d704';
            }
            elseif ($lead->lead_status->status_name == 'Closed Rejected')
            {
                $color = '#FC1349';
            }
            
            return '<div style="color:' . $color . '"><b>' .$lead->lead_status->status_name. '</b></div>';
        })

        ->editColumn('created_by', function ($lead) {

            return '<div>[ ' .$lead->user->name. ' ]</div>';
             
        })
        
        ->rawColumns(['leads_status', 'action', 'created_by'])
        ->make(true);
    }

    public function updateAssign(Request $request) 
    {
        $lead = Lead::where('id', $request->lead_id)->first();

        $lead->update([
            'created_by'    => $request->created_by,
        ]);
        
        return redirect('lead/active_lead');
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
