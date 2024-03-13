<?php

namespace App\Http\Controllers\Task\TaskManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TaskStatus;
use App\TaskUser;
use App\TaskMain;

class TaskDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = TaskStatus::where('category','!=','Main')->get();
        $main = TaskMain::all();

        return view('task.task-dashboard.index',compact('status','main'));
    }

    public function getChartData()
    {
        $type = TaskStatus::CategoryId('Progress')->get();
        $all_progress = $total_progress = [];
        foreach ($type as $types) {
            $all_progress[] = $types->name;
            $all_color[] = $types->color;
            $total_progress[] = TaskMain::ProgressId($types->id)->count();
        }

        $data = [
            'labels' => $all_progress,
            'data' => $total_progress,
            'color' => $all_color,
        ];

        return response()->json($data);
    }

    public function getPriorityData()
    {
        $priorities = TaskStatus::CategoryId('Priority')->get();
        $progress = TaskStatus::CategoryId('Progress')->get();
        $all_priorities = [];
        $datasets = [];

        foreach ($progress as $status) {
            $data = [
                'label' => $status->name,
                'data' => [],
                'backgroundColor' => $status->color,
            ];
            
            foreach ($priorities as $priority) {
                $count = TaskMain::where('priority_id', $priority->id)
                                ->where('progress_id', $status->id)
                                ->count();
                $data['data'][] = $count;
            }

            $datasets[] = $data;
        }

        foreach ($priorities as $priority) {
            $all_priorities[] = $priority->name;
        }

        $data = [
            'labels' => $all_priorities,
            'datasets' => $datasets,
        ];

        return response()->json($data);
    }

    public function getMemberData()
    {
        $users = TaskUser::Active()->get();
        $progress = TaskStatus::CategoryId('Progress')->get();
        $all_users = [];
        $datasets = [];

        foreach ($progress as $status) {
            $data = [
                'label' => $status->name,
                'data' => [],
                'backgroundColor' => $status->color,
            ];
            
            foreach ($users as $user) {
                $count = TaskMain::where('user_id', $user->id)
                                ->where('progress_id', $status->id)
                                ->count();
                $data['data'][] = $count;
            }

            $datasets[] = $data;
        }

        foreach ($users as $user) {
            $all_users[] = $user->short_name;
        }

        $data = [
            'labels' => $all_users,
            'datasets' => $datasets,
        ];

        return response()->json($data);
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
