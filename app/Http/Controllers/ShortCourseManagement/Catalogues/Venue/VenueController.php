<?php

namespace App\Http\Controllers\ShortCourseManagement\Catalogues\Venue;
use App\Models\ShortCourseManagement\Venue;
use App\Models\ShortCourseManagement\Topic;
use App\Models\ShortCourseManagement\VenueType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use Auth;

class VenueController extends Controller
{
    public function index()
    {
        return view('short-course-management.catalogues.venue-catalogue.index');
    }

    public function dataVenues()
    {
        $venues = Venue::orderByDesc('id')->get()->load(['events']);
        $index=0;
        foreach($venues as $venue){

            if (isset($venue->events)) {
                $totalEvents = $venue->events->count();
            } else {
                $totalEvents = 0;
            }
            $venues[$index]->totalEvents = $totalEvents;
            $venues[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($venues[$index]->created_at), 'g:ia \o\n l jS F Y');
            $venues[$index]['updated_at_toDayDateTimeString'] = date_format(new DateTime($venues[$index]->updated_at), 'g:ia \o\n l jS F Y');
            $index+=1;
        }


        return datatables()::of($venues)
            ->addColumn('dates', function ($venues) {
                return 'Created At:<br>' . $venues->created_at_toDayDateTimeString . '<br><br> Last Update:<br>' . $venues->updated_at_toDayDateTimeString;
            })
            ->addColumn('events', function ($venues) {
                return 'Total Events: ' . $venues->totalEvents ;
            })
            ->addColumn('management_details', function ($venues) {
                return 'Created By: ' . $venues->created_by . '<br> Created At: ' . $venues->created_at;
            })
            ->addColumn('action', function ($venues) {
                return '
                <a href="/venues/' . $venues->id . '" class="btn btn-sm btn-primary">Settings</a>';
            })
            ->rawColumns(['action', 'management_details', 'events', 'dates'])
            ->make(true);

    }

    public function create()
    {
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'venue_name' => 'required',
        ], [
            'venue_name.required' => 'Please insert a name',
        ]);

        $create = Venue::create([
            'name' => $request->venue_name,
            'created_by' => Auth::user()->id,
        ]);

        $venue = Venue::find($create->id)->load([
            'events',
        ]);


        if (isset($venue->events)) {
            $totalEvents = $venue->events->count();
        } else {
            $totalEvents = 0;
        }
        $venue->totalEvents = $totalEvents;

        return redirect('/venues/' . $venue->id)->with(compact('venue'));
    }
    public function show($id)
    {

        $venue = Venue::find($id)->load([
            'events',
        ]);
        $venue_types = VenueType::all();


        if (isset($venue->events)) {
            $totalEvents = $venue->events->count();
        } else {
            $totalEvents = 0;
        }
        $venue->totalEvents = $totalEvents;

        return view('short-course-management.catalogues.venue-catalogue.show', compact('venue','venue_types'));

    }

    public function delete(Request $request, $id){

        $exist = Venue::find($id);
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
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'venue_type_id' => 'required',
        ], [
            'name.required' => 'Please insert event name',
            'name.max' => 'Name exceed maximum length',
        ]);

        $update = Venue::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'venue_type_id' => $request->venue_type_id,
            'updated_by' => Auth::user()->id,
        ]);

        return Redirect()->back()->with('successUpdate', 'Venue Information Updated Successfully');
    }

    public function destroy($id)
    {
    }

    public function searchById($id)
    {
        $venue=Venue::where('id', $id)->first();
        return $venue;
    }
}
