<?php

namespace App\Http\Controllers\ShortCourseManagement\People\Trainer;
use App\Models\ShortCourseManagement\ContactPerson;
use App\Models\ShortCourseManagement\Trainer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Auth;

use App\User;

class TrainerController extends Controller
{
    public function index()
    {
        //
        $users = User::all();
        return view('short-course-management.people.trainer.index', compact('users'));
    }

    public function dataTrainers()
    {
        $trainers = Trainer::orderByDesc('id')->get()->load(['events_trainers', 'user']);
        $index=0;
        foreach($trainers as $trainer){

            if (isset($trainer->events_trainers)) {
                $totalEvents = $trainer->events_trainers->count();
                // dd($totalEvents);
            } else {
                $totalEvents = 0;
            }
            $trainers[$index]->totalEvents = $totalEvents;
            $trainers[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($trainers[$index]->created_at), 'g:ia \o\n l jS F Y');
            $trainers[$index]['updated_at_toDayDateTimeString'] = date_format(new DateTime($trainers[$index]->updated_at), 'g:ia \o\n l jS F Y');
            $index+=1;
        }


        return datatables()::of($trainers)
            ->addColumn('dates', function ($trainers) {
                return 'Created At:<br>' . $trainers->created_at_toDayDateTimeString . '<br><br> Last Update:<br>' . $trainers->updated_at_toDayDateTimeString;
            })
            ->addColumn('events_trainers', function ($trainers) {
                return 'Total Events: ' . $trainers->totalEvents ;
            })
            ->addColumn('management_details', function ($trainers) {
                return 'Created By: ' . $trainers->created_by . '<br> Created At: ' . $trainers->created_at;
            })
            ->addColumn('action', function ($trainers) {
                return '
                <a href="/trainers/' . $trainers->id . '" class="btn btn-sm btn-primary">Settings</a>';
            })
            ->rawColumns(['action', 'management_details', 'events_trainers', 'dates'])
            ->make(true);

    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trainer_ic_input' => 'required',
            'trainer_user_id' => 'required',
            'trainer_fullname' => 'required',
            'trainer_phone' => 'required',
            'trainer_email' => 'required',
        ]);

        $existTrainer = Trainer::where('ic', '=', $request->trainer_ic_input)->first();

        if (!$existTrainer) {
            $existUser = User::where('id', $request->trainer_user_id)->first();
            if (!$existUser) {
                // TODO: Create User
                $existUser = User::create([
                    'id' => $request->trainer_ic_input,
                    'name' => $request->trainer_fullname,
                    'username' => $request->trainer_ic_input,
                    'email' => $request->trainer_email,
                    'active' => 'Y',
                    'category' => 'EXT',
                    'password' => Hash::make($request->trainer_ic_input),
                ]);
            }
            if ($existUser) {
                $existTrainer = Trainer::create([
                    'user_id' => $existUser->id,
                    'ic' => $request->trainer_ic_input,
                    'phone' => $request->trainer_phone,
                    'email' => $request->trainer_email,
                    'created_by' => Auth::user()->id,
                ]);
            }
        }


        $trainer = Trainer::find($existTrainer->id)->load([
            'events_trainers',
        ]);


        if (isset($trainer->events_trainers)) {
            $totalEvents = $trainer->events_trainers->count();
            // dd($totalEvents);
        } else {
            $totalEvents = 0;
        }
        $trainer->totalEvents = $totalEvents;

        return view('short-course-management.people.trainer.show', compact('trainer',));
    }
    public function show($id)
    {

        $trainer = Trainer::find($id)->load([
            'events_trainers',
        ]);


        if (isset($trainer->events_trainers)) {
            $totalEvents = $trainer->events_trainers->count();
            // dd($totalEvents);
        } else {
            $totalEvents = 0;
        }
        $trainer->totalEvents = $totalEvents;

        return view('short-course-management.people.trainer.show', compact('trainer',));

    }

    public function delete(Request $request, $id){

        $exist = Trainer::find($id);
        if (Auth::user()->id) {
            $exist->updated_by = Auth::user()->id;
            $exist->deleted_by = Auth::user()->id;
        } else {
            $exist->updated_by = "public_user";
            $exist->deleted_by = "public_user";
        }
        $exist->save();
        $exist->delete();
        return $exist;
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
            'email' => 'required',
            'ic' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Please insert event name',
            'name.max' => 'Name exceed maximum length',
            'email.required' => 'Please insert event email',
            'ic.required' => 'Please insert event ic',
            'phone.required' => 'Please insert event phone',
        ]);


        //return true or false
        $updateTrainer = Trainer::find($id)->update([
            'ic' => $request->ic,
            'phone' => $request->phone,
            'email' => $request->email,
            'updated_by' => Auth::user()->id,
        ]);

        $trainer =Trainer::find($id);

        $updateUser = User::find($trainer->user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'updated_by' => Auth::user()->id,
        ]);

        return Redirect()->back()->with('successUpdate', 'Trainer Information Updated Successfully');
    }

    public function destroy($id)
    {
        //
    }

    public function searchById($id)
    {
        //
        $trainer=Trainer::where('id', $id)->first();
        return $trainer;
    }

    public function searchByUserId($user_id)
    {
        //
        $user=User::where('id', $user_id)->first()->load(['trainer']);
        return $user;
    }

    public function searchByTrainerIc($trainer_ic)
    {
        //


        $trainer=Trainer::where('ic', $trainer_ic)->first();
        if($trainer){
            $user=User::where('id', $trainer->user_id)->first()->load(['trainer']);
        }else{
            $contact_person=ContactPerson::where('ic', $trainer_ic)->first();
            $user=User::where('id', $contact_person->user_id)->first()->load(['contact_person']);
        }

        return $user;
    }

    // public function storeTopicTrainer(Request $request, $id)
    // {
    //     // dd($request);
    //     // //
    //     $validated = $request->validate([
    //         'trainer_topic' => 'required',
    //     ], [
    //         'trainer_topic.required' => 'Please insert atleast a topic',
    //     ]);

    //     $create = TopicTrainer::create([
    //         'topic_id' => $request->trainer_topic,
    //         'trainer_id' => $id,
    //         'created_by' => Auth::user()->id,
    //         'is_active' => 1,
    //     ]);

    //     return $create;
    // }

    // public function removeTopicTrainer(Request $request, $id)
    // {

    //     $exist = TopicTrainer::find($id);
    //     if (Auth::user()->id) {
    //         $exist->updated_by = Auth::user()->id;
    //         $exist->deleted_by = Auth::user()->id;
    //     } else {
    //         $exist->updated_by = "public_user";
    //         $exist->deleted_by = "public_user";
    //     }
    //     $exist->save();
    //     $exist->delete();

    //     return Redirect()->back()->with('messageTrainerBasicDetails', 'Remove a topic Successfully');
    // }


}
