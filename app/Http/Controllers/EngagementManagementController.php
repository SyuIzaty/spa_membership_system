<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\EngagementManagement;
use App\EngagementProgress;
use App\EngagementStatus;
use App\EngagementMember;
use App\EngagementOrganization;
use App\EngagementFile;
use App\EngagementToDoList;
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
    public function index($id)
    {
        return view('engagement.list', compact('id'));

    }

    public function lists($id)
    {
        $user = Auth::user()->id;

        if ($id == "active")
        {
            if( Auth::user()->hasRole('Engagement (Team Member)') )
            {
                $list = EngagementManagement::wherehas('member', function($query) use ($user){
                    $query->where('staff_id', $user);
                })->where('status', '!=', 7)->get();
            }

            if( Auth::user()->hasRole('Engagement (Admin)') )
            {
                $list = EngagementManagement::where('status', '!=', 7)->get();
            }
        }

        else if ($id == "complete")
        {
            if( Auth::user()->hasRole('Engagement (Team Member)') )
            {
                $list = EngagementManagement::wherehas('member', function($query) use ($user){
                    $query->where('staff_id', $user);
                })->where('status', 7)->get();
            }

            if( Auth::user()->hasRole('Engagement (Admin)') )
            {
                $list = EngagementManagement::where('status', 7)->get();
            }
        }

        return datatables()::of($list)

        ->editColumn('status', function ($list) {

            return $list->getStatus->description;            
        })

        ->editColumn('organization', function ($list) {

            $org = EngagementOrganization::where('engagement_id', $list->id)->where('no', 1)->first();

            return isset ($org->name) ? $org->name : 'N/A';

        })

        ->editColumn('email', function ($list) {

            $org = EngagementOrganization::where('engagement_id', $list->id)->where('no', 1)->first();

            return isset ($org->email) ? $org->email : 'N/A';
        })

        ->editColumn('phone', function ($list) {

            $org = EngagementOrganization::where('engagement_id', $list->id)->where('no', 1)->first();

            return isset ($org->phone) ? $org->phone : 'N/A';
        })

        ->editColumn('designation', function ($list) {

            $org = EngagementOrganization::where('engagement_id', $list->id)->where('no', 1)->first();

            return isset ($org->designation) ? $org->designation : 'N/A';
        })

        ->addColumn('action', function ($list) {
            
            return '<a href="/engagement-detail/' .$list->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->addIndexColumn()

        ->rawColumns(['action'])
        ->make(true);
    }

    public function new()
    {
        $user = User::orderBy('name', 'ASC')->where('category', 'STF')->get();

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

    public function updateToDoList(Request $request)
    {
        //create new todo list
        if($request->newtodo)
        {
            foreach($request->newtodo as $key => $value)
            {
                EngagementToDoList::create([
                    'engagement_id' => $request->idEngage,
                    'title'         => $value, 
                    'active'         => 'Y', 
                    'created_by'    => Auth::user()->id
                ]);
            }
        }

        //update todo list
        if($request->content)
        {
            foreach($request->id as $key => $value)
            {
                EngagementToDoList::where('id', $value)->update([
                    'title'         => $request->content[$key], 
                    'updated_by'    => Auth::user()->id
                ]);
            }
        }

        // foreach($request->id as $key => $value)
        // {
        //     $update = EngagementToDoList::where('id', $value)->first();
        //     $update->update([
        //         'title' => $request->todo[$key],
        //         'updated_by'  => Auth::user()->id
        //     ]);

        //     // if ($request->check)
        //     // {
        //     //     $update = EngagementToDoList::where('id', $request->id)->first();
        //     //     $update->update([
        //     //     'active' => 'N',
        //     //     'updated_by'  => Auth::user()->id
        //     //     ]);
        //     // }

        //     // else
        //     // {
        //     //     $update = EngagementToDoList::where('id', $request->id)->first();
        //     //     $update->update([
        //     //     'active' => 'Y',
        //     //     'updated_by'  => Auth::user()->id
        //     //     ]);
        //     // }
        // }

        return redirect()->back()->with('message','To Do List updated');

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
        ], [
            'phone1.regex' => 'Phone number does not match the format',
        ]);

        $engagement = new EngagementManagement();
        $engagement->title = $request->title;
        $engagement->status = 1;
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

            $user = User::find($value);

            if(!$user->hasRole('Engagement (Team Member)'))
            {
                $user->assignRole('Engagement (Team Member)');
            }
    
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

        
        if ($request->names)
        {
            foreach($request->names as $key => $value) 
            {
                $organization = new EngagementOrganization();
                $organization->engagement_id = $engagement->id;
                $organization->name = $value;
                $organization->email = $request->email[$key];
                $organization->phone = $request->phone[$key];
                $organization->designation = $request->designation[$key];
                $organization->created_by = Auth::user()->id;
                $organization->save();
            }
        }

        if ($request->todolist)
        {
            foreach($request->todolist as $key => $value) 
            {
                EngagementToDoList::create([
                    'engagement_id' => $engagement->id,
                    'title'         => $value, 
                    'active'        => 'Y', 
                    'created_by'    => Auth::user()->id
                ]);
        
            }
        }


        return redirect('engagement-detail/'.$engagement->id)->with('message','Profile created!');
    }

    public function details($id)
    {
        $user = User::orderBy('name', 'ASC')->where('category', 'STF')->get();
        $status = EngagementStatus::all();
        $data = EngagementManagement::where('id', $id)->first();
        $member = EngagementMember::where('engagement_id', $id)->get();
        $org = EngagementOrganization::where('engagement_id', $id)->get();
        $todo = EngagementToDoList::where('engagement_id', $id)->get();

        return view('engagement.detail', compact('user','status','data','member','org','todo'));
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

        

        foreach($request->ids as $key => $value) 
        {
            EngagementOrganization::where('id', $value)->update([
                'name'          => $request->name[$key],
                'phone'         => $request->phone[$key],
                'email'         => $request->email[$key],
                'designation'   => $request->designation[$key],
                'updated_by'    => Auth::user()->id
            ]);  
        }
        

        $error = [];
        $message = '';

        if (isset($request->member_id))
        {
            foreach($request->member_id as $key => $value)
            {
                
                if (EngagementMember::where('engagement_id',$request->id)->where('staff_id', $value)->count() > 0)
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

                    $user = User::find($value);

                    if(!$user->hasRole('Engagement (Team Member)'))
                    {
                        $user->assignRole('Engagement (Team Member)');
                    }

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

        $user = Auth::user()->id; 
        
        $progress = EngagementProgress::where('id', $id)->first();

        $eID = $progress->engagement_id;

        $eStatus = EngagementProgress::wherehas('engagement', function($query) use ($eID){
            $query->where('id', $eID)->where('status', 7);
        })->first();

        $file = EngagementFile::where('progress_id',$id)->get();

        return view('engagement.edit_progress', compact('status','progress','file','eStatus','user'));
    }


    public function getProgress($id)
    {
        $data = EngagementProgress::where('engagement_id', $id)->get();


        return datatables()::of($data)

        ->editColumn('remark', function ($data) {

            return isset($data->remark) ? $data->remark : 'N/A';            
        })

        ->editColumn('date', function ($data) {

            return $data->created_at->format('d/m/Y g:ia');            
        })

        ->editColumn('status', function ($data) {

            return $data->getStatus->description;            
        })

        ->editColumn('member', function ($data) {

            return $data->memberDetails->name;            
        })


        ->addColumn('action', function ($data) {

            $user = Auth::user()->id; 
            
            $engagement = EngagementManagement::where('id', $data->engagement_id)->first();

            if ($engagement->status != 7)
            {
                if ($data->created_by == $user)
                {
                    return '<a href="/edit-progress/'.$data->id.'" class="btn btn-sm btn-primary mt-2"><i class="fal fa-eye"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete mt-2" data-remote="/delete-progress/' . $data->id . '"><i class="fal fa-trash"></i></button>';
                }
            
                else
                {
                    return '<a href="/edit-progress/'.$data->id.'" class="btn btn-sm btn-primary mt-2"><i class="fal fa-eye"></i></a>';
                }
            }

            else if ($engagement->status = 7)
            {
                return '<a href="/edit-progress/'.$data->id.'" class="btn btn-sm btn-primary mt-2"><i class="fal fa-eye"></i></a>';    
            }
        })

        ->addIndexColumn()

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

        EngagementManagement::where('id', $request->id)->update(['status' => $request->status]);

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

        $id = EngagementProgress::where('id', $request->id)->first();

        EngagementManagement::where('id', $id->engagement_id)->update(['status' => $request->status]);

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

    public function deleteProgress($id)
    {
        $exist = EngagementProgress::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);

        return response() ->json(['success' => 'Deleted!']);
    }

   
    public function deleteMember($id)
    {
        $exist = EngagementMember::where('id',$id)->first();
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);

        $user = User::find($exist->staff_id);

        $user->removeRole('Engagement (Team Member)');

        return response() ->json(['success' => 'Deleted!']);
    }
}
