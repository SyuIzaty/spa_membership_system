<?php

namespace App\Http\Controllers\Task\TaskManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\TaskUser;
use App\TaskType;
use App\TaskMain;
use App\TaskStatus;
use App\TaskCategory;
use App\DepartmentList;

class TaskReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = TaskStatus::where('category','!=','Main')->get();
        $user = TaskUser::all();
        $category = TaskCategory::all();
        $type = TaskType::all();
        $department = DepartmentList::all();
        return view('task.task-report.index',compact('status','user','category','type','department','request'));
    }

    public function data_exporttask(Request $request)
    {
        $cond = "1";

        if($request->user_id && $request->user_id != "All")
        {
            $cond .= " AND (user_id = '".$request->user_id."')";
        }
        if($request->category_id && $request->category_id != "All")
        {
            $cond .= " AND (category_id = '".$request->category_id."')";
        }
        if($request->type_id && $request->type_id != "All")
        {
            $cond .= " AND (type_id = '".$request->type_id."')";
        }
        if($request->department_id && $request->department_id != "All")
        {
            $cond .= " AND (department_id = '".$request->department_id."')";
        }
        if($request->progress_id && $request->progress_id != "All")
        {
            $cond .= " AND (progress_id = '".$request->progress_id."')";
        }
        if($request->priority_id && $request->priority_id != "All")
        {
            $cond .= " AND (priority_id = '".$request->priority_id."')";
        }

        $task = TaskMain::whereRaw($cond)->with('taskUser','taskCategory','taskType',
        'departmentList','progressStatus','priorityStatus')->select('task_mains.*');

        return datatables()::of($task)
            ->addColumn('user_name',function($task)
            {
                return isset($task->taskUser->short_name) ? Str::title($task->taskUser->short_name) : '';
            })
            ->addColumn('category_name',function($task)
            {
                return isset($task->taskCategory->name) ? Str::title($task->taskCategory->name) : '';
            })
            ->addColumn('type_name',function($task)
            {
                return isset($task->taskType->name) ? Str::title($task->taskType->name) : '';
            })
            ->addColumn('department_name',function($task)
            {
                return isset($task->departmentList->name) ? Str::title($task->departmentList->name) : '';
            })
            ->addColumn('progress_name',function($task)
            {
                return isset($task->progressStatus->name) ? Str::title($task->progressStatus->name) : '';
            })
            ->addColumn('priority_name',function($task)
            {
                return isset($task->priorityStatus->name) ? Str::title($task->priorityStatus->name) : '';
            })
           ->rawColumns(['dept','stat'])
           ->make(true);
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
