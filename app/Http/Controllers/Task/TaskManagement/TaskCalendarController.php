<?php

namespace App\Http\Controllers\Task\TaskManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Task\StoreTaskMainRequest;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\DepartmentList;
use App\TaskCategory;
use App\TaskStatus;
use App\TaskUser;
use App\TaskType;
use App\TaskMain;
use App\User;

class TaskCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = TaskType::Active()->get();
        $category = TaskCategory::Active()->get();
        $department = DepartmentList::all();
        $status = TaskStatus::all();
        $user = TaskUser::all();

        return view('task.task-management.index',compact('category','type','department','status','user'));
    }

    public function allEvent()
    {
        $tasks = TaskMain::all();

        $events = [];

        foreach ($tasks as $task) {
            $events[] = [
                'title' => $task->sub_category,
                'start' => $task->start_date,
                'end' => \Carbon\Carbon::parse($task->end_date)->addDay()->format('Y-m-d'),
                'taskId' => $task->id,
                'endDate' => $task->end_date,
                'color' => isset($task->taskUser->color) ? $task->taskUser->color : '',
                'pic' => isset($task->taskUser->short_name) ? $task->taskUser->short_name : '',
            ];
        }

        return response()->json($events);
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
    public function store(StoreTaskMainRequest $request)
    {
        foreach($request->user_id as $users){
            TaskMain::create([
                'user_id' => $users,
                'category_id' => $request->category,
                'sub_category' => $request->sub_category,
                'type_id' => $request->type,
                'detail' => $request->detail,
                'department_id' => $request->department,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'progress_id' => $request->progress,
                'priority_id' => $request->priority,
                'comment' => $request->comment,
                'email_sent' => isset($request->sent_email) ? 1 : 2,
            ]);

            $user_main = TaskUser::find($users);

            $data = [
                'app_recipient'     => isset($user_main->user->name) ? $user_main->user->name : '',
                'app_description'   => 'For your information, you have been assigned to a new task.',
            ];


            if(isset($request->sent_email)){
                Mail::send('task.task-management.mail-template', $data, function($message) use ($user_main) {
                    $message->to(isset($user_main->user->email) ? $user_main->user->email : '')->subject('Task : New Task');
                    $message->from('itadmin@intec.edu.my');
                });
            }
        }

        return redirect()->back()->with('message','Task Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $task = TaskMain::find($request->id);
        echo json_encode($task);
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
    public function update(StoreTaskMainRequest $request, $id)
    {
        TaskMain::where('id',$request->task_id)->update([
            'user_id' => $request->user_id,
            'category_id' => $request->category,
            'sub_category' => $request->sub_category,
            'type_id' => $request->type,
            'detail' => $request->detail,
            'department_id' => $request->department,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'progress_id' => $request->progress,
            'priority_id' => $request->priority,
            'comment' => $request->comment,
            'email_sent' => isset($request->sent_email) ? 1 : 2,
        ]);

        return redirect()->back()->with('message','Updated');
    }

    public function eventDate(Request $request)
    {
        $new_end_date = $request->input('new_end_date');
    
        $newEndDate = Carbon::parse($new_end_date)->subDay();
        
        TaskMain::where('id',$request->task_id)->update([
            'start_date' => $request->new_start_date,
            'end_date' => $newEndDate,
        ]);
    
        return response()->json(['message' => 'Event date updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TaskMain::where('id',$id)->delete();
    }
}
