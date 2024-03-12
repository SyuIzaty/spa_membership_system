<?php

namespace App\Http\Controllers\Task\TaskSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Task\StoreTaskCategoryRequest;
use App\TaskCategory;
use DataTables;

class TaskCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $task = TaskCategory::with('taskStatus')->select('task_categories.*');
        if($request->ajax()) {
        return DataTables::of($task)
            ->addColumn('task_status', function($task){
                return isset($task->taskStatus->name) ? $task->taskStatus->name : '';
            })
            ->addColumn('action', function($task){
                return
                    '
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$task->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/task/task-setting/task-category/' . $task->id . '"> <i class="fal fa-trash"></i></button>
                    ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('task.task-setting.task-category.index');
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
    public function store(StoreTaskCategoryRequest $request)
    {
        TaskCategory::create([
            'name' => $request->name,
            'status_id' => isset($request->store_status) ? 1 : 2,
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
        dd('aa');
        $type = TaskCategory::find($request->id);
        echo json_encode($type);
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
    public function update(StoreTaskCategoryRequest $request, $id)
    {
        TaskCategory::where('id',$request->task_id)->update([
            'name' => $request->name,
            'status_id' => isset($request->status_id) ? 1 : 2,
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
        //
    }
}
