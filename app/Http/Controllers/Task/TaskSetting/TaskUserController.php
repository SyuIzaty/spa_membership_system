<?php

namespace App\Http\Controllers\Task\TaskSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DepartmentList;
use App\TaskCategory;
use App\TaskStatus;
use App\TaskMain;
use App\TaskType;
use App\TaskUser;
use App\User;
use DataTables;
use Auth;

class TaskUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = TaskUser::get();
        $status = TaskStatus::where('category','!=','Main')->get();
        $user = User::where('active','Y')->get();

        return view('task.task-setting.task-user.index',compact('member','status','user'));
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
        $request->validate([
            'user_id' => 'required',
            'short_name' => 'required',
            'color' => 'required',
        ]);

        TaskUser::create([
            'user_id' => $request->user_id,
            'short_name' => $request->short_name,
            'color' => $request->color,
            'status_id' => isset($request->status_id) ? 1 : 2,
        ]);

        return redirect()->back()->with('message','Member Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $member = TaskUser::find($request->id);
        echo json_encode($member);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $main = TaskMain::UserId($id)->get();
        $status = TaskStatus::CategoryId('Progress')->get();
        $member = TaskUser::find($id);

        $task = TaskMain::UserId($id)->with('taskCategory','progressStatus','priorityStatus',
        'taskType','departmentList')->select('task_mains.*');
        if($request->ajax()) {
        return DataTables::of($task)
            ->addColumn('category_name', function($task){
                return isset($task->taskCategory->name) ? $task->taskCategory->name : '';
            })
            ->addColumn('department_name', function($task){
                return isset($task->departmentList->name) ? $task->departmentList->name : '';
            })
            ->addColumn('type_name', function($task){
                return isset($task->taskType->name) ? $task->taskType->name : '';
            })
            ->addColumn('progress_name', function($task){
                return isset($task->progressStatus->name) ? $task->progressStatus->name : '';
            })
            ->addColumn('priority_name', function($task){
                return isset($task->priorityStatus->name) ? $task->priorityStatus->name : '';
            })
            ->make(true);
        }


        return view('task.task-setting.task-user.edit',compact('main','id','member'));
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
        $request->validate([
            'user_id' => 'required',
            'short_name' => 'required',
            'color' => 'required',
        ]);

        TaskUser::where('id',$request->member_id)->update([
            'user_id' => $request->user_id,
            'short_name' => $request->short_name,
            'color' => $request->color,
            'status_id' => isset($request->status_id) ? 1 : 2,
        ]);

        return redirect()->back()->with('message','Member Added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TaskUser::where('id',$id)->delete();
    }
}
