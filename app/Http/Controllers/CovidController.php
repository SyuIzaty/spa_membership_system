<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Session;
use Carbon\Carbon;
use App\Covid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CovidController extends Controller
{
    public function form($id)
    {
        $user = User::where('id',$id)->first();
        $declare = Covid::where('user_id', $id)->first();
        $exist = Covid::with(['user'])->where('user_id', $id)->whereDate('created_at', '=', now()->toDateString())->first();
        // dd($exist->id);
        return view('covid19.form-list', compact('user', 'declare', 'exist'));
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
                        $category = 'D';
                    else
                        $category = 'E';
                }
                else
                    $category = 'C';
            }
            else
                $category = 'B';
        }
        else
            $category = 'A';

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
        ]);
            
       return redirect('declarationForm/'. $id);
    }

    public function declareInfo($id)
    {
        
        $declare = Covid::where('id', $id)->first();
        return view('covid19.form-details', compact('declare'));
    }

    public function data_declare()
    {
        $declare = Covid::whereDate('created_at', '=', now()->toDateString())->orderBy('created_at', 'desc')->get();

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

            return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration Form</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i>  Delete</button>';
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
        
        ->rawColumns(['action', 'date', 'time', 'user_name'])
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

        if( Auth::user()->hasRole('covid admin') )
        { 
            $declare = Covid::whereDate('created_at', '!=', now()->toDateString())->orderBy('created_at', 'desc')->get();
        }
        else
        {
            $declare = Covid::whereDate('created_at', '!=', now()->toDateString())->orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();
        }

        return datatables()::of($declare)
        ->addColumn('action', function ($declare) {

        if( Auth::user()->hasRole('covid admin') )
        { 
            return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration Form</a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="/declareList/' . $declare->id . '"><i class="fal fa-trash"></i>  Delete</button>';
        }
        else
        {
            return '<a href="/declare-info/' . $declare->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i> Declaration Form</a>';
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
        
        ->rawColumns(['action', 'date', 'time', 'user_name'])
        ->make(true);
    }

    public function historyDelete($id)
    {
        $exist = Covid::find($id);
        $exist->delete();
        return response()->json(['success'=>'History Declaration Successfully Deleted']);
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
