<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Covid;
use App\Department;
use Carbon\Carbon;
use App\CovidNotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CovidController extends Controller
{
    public function form($id)
    {
        $user = User::where('id',$id)->first();
        $declare = Covid::where('user_id', $id)->latest('declare_date')->first();
        $exist = Covid::with(['user'])->where('user_id', $id)->whereDate('created_at', '=', now()->toDateString())->first();
        return view('covid19.declare-form', compact('user', 'declare', 'exist'));
    }

    public function formStore(Request $request)
    {
        $id = Auth::user();

        if($request->q1 == 'N')
        {
            if($request->q2 == 'N')
            {
                if($request->q3 == 'N')
                {
                    if($request->q4a == 'Y' || $request->q4b == 'Y' || $request->q4c == 'Y' || $request->q4d == 'Y')
                    {
                        $category = 'D';
                        $date = Carbon::now()->toDateTimeString();
                    }
                    else {
                        $category = 'E';
                        $date = Carbon::now()->toDateTimeString();
                    }
                }
                else{
                    $category = 'C';
                    $date = Carbon::now()->toDateTimeString();
                }
            }
            else {
                $category = 'B';
                $date = $request->declare_date2;
            }
        }
        else{
            $category = 'A';
            $date = $request->declare_date1;
        }

        $declare = Covid::create([
            'user_id'         => $id->id,
            'user_name'       => $id->name,
            'user_email'      => $id->email,
            'user_phone'      => $request->user_phone,
            'user_position'   => $id->category,
            'q1'              => $request->q1,
            'q2'              => $request->q2,
            'q3'              => $request->q3, 
            'q4a'             => $request->q4a, 
            'q4b'             => $request->q4b,
            'q4c'             => $request->q4c,
            'q4d'             => $request->q4d, 
            'confirmation'    => 'Y',
            'category'        => $category,
            'created_by'      => $id->id,
            'form_type'       => 'PF',
            'declare_date'    => $date,
        ]);
            
       return redirect('declarationForm/'. $id->id);
    }

    public function list($id)
    {
        return view('covid19.form-list');
    }

    public function new($id)
    {
        if( Auth::user()->hasRole('admin hr') )
        { 
            $user = User::whereHas('roles')->orderBy('name')->get();
        }
        else
        {
            $user = User::whereHas('roles', function($query){
                $query->where('category', 'STD');
            })->orderBy('name')->get();
        }
        
        $declare = Covid::where('user_id', $id)->first();
        $exist = Covid::with(['user'])->where('user_id', $id)->whereDate('created_at', '=', now()->toDateString())->first();
        
        return view('covid19.new-form', compact('user', 'declare', 'exist'));
    }

    public function findUser(Request $request)
    {
        $data = User::select('id', 'name', 'email','category')
            ->where('id',$request->id)
            ->first();

        return response()->json($data);
    }

    public function newStore(Request $request)
    {
        $id = Auth::user()->id;

        if($request->q1 == 'N')
            {
                if($request->q2 == 'N')
                {
                    if($request->q3 == 'N')
                    {
                        if($request->q4a == 'Y' || $request->q4b == 'Y' || $request->q4c == 'Y' || $request->q4d == 'Y')
                        {
                            $category = 'D';
                            $date = Carbon::now()->toDateTimeString();
                        }
                        else {
                            $category = 'E';
                            $date = Carbon::now()->toDateTimeString();
                        }
                    }
                    else {
                        $category = 'C';
                        $date = Carbon::now()->toDateTimeString();
                    }
                }
                else {
                    $category = 'B';
                    $date = $request->declare_date2;
                }
            }
            else{
                $category = 'A';
                $date = $request->declare_date1;
            }

        $data = Covid::where('user_id', $request->user_id)->whereDate('declare_date', Carbon::parse($date)->format('Y-m-d'))->first();
        
        if(isset($data)) {

            Session::flash('notification', 'Declaration Have Been Made');
        } else {

            Covid::create([
                'user_id'         => $request->user_id,
                'user_name'       => $request->name,
                'user_email'      => $request->user_email,
                'user_phone'      => $request->user_phone,
                'user_position'   => $request->user_position, 
                'q1'              => $request->q1,
                'q2'              => $request->q2,
                'q3'              => $request->q3, 
                'q4a'             => $request->q4a, 
                'q4b'             => $request->q4b,
                'q4c'             => $request->q4c,
                'q4d'             => $request->q4d, 
                'confirmation'    => 'Y',
                'category'        => $category,
                'created_by'      => $id,
                'form_type'       => 'PF',
                'declare_date'    => $date,
            ]);
            
           Session::flash('message', 'New Data Successfully Created');
        }

       return redirect('declareNew/'. $id);
    }

    public function declareInfo($id)
    {
        $declare = Covid::where('id', $id)->first();
        return view('covid19.form-details', compact('declare'));
    }

    public function data_declare()
    {
        if( Auth::user()->hasRole('admin hr') )
        { 
            $declare = Covid::whereDate('created_at', '=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STD')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->whereDate('created_at', '=', Carbon::now()->toDateString())->with(['user'])->get();
        }

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {
            
            if($declare->category != 'A' && $declare->category != 'B') {
                return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i> Delete</button>';
            } else {
                return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>
                        <a href="/followup-list/' . $declare->id.'" class="btn btn-warning btn-sm"><i class="fal fa-plus-square"></i> FollowUp</a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i> Delete</button>';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->created_at) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->created_at) );
        })

        ->editColumn('user_name', function ($declare) {

            return strtoupper($declare->user_name);
        })

        ->editColumn('user_position', function ($declare) {

            if($declare->user_position == 'STF') {
                return 'STAFF';
            } elseif($declare->user_position == 'STD') {
                return 'STUDENT';
            } else {
                return 'GUEST';
            }
        })

        ->editColumn('follow_up', function ($declare) {

            return isset($declare->follow_up) ? $declare->follow_up : '<div style="color:red;" >--</div>';
        })
        
        ->rawColumns(['action', 'date', 'time', 'user_name', 'follow_up'])
        ->addIndexColumn()
        ->make(true);
    }

    public function declareDelete($id)
    {
        $exist = Covid::find($id);
        $exist->delete();
        return response()->json(['success'=>'Declaration Form Successfully Deleted']);
    }

    public function history($id)
    {
        $user = User::where('id',$id)->first();
        $declare = Covid::where('user_id', $id)->first();
        return view('covid19.history-list', compact('user', 'declare'));
    }

    public function data_history()
    {
        if( Auth::user()->hasRole('admin hr') )
        { 
            $declare = Covid::whereDate('created_at', '!=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STD')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->whereDate('created_at', '!=', Carbon::now()->toDateString())->with(['user'])->get();
        }

        // $declare = Covid::whereDate('created_at', '!=', now()->toDateString())->get();
      
        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

            if($declare->category != 'A' && $declare->category != 'B') {
                return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i> Delete</button>';
            } else {
                return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>
                        <a href="/followup-list/' . $declare->id.'" class="btn btn-warning btn-sm"><i class="fal fa-plus-square"></i> FollowUp</a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i> Delete</button>';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->created_at) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->created_at) );
        })

        ->editColumn('user_name', function ($declare) {

            return strtoupper($declare->user_name);
        })

        ->editColumn('user_position', function ($declare) {

            if($declare->user_position == 'STF') {
                return 'STAFF';
            } elseif($declare->user_position == 'STD') {
                return 'STUDENT';
            } else {
                return 'GUEST';
            }
        })

        ->editColumn('follow_up', function ($declare) {

            return isset($declare->follow_up) ? $declare->follow_up : '<div style="color:red;" >--</div>';
        })
        
        ->rawColumns(['action', 'date', 'time', 'user_name', 'follow_up'])
        ->addIndexColumn()
        ->make(true);
    }

    public function selfHistory($id)
    {
        return view('covid19.self-history');
    }

    public function data_selfHistory()
    {

        $declare = Covid::whereDate('created_at', '!=', now()->toDateString())->where('user_id', Auth::user()->id)->get();

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

            return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>';
        })

        ->editColumn('q1', function ($declare) {

            return isset($declare->q1) ? $declare->q1 : '<div style="color:red;" >--</div>';
        })

        ->editColumn('q2', function ($declare) {

            return isset($declare->q2) ? $declare->q2 : '<div style="color:red;" >--</div>';
        })

        ->editColumn('q3', function ($declare) {

            return isset($declare->q3) ? $declare->q3 : '<div style="color:red;" >--</div>';
        })

        ->editColumn('q4a', function ($declare) {

            return isset($declare->q4a) ? $declare->q4a : '<div style="color:red;" >--</div>';
        })

        ->editColumn('q4b', function ($declare) {

            return isset($declare->q4b) ? $declare->q4b : '<div style="color:red;" >--</div>';
        })

        ->editColumn('q4c', function ($declare) {

            return isset($declare->q4c) ? $declare->q4c : '<div style="color:red;" >--</div>';
        })

        ->editColumn('q4d', function ($declare) {

            return isset($declare->q4d) ? $declare->q4d : '<div style="color:red;" >--</div>';
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->created_at) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->created_at) );
        })
        
        ->rawColumns(['action', 'date', 'time', 'q1', 'q2', 'q3', 'q4a', 'q4b', 'q4c', 'q4d'])
        ->addIndexColumn()
        ->make(true);
    }

    public function historyDelete($id)
    {
        $exist = Covid::find($id);
        $exist->delete();
        return response()->json(['success'=>'History Declaration Successfully Deleted']);
    }

    public function categoryA()
    {
        return view('covid19.categoryA');
    }

    public function data_catA()
    {

        if( Auth::user()->hasRole('admin hr') )
        { 
            $declare = Covid::where('category', 'A')->where( 'declare_date', '>', Carbon::now()->subDays(14))->get();
        }
        else
        {
            $user = User::where('category', 'STD')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'A')->where( 'declare_date', '>', Carbon::now()->subDays(14))->with(['user'])->get();
        }

        // $declare = Covid::where('category', 'A')->where( 'declare_date', '>', Carbon::now()->subDays(14))->get();

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

            return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>
                    <a href="/followup-list/' . $declare->id.'" class="btn btn-warning btn-sm"><i class="fal fa-plus-square"></i> FollowUp</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i>  Delete</button>';
        })

        ->editColumn('user_name', function ($declare) {

            return strtoupper($declare->user_name);
        })

        ->editColumn('user_position', function ($declare) {

            if($declare->user_position == 'STF') {
                return 'STAFF';
            } elseif($declare->user_position == 'STD') {
                return 'STUDENT';
            } else {
                return 'GUEST';
            }
        })

        ->editColumn('quarantine_day', function ($declare) {

            $remaining_days = Carbon::parse($declare->declare_date)->diffInDays(Carbon::now());

            if($remaining_days >= 14){
                $days = '<div style="color:red;" >ENDED</div>'; 
            }
            else{
                $days = Carbon::parse($declare->declare_date)->diffInDays(Carbon::now())+1;
                if($days != 1){
                    return $days . ' days';
                } else {
                    return $days . ' day';
                }
            }
          
            return $days;
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_date) );
        })

        ->editColumn('follow_up', function ($declare) {

            return isset($declare->follow_up) ? $declare->follow_up : '<div style="color:red;" >--</div>';
        })
        
        ->rawColumns(['action', 'date', 'time', 'quarantine_day', 'follow_up'])
        ->addIndexColumn()
        ->make(true);
    }

    public function categoryB()
    {
        return view('covid19.categoryB');
    }

    public function data_catB()
    {

        if( Auth::user()->hasRole('admin hr') )
        { 
            $declare = Covid::where('category', 'B')->where( 'declare_date', '>', Carbon::now()->subDays(10))->get();
        }
        else
        {
            $user = User::where('category', 'STD')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'B')->where( 'declare_date', '>', Carbon::now()->subDays(10))->with(['user'])->get();
        }

        // $declare = Covid::where('category', 'B')->where( 'declare_date', '>', Carbon::now()->subDays(10))->get();

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

            return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>
                    <a href="/followup-list/' . $declare->id.'" class="btn btn-warning btn-sm"><i class="fal fa-plus-square"></i> FollowUp</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i>  Delete</button>';
        })

        ->editColumn('user_name', function ($declare) {

            return strtoupper($declare->user_name);
        })

        ->editColumn('user_position', function ($declare) {

            if($declare->user_position == 'STF') {
                return 'STAFF';
            } elseif($declare->user_position == 'STD') {
                return 'STUDENT';
            } else {
                return 'GUEST';
            }
        })

        ->editColumn('quarantine_day', function ($declare) {

            $remaining_days = Carbon::parse($declare->declare_date)->diffInDays(Carbon::now());

            if($remaining_days >= 10){
                $days = '<div style="color:red;" >ENDED</div>'; 
            }
            else{
                $days = Carbon::parse($declare->declare_date)->diffInDays(Carbon::now())+1;
                if($days != 1){
                    return $days . ' days';
                } else {
                    return $days . ' day';
                }
            }
          
            return $days;
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_date) );
        })

        ->editColumn('follow_up', function ($declare) {

            return isset($declare->follow_up) ? $declare->follow_up : '<div style="color:red;" >--</div>';
        })
        
        ->rawColumns(['action', 'date', 'time', 'quarantine_day', 'follow_up'])
        ->addIndexColumn()
        ->make(true);
    }

    public function followEdit($id)
    {
        $notes = CovidNotes::where('id', $id)->first();
        $declare = Covid::where('id', $notes->covid_id)->first();
        return view('covid19.follow_edit', compact('declare', 'notes'))->with('no', 1);
    }

    public function followList($id)
    {
        $declare = Covid::where('id', $id)->first();
        $notes = CovidNotes::where('covid_id', $id)->get();
        return view('covid19.follow_note', compact('declare', 'notes'))->with('no', 1);
    }

    public function updateFollowup(Request $request) 
    {
        $declare = Covid::where('id', $request->covD)->first();
        $notes = CovidNotes::where('id', $request->cov)->first(); 
        $request->validate([
            'follow_up'       => 'nullable|max:255',
        ]);
        
        $notes->update([
            'follow_up'    => $request->follow_up,
        ]);
        
        return redirect('followup-list/'.$declare->id)->with('notify', 'Follow Up Notes Edited');
    }

    public function delFollowup($id, $cov_id)
    {
        $hd = CovidNotes::where('id',$cov_id)->first();
        $el = CovidNotes::find($id);
        $el->delete($hd);
        return redirect()->back()->with('message', 'Follow Up Notes Deleted');
    }

    public function addFollowup(Request $request)
    {    
        $declare = Covid::where('id', $request->cov)->first(); 
        $id = Auth::user()->id;

        $request->validate([
            'follow_up'       => 'nullable|max:255',
        ]);
        
        CovidNotes::create([
            'covid_id'          => $declare->id,  
            'follow_up'         => $request->follow_up,
            'created_by'        => $id,
        ]);
        
        return redirect('followup-list/'.$declare->id)->with('notification', 'New Follow Up Added');
    }

    public function categoryC()
    {
        return view('covid19.categoryC');
    }

    public function data_catC()
    {
        if( Auth::user()->hasRole('admin hr') )
        { 
            $declare = Covid::where('category', 'C')->whereDate('declare_date', '=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STD')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'C')->whereDate('declare_date', '=', Carbon::now()->toDateString())->with(['user'])->get();
        }

        // $declare = Covid::where('category', 'C')->whereDate('declare_date', '=', Carbon::now()->toDateString())->get();

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

            return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>
            <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i>  Delete</button>';
        })

        ->editColumn('user_name', function ($declare) {

            return strtoupper($declare->user_name);
        })

        ->editColumn('user_position', function ($declare) {

            if($declare->user_position == 'STF') {
                return 'STAFF';
            } elseif($declare->user_position == 'STD') {
                return 'STUDENT';
            } else {
                return 'GUEST';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_date) );
        })
        
        ->rawColumns(['action', 'date', 'time'])
        ->addIndexColumn()
        ->make(true);
    }

    public function categoryD()
    {
        return view('covid19.categoryD');
    }

    public function data_catD()
    {

        if( Auth::user()->hasRole('admin hr') )
        { 
            $declare = Covid::where('category', 'D')->whereDate('declare_date', '=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STD')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'D')->whereDate('declare_date', '=', Carbon::now()->toDateString())->with(['user'])->get();
        }

        // $declare = Covid::where('category', 'D')->whereDate('declare_date', '=', Carbon::now()->toDateString())->get();

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

            return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>
            <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })

        ->editColumn('user_name', function ($declare) {

            return strtoupper($declare->user_name);
        })

        ->editColumn('user_position', function ($declare) {

            if($declare->user_position == 'STF') {
                return 'STAFF';
            } elseif($declare->user_position == 'STD') {
                return 'STUDENT';
            } else {
                return 'GUEST';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_date) );
        })
        
        ->rawColumns(['action', 'date', 'time'])
        ->addIndexColumn()
        ->make(true);
    }

    public function categoryE()
    {
        return view('covid19.categoryE');
    }

    public function data_catE()
    {

        if( Auth::user()->hasRole('admin hr') )
        { 
            $declare = Covid::where('category', 'E')->whereDate('declare_date', '=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STD')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'E')->whereDate('declare_date', '=', Carbon::now()->toDateString())->with(['user'])->get();
        }

        // $declare = Covid::where('category', 'E')->whereDate('declare_date', '=', Carbon::now()->toDateString())->get();

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

            return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration</a>
            <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })

        ->editColumn('user_name', function ($declare) {

            return strtoupper($declare->user_name);
        })

        ->editColumn('user_position', function ($declare) {

            if($declare->user_position == 'STF') {
                return 'STAFF';
            } elseif($declare->user_position == 'STD') {
                return 'STUDENT';
            } else {
                return 'GUEST';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_date) );
        })
        
        ->rawColumns(['action', 'date', 'time'])
        ->addIndexColumn()
        ->make(true);
    }

    public function openForm()
    {
        $department = Department::orderBy('department_name')->get();
        return view('covid19.open-form', compact('department'));
    }

    public function addForm()
    {
        return view('covid19.add-form');
    }

    public function storeOpenForm(Request $request)
    {
        if($request->q1 == 'N')
        {
            if($request->q2 == 'N')
            {
                if($request->q3 == 'N')
                {
                    if($request->q4a == 'Y' || $request->q4b == 'Y' || $request->q4c == 'Y' || $request->q4d == 'Y')
                    {
                        $category = 'D';
                        $date = Carbon::now()->toDateTimeString();
                    }
                    else {
                        $category = 'E';
                        $date = Carbon::now()->toDateTimeString();
                    }
                }
                else{
                    $category = 'C';
                    $date = Carbon::now()->toDateTimeString();
                }
            }
            else {
                $category = 'B';
                $date = $request->declare_date2;
            }
        }
        else{
            $category = 'A';
            $date = $request->declare_date1;
        }

        $request->validate([
            'user_name'       => 'required',
            'user_id'         => 'required',
            'user_phone'      => 'nullable|numeric',
            'user_email'      => 'nullable|email',
            'department_id'   => 'required',
        ]);

        $declare = Covid::create([
            'user_name'       => $request->user_name,
            'user_id'         => $request->user_id,
            'user_email'      => $request->user_email,
            'user_phone'      => $request->user_phone,
            'department_id'   => $request->department_id,
            'user_position'   => 'GST',
            'q1'              => $request->q1,
            'q2'              => $request->q2,
            'q3'              => $request->q3, 
            'q4a'             => $request->q4a, 
            'q4b'             => $request->q4b,
            'q4c'             => $request->q4c,
            'q4d'             => $request->q4d, 
            'confirmation'    => 'Y',
            'category'        => $category,
            'declare_date'    => $date,
            'form_type'       => 'OF',
            'created_by'      => $request->user_id,
        ]);
            
       Session::flash('message', 'Your Declaration on '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())).' Have Been Successfully Recorded.<br> Pleas Make Sure to Abide the SOP When You Are in INTEC Premise. <br> Thank You For Your Cooperation.');
       return redirect('add-form');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
