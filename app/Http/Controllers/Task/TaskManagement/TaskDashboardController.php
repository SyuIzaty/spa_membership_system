<?php

namespace App\Http\Controllers\Task\TaskManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DepartmentList;
use App\TaskStatus;
use App\TaskUser;
use App\TaskMain;
use Carbon\Carbon;

class TaskDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $task = TaskMain::whereDate('start_date', '<=', Carbon::now())
                ->whereDate('end_date', '>=', Carbon::now())
                ->paginate(7);

        return view('task.task-dashboard.index',compact('task'));
    }

    public function fetchMemberTask()
    {
        $users = TaskUser::withCount('taskMains')->get();
        return response()->json($users);
    }

    public function fetchProgressTask()
    {
        $status = TaskStatus::CategoryId('Progress')->withCount('taskProgresses')->get();
        return response()->json($status);
    }

    public function fetchDepartmentTask()
    {
        $departments = DepartmentList::all();
        $statuses = TaskStatus::where('category', 'Progress')->get();
        $status_counts = [];

        foreach ($departments as $department) {
            $status_counts[$department->id] = [];

            foreach ($statuses as $status) {
                $status_counts[$department->id][$status->id] = TaskMain::where('department_id', $department->id)
                    ->where('progress_id', $status->id)
                    ->count();
            }
        }

        return response()->json([
            'departments' => $departments,
            'statuses' => $statuses,
            'status_counts' => $status_counts,
        ]);
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

    public function userChartData($id)
    {
        $type = TaskStatus::CategoryId('Progress')->get();
        $all_progress = $total_progress = [];
        foreach ($type as $types) {
            $all_progress[] = $types->name;
            $all_color[] = $types->color;
            $total_progress[] = TaskMain::ProgressId($types->id)->UserId($id)->count();
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

    public function userPriorityData($id)
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
                $count = TaskMain::UserId($id)->where('priority_id', $priority->id)
                ->where('progress_id', $status->id)->count();
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
