<?php

namespace App\Http\Controllers\Task\TaskSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Task\StoreTaskTypeRequest;
use App\TaskType;
use DataTables;

class TaskTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $task = TaskType::with('taskStatus','taskAduanStatus')->select('task_types.*');
        if($request->ajax()) {
        return DataTables::of($task)
            ->addColumn('task_status', function($task){
                return isset($task->taskStatus->name) ? $task->taskStatus->name : '';
            })
            ->addColumn('task_aduan_status', function($task){
                return isset($task->taskAduanStatus->name) ? $task->taskAduanStatus->name : '';
            })
            ->addColumn('action', function($task){
                return
                    '
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$task->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/task/task-setting/task-type/' . $task->id . '"> <i class="fal fa-trash"></i></button>
                    ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('task.task-setting.task-type.index');
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
    public function store(StoreTaskTypeRequest $request)
    {
        $baseColors = [
            1 => 'r',
            2 => 'g',
            3 => 'b'
        ];
        $colorMap = [];
        $minValue = 155;
        $maxValue = 200;
    
        $primaryColorIndex = rand(1, 3);
    
        $primaryColor = $baseColors[$primaryColorIndex];
        unset($baseColors[$primaryColorIndex]);
    
        $colorMap[$primaryColor] = 255;
    
        foreach($baseColors as $baseColor) {
            $colorMap[$baseColor] = rand($minValue, $maxValue);
        }
    
        krsort($colorMap);
    
        $color = '';
        foreach($colorMap as $value) {
            $color .= $value;
            if($value !== end($colorMap)) {
                $color .= ',';
            }
        }

        TaskType::create([
            'name' => $request->name,
            'color' => $color,
            'connect_aduan' => isset($request->connect_aduan) ? 1 : 2,
            'status_id' => isset($request->task_status) ? 1 : 2,
        ]);

        return redirect()->back()->with('message','Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $type = TaskType::find($request->id);
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
    public function update(StoreTaskTypeRequest $request, $id)
    {
        TaskType::where('id',$request->task_id)->update([
            'name' => $request->name,
            'connect_aduan' => isset($request->connect_aduan) ? 1 : 2,
            'status_id' => isset($request->status) ? 1 : 2,
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
