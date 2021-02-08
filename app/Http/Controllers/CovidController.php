<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Session;
use Carbon\Carbon;
use App\Covid;
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
            'user_id'         => $id,
            'user_phone'      => $request->user_phone,
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
            'declare_date'    => $date,
        ]);
            
       return redirect('declarationForm/'. $id);
    }

    public function list($id)
    {
        return view('covid19.form-list');
    }

    public function new($id)
    {
        if( Auth::user()->hasRole('admin hr') )
        { 
            $user = User::whereHas('roles', function($query){
                $query->where('category', 'STF');
            })->orderBy('name')->get();
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
        $data = User::select('id', 'name', 'email')
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
        // dd($data);
        if(isset($data)) {

            Session::flash('notification', 'Declaration Have Been Made');
        } else {

            Covid::create([
                'user_id'         => $request->user_id,
                'user_phone'      => $request->user_phone,
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

            return strtoupper($declare->user->name);
        })

        ->editColumn('user_post', function ($declare) {

            if($declare->user->category == 'STF') {
                return 'STAFF';
            } else {
                return 'STUDENT';
            }
        })

        ->editColumn('follow_up', function ($declare) {

            return isset($declare->follow_up) ? $declare->follow_up : '<div style="color:red;" >--</div>';
        })
        
        ->rawColumns(['action', 'date', 'time', 'user_name', 'follow_up'])
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

            return strtoupper($declare->user->name);
        })

        ->editColumn('user_post', function ($declare) {

            if($declare->user->category == 'STF') {
                return 'STAFF';
            } else {
                return 'STUDENT';
            }
        })

        ->editColumn('follow_up', function ($declare) {

            return isset($declare->follow_up) ? $declare->follow_up : '<div style="color:red;" >--</div>';
        })
        
        ->rawColumns(['action', 'date', 'time', 'user_name', 'follow_up'])
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

            return strtoupper($declare->user->name);
        })

        ->editColumn('user_post', function ($declare) {

            if($declare->user->category == 'STF') {
                return 'STAFF';
            } else {
                return 'STUDENT';
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

            return strtoupper($declare->user->name);
        })

        ->editColumn('user_post', function ($declare) {

            if($declare->user->category == 'STF') {
                return 'STAFF';
            } else {
                return 'STUDENT';
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
        ->make(true);
    }

    public function followList($id)
    {
        $declare = Covid::where('id', $id)->first();
        $notes = CovidNotes::where('covid_id', $id)->get();
        return view('covid19.follow_note', compact('declare', 'notes'))->with('no', 1);
    }

    public function updateFollowup(Request $request) 
    {
        $declare = Covid::where('id', $request->cov)->first(); 
        $notes = CovidNotes::where('id', $request->followup_id)->first();
        
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

            return strtoupper($declare->user->name);
        })

        ->editColumn('user_post', function ($declare) {

            if($declare->user->category == 'STF') {
                return 'STAFF';
            } else {
                return 'STUDENT';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_date) );
        })
        
        ->rawColumns(['action', 'date', 'time'])
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

            return strtoupper($declare->user->name);
        })

        ->editColumn('user_post', function ($declare) {

            if($declare->user->category == 'STF') {
                return 'STAFF';
            } else {
                return 'STUDENT';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_date) );
        })
        
        ->rawColumns(['action', 'date', 'time'])
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

            return strtoupper($declare->user->name);
        })

        ->editColumn('user_post', function ($declare) {

            if($declare->user->category == 'STF') {
                return 'STAFF';
            } else {
                return 'STUDENT';
            }
        })

        ->editColumn('date', function ($declare) {

            return strtoupper(date(' j F Y', strtotime($declare->declare_date) ));
        })

        ->editColumn('time', function ($declare) {

            return date(' h:i:s A', strtotime($declare->declare_date) );
        })
        
        ->rawColumns(['action', 'date', 'time'])
        ->make(true);
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
