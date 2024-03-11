<?php

namespace App\Http\Controllers\Task\TaskSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TaskStatus;
use App\Http\Requests\Task\StoreTaskStatusRequest;
use DataTables;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $task = TaskStatus::CategoryId('Progress')->select('task_statuses.*');
        if($request->ajax()) {
        return DataTables::of($task)
            ->addColumn('action', function($task){
                return
                    '
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$task->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/task/task-setting/task-status/' . $task->id . '"> <i class="fal fa-trash"></i></button>
                    ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('task.task-setting.task-status.index');
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
    public function store(StoreTaskStatusRequest $request)
    {
        TaskStatus::create([
            'name' => $request->name,
            'color' => $request->color,
            'category' => 'Progress', 
        ]);

        return redirect()->back()->with('message','Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $status = TaskStatus::find($request->id);
        echo json_encode($status);
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
    public function update(StoreTaskStatusRequest $request, $id)
    {
        TaskStatus::where('id',$request->task_id)->update([
            'name' => $request->name,
            'color' => $request->color,
            'category' => 'Progress',
        ]);

        return redirect()->back()->with('message','Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TaskStatus::where('id',$id)->delete();
    }
}
