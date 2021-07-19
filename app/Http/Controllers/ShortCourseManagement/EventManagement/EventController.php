<?php

namespace App\Http\Controllers\ShortCourseManagement\EventManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortCourseManagement\Event;
use App\User;

class EventController extends Controller
{
    public function index()
    {
        return view('short-course-management.event-management.index');
    }

    public function data()
    {
        $events = Event::all()->load(['events_participants', 'venue']);
        $index = 0;
        foreach ($events as $event) {
            if (isset($event->events_participants)) {
                $totalValidParticipants = $event->events_participants->where('is_approved', 1)->count();
                $totalParticipantsNotApprovedYet = $event->events_participants->where('is_approved', 0)->where('is_done_email_cancellation_disqualified', 0)->count();
                $totalRejected = $event->events_participants->where('is_done_email_cancellation_disqualified', 1)->count();
            } else {
                $totalValidParticipants = 0;
                $totalParticipantsNotApprovedYet = 0;
                $totalRejected = 0;
            }
            $events[$index]->totalValidParticipants = $totalValidParticipants;
            $events[$index]->totalParticipantsNotApprovedYet = $totalParticipantsNotApprovedYet;
            $events[$index]->totalRejected = $totalRejected;
            $index++;
        }
        return datatables()::of($events)
            ->addColumn('dates', function ($events) {
                return 'Date Start: ' . $events->datetime_start . '<br> Date End:' . $events->datetime_end;
            })
            ->addColumn('participant', function ($events) {
                return 'Total Valid: ' . $events->totalValidParticipants . '<br> Total Not Approved Yet:' . $events->totalParticipantsNotApprovedYet . '<br> Total Reject:' . $events->totalRejected;
            })
            ->addColumn('management_details', function ($events) {
                return 'Created By: ' . $events->created_by . '<br> Created At: ' . $events->created_at;
            })
            ->addColumn('action', function ($events) {
                return '<a href="/event/' . $events->id . '" class="btn btn-sm btn-primary">Detail</a>';
            })
            ->rawColumns(['action', 'management_details', 'participant', 'dates'])
            ->make(true);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    function show($id)
    {

        $event = Event::find($id)->load([
            'events_participants',
            'venue',
            'events_shortcourses.shortcourse',
            'events_trainers.trainer',
            'fees'
        ]);

        $trainers = array();
        foreach ($event->events_trainers as $event_trainer){
            array_push($trainers, User::find($event_trainer->trainer->user_id));
        }
        //
        return view('short-course-management.event-management.show', compact('event','trainers'));
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'datetime_start' => 'required',
            'datetime_end' => 'required',
        ], [
            'name.required' => 'Please insert event name',
            'name.max' => 'Name exceed maximum length',
            'datetime_start.required' => 'Please insert event datetime start',
            'datetime_end.required' => 'Please insert event datetime end',
        ]);

        $update = Event::find($id)->update([
            'name' => $request->name,
            'datetime_start' => $request->datetime_start,
            'datetime_end' => $request->datetime_end,
        ]);

        return Redirect()->back()->with('messageEventBasicDetails', 'Bacic Details Update Successfully');
    }
    public function destroy($id)
    {
        //
    }
}
