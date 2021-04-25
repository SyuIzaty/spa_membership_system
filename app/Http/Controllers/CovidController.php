<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Covid;
use App\UserType;
use App\Department;
use Carbon\Carbon;
use App\CovidNotes;
use App\Student;
use App\Jobs\SendEmail;
use App\CovidRemainder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DeclareCovidExport;
use App\Exports\UndeclareCovidExport;
use Illuminate\Support\Facades\Mail;

class CovidController extends Controller
{
    public function form()
    {
        $id = Auth::user()->id;
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
                        $date = Carbon::now()->toDateString();
                        $time = Carbon::now()->toTimeString();
                    }
                    else {
                        $category = 'E';
                        $date = Carbon::now()->toDateString();
                        $time = Carbon::now()->toTimeString();
                    }
                }
                else{
                    $category = 'C';
                    $date = Carbon::now()->toDateString();
                    $time = Carbon::now()->toTimeString();
                }
            }
            else {
                $category = 'B';
                $date = $request->declare_date2;
                $time = date("H:i:s", strtotime( $request->declare_date2 ));
            }
        }
        else{
            $category = 'A';
            $date = $request->declare_date1;
            $time = date("H:i:s", strtotime( $request->declare_date1 ));
        }

        if($request->q1 == 'N') 
        {
            $validate['q2'] = 'required'; 
        } 
        if($request->q1 == 'Y') 
        {
            $validate['declare_date1'] = 'required'; 
        }
        if($request->q2 == 'N') 
        {
            $validate['q3'] = 'required'; 
        } 
        if($request->q2 == 'Y')  
        {
            $validate['declare_date2'] = 'required'; 
        }
        if($request->q3 == 'N') 
        {
            $validate['q4a'] = 'required';
            $validate['q4b'] = 'required';
            $validate['q4c'] = 'required';
            $validate['q4d'] = 'required';
        }

        $request->validate($validate);

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
            'declare_time'    => $time,
        ]);
            
       return redirect('/declarationForm');
    }

    public function list($id)
    {
        return view('covid19.form-list');
    }

    public function new($id)
    {
        if( Auth::user()->hasRole('HR Admin') )
        { 
            $user = User::whereHas('roles')->orderBy('name')->get();
        }
        else
        {
            $user = User::whereHas('roles', function($query){
                $query->where('category', 'STU');
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
                            $date = Carbon::now()->toDateString();
                            $time = Carbon::now()->toTimeString();
                        }
                        else {
                            $category = 'E';
                            $date = Carbon::now()->toDateString();
                            $time = Carbon::now()->toTimeString();
                        }
                    }
                    else {
                        $category = 'C';
                        $date = Carbon::now()->toDateString();
                        $time = Carbon::now()->toTimeString();
                    }
                }
                else {
                    $category = 'B';
                    $date = $request->declare_date2;
                    $time = date("H:i:s", strtotime( $request->declare_date2 ));
                }
            }
            else{
                $category = 'A';
                $date = $request->declare_date1;
                $time = date("H:i:s", strtotime( $request->declare_date1 ));
            }

        $data = Covid::where('user_id', $request->user_id)->whereDate('declare_date', Carbon::parse($date)->format('Y-m-d'))->first();
        
        if(isset($data)) {

            Session::flash('notification', 'Declaration Have Been Made');
        } else {

            if($request->q1 == 'N') 
            {
                $validate['q2'] = 'required'; 
            } 
            if($request->q1 == 'Y') 
            {
                $validate['declare_date1'] = 'required'; 
            }
            if($request->q2 == 'N') 
            {
                $validate['q3'] = 'required'; 
            } 
            if($request->q2 == 'Y')  
            {
                $validate['declare_date2'] = 'required'; 
            }
            if($request->q3 == 'N') 
            {
                $validate['q4a'] = 'required';
                $validate['q4b'] = 'required';
                $validate['q4c'] = 'required';
                $validate['q4d'] = 'required';
            }

            $request->validate($validate);

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
                'declare_time'    => $time,
            ]);
            
           Session::flash('message', 'New Data Successfully Created');
        }

       return redirect('declareNew/'. $id);
    }

    public function declareInfo($id)
    {
        $all = Covid::where('id', $id)->first();
        $declare = Covid::where('id', $id)->with(['students'=>function($query) use($all){
            $query->where('students_id', $all->user_id);
        }])->first();
        return view('covid19.form-details', compact('declare'));
    }

    public function data_declare()
    {
        if( Auth::user()->hasRole('HR Admin') )
        { 
            $declare = Covid::whereDate('created_at', '=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STU')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->whereDate('created_at', '=', Carbon::now()->toDateString())->with(['user'])->get();
        }

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {
            
            if($declare->category != 'A' && $declare->category != 'B' && $declare->category != 'C') {
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
                return 'VISITOR';
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
        if( Auth::user()->hasRole('HR Admin') )
        { 
            $declare = Covid::whereDate('created_at', '!=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STU')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->whereDate('created_at', '!=', Carbon::now()->toDateString())->with(['user'])->get();
        }

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

            if($declare->category != 'A' && $declare->category != 'B' && $declare->category != 'C') {
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
                return 'VISITOR';
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

        if( Auth::user()->hasRole('HR Admin') )
        { 
            $declare = Covid::where('category', 'A')->where( 'declare_date', '>', Carbon::now()->subDays(14))->get();
        }
        else
        {
            $user = User::where('category', 'STU')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'A')->where( 'declare_date', '>', Carbon::now()->subDays(14))->with(['user'])->get();
        }

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
                return 'VISITOR';
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

            return date(' h:i:s A', strtotime($declare->declare_time) );
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

        if( Auth::user()->hasRole('HR Admin') )
        { 
            $declare = Covid::where('category', 'B')->where( 'declare_date', '>', Carbon::now()->subDays(10))->get();
        }
        else
        {
            $user = User::where('category', 'STU')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'B')->where( 'declare_date', '>', Carbon::now()->subDays(10))->with(['user'])->get();
        }

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
                return 'VISITOR';
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

            return date(' h:i:s A', strtotime($declare->declare_time) );
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
        if( Auth::user()->hasRole('HR Admin') )
        { 
            $declare = Covid::where('category', 'C')->whereDate('declare_date', '=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STU')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'C')->whereDate('declare_date', '=', Carbon::now()->toDateString())->with(['user'])->get();
        }

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
                return 'VISITOR';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_time) );
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

        if( Auth::user()->hasRole('HR Admin') )
        { 
            $declare = Covid::where('category', 'D')->whereDate('declare_date', '=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STU')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'D')->whereDate('declare_date', '=', Carbon::now()->toDateString())->with(['user'])->get();
        }

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
                return 'VISITOR';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_time) );
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

        if( Auth::user()->hasRole('HR Admin') )
        { 
            $declare = Covid::where('category', 'E')->whereDate('declare_date', '=', Carbon::now()->toDateString())->get();
        }
        else
        {
            $user = User::where('category', 'STU')->pluck('id')->toArray();
            $declare = Covid::whereIn('user_id', $user)->where('category', 'E')->whereDate('declare_date', '=', Carbon::now()->toDateString())->with(['user'])->get();
        }

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
                return 'VISITOR';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_time) );
        })
        
        ->rawColumns(['action', 'date', 'time'])
        ->addIndexColumn()
        ->make(true);
    }

    public function openForm()
    {
        $user_list = User::all();
        $type = UserType::all();
        $department = Department::orderBy('department_name')->get();
        return view('covid19.open-form', compact('department', 'type', 'user_list'));
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
                        $date = Carbon::now()->toDateString();
                        $time = Carbon::now()->toTimeString();
                    }
                    else {
                        $category = 'E';
                        $date = Carbon::now()->toDateTimeString();
                        $time = Carbon::now()->toTimeString();
                    }
                }
                else {
                    $category = 'C';
                    $date = Carbon::now()->toDateTimeString();
                    $time = Carbon::now()->toTimeString();
                }
            }
            else {
                $category = 'B';
                $date = $request->declare_date2;
                $time = date("H:i:s", strtotime( $request->declare_date2 ));
            }
        }
        else {
            $category = 'A';
            $date = $request->declare_date1;
            $time = date("H:i:s", strtotime( $request->declare_date1 ));
        }

        $data = Covid::where('user_id', $request->user_id)->whereDate('declare_date', Carbon::parse($date)->format('Y-m-d'))->first();
        
        if(isset($data)) 
        {
            Session::flash('msg', 'Your declaration on '.date(' j F Y ', strtotime($date)).' has already been made.');
        } 
        else 
        {
            if($request->user_position == 'STF' || $request->user_position == 'STD')
            {
                $validate = [
                    'user_position'   => 'required',
                    'user_id'         => 'required|regex:/^[\w-]*$/', 
                    'user_name'       => 'required', 
                    'user_phone'      => 'required|numeric',
                    'user_email'      => 'nullable|email',
                    'q1'              => 'required',
                ];

                if($request->q1 == 'N') 
                {
                    $validate['q2'] = 'required'; 
                } 
                if($request->q1 == 'Y') 
                {
                    $validate['declare_date1'] = 'required'; 
                }
                if($request->q2 == 'N') 
                {
                    $validate['q3'] = 'required'; 
                } 
                if($request->q2 == 'Y')  
                {
                    $validate['declare_date2'] = 'required'; 
                }
                if($request->q3 == 'N') 
                {
                    $validate['q4a'] = 'required';
                    $validate['q4b'] = 'required';
                    $validate['q4c'] = 'required';
                    $validate['q4d'] = 'required';
                }

                $request->validate($validate);

                $declare = Covid::create([
                    'user_name'       => $request->name,
                    'user_id'         => $request->user_id,
                    'user_email'      => $request->email,
                    'user_phone'      => $request->user_phone,
                    'department_id'   => $request->department_id,
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
                    'declare_date'    => $date,
                    'declare_time'    => $time,
                    'form_type'       => 'OF',
                    'created_by'      => $request->user_id,
                ]);

            } else {

                $request->validate([
                    'user_position'   => 'required',
                    'department_id'   => 'required',
                    'user_id'         => 'required|min:8|max:12|regex:/^[\w-]*$/', 
                    'vsr_name'        => 'required',
                    'user_phone'      => 'required|numeric',
                    'vsr_email'       => 'nullable|email',
                    'q1'              => 'required',
                ]);

                if($request->q1 == 'N') 
                {
                    $validate['q2'] = 'required'; 
                } 
                if($request->q1 == 'Y') 
                {
                    $validate['declare_date1'] = 'required'; 
                }
                if($request->q2 == 'N') 
                {
                    $validate['q3'] = 'required'; 
                } 
                if($request->q2 == 'Y')  
                {
                    $validate['declare_date2'] = 'required'; 
                }
                if($request->q3 == 'N') 
                {
                    $validate['q4a'] = 'required';
                    $validate['q4b'] = 'required';
                    $validate['q4c'] = 'required';
                    $validate['q4d'] = 'required';
                }
                
                $request->validate($validate);

                $declare = Covid::create([
                    'user_name'       => $request->vsr_name,
                    'user_id'         => $request->user_id,
                    'user_ic'         => $request->user_id,
                    'user_email'      => $request->vsr_email,
                    'user_phone'      => $request->user_phone,
                    'department_id'   => $request->department_id,
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
                    'declare_date'    => $date,
                    'declare_time'    => $time,
                    'form_type'       => 'OF',
                    'created_by'      => $request->user_id,
                ]);
            }
                
            Session::flash('message', 'Your declaration on '.date(' j F Y ', strtotime($date)).' has successfully been recorded.<br> Please make sure to abide the SOP when you are in INTEC premise. <br> Thank you for your cooperation.');
        }

       return redirect('add-form');
    }

    public function covid_all(Request $request)
    {
        // Declared Report

        if( Auth::user()->hasRole('HR Admin') )
        { 
            $name = Covid::select('user_id', 'user_name')->orderBy('user_name')->get();
        }
        else
        {
            $name = Covid::select('user_id', 'user_name')->where('user_position', 'STD')->orderBy('user_name')->get();
        }

        $category = Covid::select('category')->groupBy('category')->get();

        if( Auth::user()->hasRole('HR Admin') )
        { 
            $position = UserType::select('user_code', 'user_type')->get();
        }
        else
        {
            $position = UserType::select('user_code', 'user_type')->where('user_code', 'STD')->get();
        }

        $department = Department::select('id', 'department_name')->orderBy('department_name')->get();
        $date = Covid::select('declare_date')->groupBy('declare_date')->get();
    
        $cond = "1"; // 1 = selected

        $selectedname = $request->name; 
        $selectedcategory = $request->category;
        $selectedposition = $request->position; 
        $selecteddepartment = $request->department;
        $selecteddate = $request->date;
        $list = [];

        // Undeclared Report

        $req_date = $request->datek;
        $req_cate = $request->cates;

        if( Auth::user()->hasRole('HR Admin') )
        { 
            $datek = Covid::select('declare_date')->groupBy('declare_date')->get();
            $cates = User::select('category')->groupBy('category')->get();

            $data = $datas = $datass =  '';
        
            if($request->datek || $request->cates)
            {
                $result = new User();

                if($request->datek != "")
                {
                    $datas = collect(Covid::where('declare_date', $request->datek)->pluck('user_id'))->toArray();
                    $result = $result->whereNotIn('id', $datas); 
                    
                }

                if($request->cates != "" )
                {
                    $datas = collect(Covid::pluck('user_id'))->toArray();
                    $result = $result->whereNotIn('id', $datas)->where('category', $request->cates); 
                }

                $data = $result->get();
            }

        }
        else
        {
            $datek = Covid::select('declare_date')->groupBy('declare_date')->get();
            $cates = User::select('category')->whereHas('roles', function($query){
                $query->where('category', 'STU');
            })->groupBy('category')->get();

            $data = $datas = $datass =  '';
        
            if($request->datek || $request->cates)
            {
                $result = new User();

                if($request->datek != "")
                {
                    $datas = collect(Covid::where('declare_date', $request->datek)->pluck('user_id'))->toArray();
                    $result = $result->whereNotIn('id', $datas)->where('category', 'STU'); 
                    
                }

                if($request->cates != "" )
                {
                    $datas = collect(Covid::pluck('user_id'))->toArray();
                    $result = $result->whereNotIn('id', $datas)->where('category', $request->cates); 
                }

                $data = $result->get();
            }

        }

        $this->exportUndeclare($request->datek,$request->cates);

        $exist = CovidRemainder::whereDate('remainder_date', '=', $request->datek)->first();

        return view('covid19.covid_report', compact('exist', 'datek', 'req_date', 'req_cate', 'data', 'datas', 'name', 'category', 'cates', 'position', 'date', 'selecteddate', 'department', 'request', 'list', 'selectedname', 'selectedcategory', 'selectedposition', 'selecteddepartment'));
    }

    public function exports($name = null, $category = null, $position = null, $department = null, $date = null)
    {
        return Excel::download(new DeclareCovidExport($name, $category, $position, $department, $date), 'Covid.xlsx');
    }

    public function data_covidexport(Request $request) 
    {
        $cond = "1";
        if($request->name && $request->name != "All")
        {
            $cond .= " AND user_id = '".$request->name."' ";
        }

        if( $request->category != "" && $request->category != "All")
        {
            $cond .= " AND category = '".$request->category."' ";
        }

        if( $request->position != "" && $request->position != "All")
        {
            $cond .= " AND user_position = '".$request->position."' ";
        }

        if( $request->department != "" && $request->department != "All")
        {
            $cond .= " AND department_id = '".$request->department."' ";
        }

        if( $request->date != "" && $request->date != "All")
        {
            $cond .= " AND declare_date = '".$request->date."' ";
        }
        
        $covid = Covid::whereRaw($cond)->get();
        
        return datatables()::of($covid)

        ->editColumn('user_name', function ($covid) {

            return strtoupper(isset($covid->user_name) ? $covid->user_name : '<div style="color:red;" > -- </div>');
        })

        ->editColumn('user_ic', function ($covid) {

            return isset($covid->user_ic) ? $covid->user_ic : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('user_email', function ($covid) {

            return isset($covid->user_email) ? $covid->user_email : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('user_phone', function ($covid) {

            return isset($covid->user_phone) ? $covid->user_phone : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q1', function ($covid) {

            return isset($covid->q1) ? $covid->q1 : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q2', function ($covid) {

            return isset($covid->q2) ? $covid->q2 : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q3', function ($covid) {

            return isset($covid->q3) ? $covid->q3 : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q4a', function ($covid) {

            return isset($covid->q4a) ? $covid->q4a : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q4b', function ($covid) {

            return isset($covid->q4b) ? $covid->q4b : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q4c', function ($covid) {

            return isset($covid->q4c) ? $covid->q4c : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q4d', function ($covid) {

            return isset($covid->q4d) ? $covid->q4d : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('user_position', function ($covid) {

            return isset($covid->type->user_type) ? $covid->type->user_type : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('department_id', function ($covid) {

            return isset($covid->department->department_name) ? $covid->department->department_name : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('form_type', function ($covid) {
            if($covid->form_type == 'OF'){
                return 'Open Form';
            } else {
                return 'Private Form';
            }
        })

        ->editColumn('declare_date', function ($covid) {

            if(isset($covid->declare_date)) {

                return date(' Y-m-d ', strtotime($covid->declare_date) ).' | '.date(' H:i A ', strtotime($covid->declare_time) );
            } else {

                return 'Not Declared';
            }
            
        })

        ->editColumn('created_at', function ($covid) {

            if(isset($covid->created_at)) {

                return date(' Y-m-d | H:i A', strtotime($covid->created_at) );
            } else {

                return 'Not Created';
            }
            
        })
    
       ->rawColumns(['user_position', 'department_id', 'declare_date', 'created_at', 'user_name', 'user_ic', 'user_phone', 'user_email', 'q1', 'q2', 'q3', 'q4a', 'q4b', 'q4c', 'q4d'])
       ->make(true);
    }

    public function exportUndeclare($datek = null,$cates = null)
    {
        return Excel::download(new UndeclareCovidExport($datek, $cates),'Undeclared Covid Report.xlsx');
    }

    public function sendRemainder(Request $request, $date, $cate)
    {
        $result = new User();

        if($date != "")
        {
            $datas = collect(Covid::where('declare_date', date("Y-m-d", strtotime( $date )))->pluck('user_id'))->toArray();
            $result = $result->whereNotIn('id', $datas); 
            
        }

        if($cate != "" )
        {
            $datas = collect(Covid::pluck('user_id'))->toArray();
            $result = $result->whereNotIn('id', $datas)->where('category', $cate); 
        }

        $data = $result->whereNotNull('email')->get();

        $remainder = CovidRemainder::create([
            'remainder_date'    => date("Y-m-d", strtotime($date)),
            'status'            => 'Y',
        ]);

        $email = array_filter(array_column($data->toArray(), 'email'));
        // dd($email);
        foreach($data as $value)
        {
            $datas = [
                    'receiver_name' => $value->name,
                    'details' => $remainder->remainder_date,
                ];

            $email = $value->email;

            Mail::send('covid19.remainder', $datas, function($message) use ($email) {
                $message->to($email ?: [])->subject('PENGISIAN DATA ESARING');
                $message->from('HRadmin@intec.edu.my');
            });
        }

        Session::flash('message', 'Remainder has been sent');
        return redirect('/export_covid');
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
