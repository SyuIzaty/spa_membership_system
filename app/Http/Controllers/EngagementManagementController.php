<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\EngagementManagement;
use App\EngagementProgress;
use App\EngagementStatus;
use App\EngagementMember;
use App\EngagementOrganization;
use App\EngagementFile;
use App\User;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Response;


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

        ->editColumn('organization', function ($list) {

            $org = EngagementOrganization::where('engagement_id', $list->id)->where('no', 1)->first();

            if ($org != '')
            {
                return '
                '.$org->name.'<br>
                '.$org->phone.'<br>
                '.$org->email.'<br>
                '.$org->designation.'</br>
                ';
            }
        })

        ->addColumn('action', function ($list) {
            
            return '<a href="/engagement-detail/' .$list->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->rawColumns(['action','organization'])
        ->make(true);
    }

    public function new()
    {
        $user = User::orderBy('name', 'ASC')->get();

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

        $validated = $request->validate([
            'phone1' => 'required|regex:/[0-9]/|min:8|max:11',
            'email1' => 'required|email',
            'phone2' => 'nullable|regex:/[0-9]/|min:8|max:11',
            'email2' => 'nullable|email',
        ], [
            'phone1.regex' => 'Phone number does not match the format',
            'phone2.regex' => 'Phone number does not match the format',
        ]);

        $engagement = new EngagementManagement();
        $engagement->title = $request->title;
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

        EngagementOrganization::create([
            'engagement_id' => $engagement->id,
            'no'            => 1, 
            'name'          => $request->name1,
            'phone'         => $request->phone1,
            'email'         => $request->email1,
            'designation'   => $request->designation1,
            'created_by'    => Auth::user()->id
        ]);

        if ($request->name2 != '')
        {
            EngagementOrganization::create([
                'engagement_id' => $engagement->id,
                'no'            => 2, 
                'name'          => $request->name2,
                'phone'         => $request->phone2,
                'email'         => $request->email2,
                'designation'   => $request->designation2,
                'created_by'    => Auth::user()->id
            ]);    
        }

        return redirect('engagement-detail/'.$engagement->id)->with('message','Profile created!');
    }

    public function details($id)
    {
        $user = User::orderBy('name', 'ASC')->get();
        $status = EngagementStatus::all();
        $data = EngagementManagement::where('id', $id)->first();
        $member = EngagementMember::where('engagement_id', $id)->get();
        $org = EngagementOrganization::where('engagement_id', $id)->get();

        return view('engagement.detail', compact('user','status','data','member','org'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'title'      => 'required',
        ]);

        if($request->title != '')
        {
            EngagementManagement::where('id', $request->id)->update([
                'title'         => $request->title, 
                'updated_by'    => Auth::user()->id
            ]);    
        }

        EngagementOrganization::where('engagement_id', $request->id)->where('no', 1)->update([
            'name'          => $request->name1,
            'phone'         => $request->phone1,
            'email'         => $request->email1,
            'designation'   => $request->designation1,
            'updated_by'    => Auth::user()->id
        ]);  

        EngagementOrganization::where('engagement_id', $request->id)->where('no', 2)->update([
            'name'          => $request->name2,
            'phone'         => $request->phone2,
            'email'         => $request->email2,
            'designation'   => $request->designation2,
            'updated_by'    => Auth::user()->id
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

    public function newProgress($id)
    {
        $status = EngagementStatus::all();
        $data = EngagementManagement::where('id', $id)->first();

        return view('engagement.new_progress', compact('status','data'));
    }

    public function progress($id)
    {
        $status = EngagementStatus::all();
        
        $progress = EngagementProgress::where('id', $id)->first();

        $file = EngagementFile::where('progress_id',$id)->get();

        return view('engagement.edit_progress', compact('status','progress','file'));
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
            return '<a href="/edit-progress/'.$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a><br>';
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function createProgress(Request $request)
    {
        $engagement = new EngagementProgress();
        $engagement->engagement_id = $request->id;
        $engagement->content = $request->content;
        $engagement->remark = $request->remark;
        $engagement->status = $request->status;
        $engagement->created_by = Auth::user()->id;
        $engagement->updated_by = Auth::user()->id;
        $engagement->save();

        return redirect('edit-progress/'.$engagement->id)->with('message','Progress created!');
    }

    public function editProgress(Request $request)
    {
        EngagementProgress::where('id', $request->id)->update([
            'content'     => $request->content,
            'remark'     => $request->remark,
            'status'     => $request->status,
            'created_by' => Auth::user()->id
        ]);

        return redirect()->back()->with('message','Progress Updated');
    }

    public function storeFile(Request $request)
    {
        $id = EngagementProgress::where('id', $request->id)->first();
        $file = $request->file('file');
        $path=storage_path()."/engagement/";

        if (isset($file)) { 
            $originalName = $file->getClientOriginalName();
            $fileName = $originalName;
            $file->storeAs('/engagement', $fileName);
            EngagementFile::create([
                'progress_id'   => $request->id,
                'engagement_id' => $id->engagement_id,
                'upload'     => $originalName,
                'web_path'      => "app/engagement/".$fileName,
                'created_by' => Auth::user()->id

            ]);
        }

        return response()->json(['success'=>$originalName]);
    }

    public function getFile($file)
    {
        $file = EngagementFile::where('id', $file)->first();

        $path = storage_path().'/'.'app'.'/engagement/'.$file->upload;

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function deleteFile($id)
    {
        $exist = EngagementFile::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);

        return response() ->json(['success' => 'Deleted!']);
    }
   
    public function deleteMember($id)
    {
        $exist = EngagementMember::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);

        return response() ->json(['success' => 'Deleted!']);
    }
}
