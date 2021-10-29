<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\EngagementManagement;
use App\EngagementProgress;
use App\EngagementStatus;
use App\EngagementMember;
use App\User;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EngagementManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('engagement.list');

    }

    public function lists()
    {
        $list = EngagementManagement::all();

        return datatables()::of($list)

        ->editColumn('status', function ($list) {

            $status = EngagementProgress::where('engagement_id', $list->id)->latest('id')->first();

            if ($status != '')
            {
                return $status->getStatus->description;
            }

            else
            {
                return 'N/A';
            }
            
        })

        ->addColumn('action', function ($list) {
            
            return '<a href="/engagement-detail/' .$list->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function new()
    {
        $user = User::all();

        return view('engagement.new_engagement', compact('user'));
    }

    public function status()
    {
        $status = EngagementStatus::all();

        return view('engagement.status', compact('status'));
    }

    public function getStatus()
    {
        $status = EngagementStatus::all();

        return datatables()::of($status)

            ->editColumn('active',function($status)
            {

                if ($status->active == 'Y')
                {
                    return '<div style="color: green;"><b>Active</b></div>';
                }

                else
                {
                    return '<div style="color: red;"><b>Inactive</b></div>';
                }
            })

            ->addColumn('edit', function ($status) {
                return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$status->id.'" data-status="'.$status->description.'" data-active="'.$status->active.'"
                class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->addColumn('delete', function ($status) {
                return '<button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-status/' . $status->id . '"><i class="fal fa-trash"></i></button>';
            })

            ->rawColumns(['active','edit','delete'])
            ->make(true);
    }

    public function addStatus(Request $request)
    {
        EngagementStatus::create([
            'description' => $request->status,
            'active'      => $request->active,
            'created_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message','Add Successfully');
    }

    public function editStatus(Request $request)
    {
        $update = EngagementStatus::where('id', $request->id)->first();
        $update->update([
            'description' => $request->status,
            'active'      => $request->active,
            'updated_by'  => Auth::user()->id
        ]);
        
        return redirect()->back()->with('message','Update Successfully');
    }

    public function deleteStatus($id)
    {
        $exist = EngagementStatus::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);
    }

    public function createToDoList(Request $request)
    {
        


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $engagement = new EngagementManagement();
        $engagement->title = $request->title;
        $engagement->engage_party_one = $request->engage_part_1;
        $engagement->engage_party_two = $request->engage_part_2;
        $engagement->created_by = Auth::user()->id;
        $engagement->updated_by = Auth::user()->id;
        $engagement->save();

        foreach($request->member_id as $key => $value)
        {
            EngagementMember::create([
                'engagement_id' => $engagement->id,
                'staff_id'      => $value, 
                'created_by'    => Auth::user()->id
            ]);
        }

        return redirect('engagement-detail/'.$engagement->id)->with('message','Profile created!');
    }

    public function details($id)
    {
        $user = User::all();
        $status = EngagementStatus::all();
        $data = EngagementManagement::where('id', $id)->first();
        $member = EngagementMember::where('engagement_id', $id)->get();

        return view('engagement.detail', compact('user','status','data','member'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'title'      => 'required',
            'party1'     => 'required',
        ]);
        
        EngagementManagement::where('id', $request->id)->update([
            'title'             => $request->title,
            'engage_party_one'  => $request->party1,
            'engage_party_two'  => $request->party2,
            'updated_by'        => Auth::user()->id
        ]);

        $error = [];
        $message = '';

        if (isset($request->member_id))
        {
            foreach($request->member_id as $key => $value)
            {

                $validator = Validator::make($request->all(),[
                'member_id' => "unique:ems_member,staff_id,NULL,id,engagement_id,".$request->id.",deleted_at,NULL",
                ]);

                if ($validator->fails())
                {
                    $staff = User::where('id',$value)->first();
                    $error[] = $staff->name;
                }
                else
                {
                    EngagementMember::create([
                        'engagement_id' => $request->id,
                        'staff_id'      => $value, 
                        'created_by'    => Auth::user()->id
                    ]);
                }
            }
        }

        if($error)
        {
            $message = "[".implode(',',$error)."] already inserted";
        }

        if($message)
        {
            return redirect()->back()->withErrors([$message]);
        }

        else
        {
            return redirect()->back()->with('message','Profile updated!');
        }

    }

    public function getProgress($id)
    {
        $data = EngagementProgress::where('engagement_id', $id)->get();

        return datatables()::of($data)

        ->editColumn('date', function ($data) {

            return $data->created_at->format('d/m/Y g:ia');            
        })

        ->editColumn('status', function ($data) {

            return $data->getStatus->description;            
        })

        ->editColumn('member', function ($data) {

            return $data->memberDetails->name;            
        })

        ->editColumn('attachment', function ($data) {

           if ($data->attachement == NULL)
           {
               return "N/A";
           }
        })

        ->addColumn('action', function ($data) {
            return '<a href="#"  data-target="#edit" data-toggle="modal" data-id="' .$data->id.'" data-remark="' .$data->remark.'" data-status="' .$data->status.'"
            class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a><br>';
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function createProgress(Request $request)
    {
        $engagement = new EngagementProgress();
        $engagement->engagement_id = $request->id;
        $engagement->remark = $request->remark;
        $engagement->member = Auth::user()->id;
        $engagement->status = $request->status;
        $engagement->created_by = Auth::user()->id;
        $engagement->updated_by = Auth::user()->id;
        $engagement->save();


        return redirect()->with('message','Progress created!');
    }

    public function editProgress(Request $request)
    {
        EngagementProgress::where('id', $request->id)->update([
            'remark'     => $request->remark,
            'status'     => $request->status,
            'created_by' => Auth::user()->id
        ]);

        return redirect()->back()->with('message','Progress Updated');
    }
   
    public function deleteMember(Request $request, $id)
    {
        $data = EngagementMember::where('engagement_id', $request->id)->where('staff_id',$id)->first();
        
        $data->delete();
        $data->update([
            'deleted_by' => Auth::user()->id
        ]);

        return response() ->json(['success' => 'Deleted!']);
    }
}
