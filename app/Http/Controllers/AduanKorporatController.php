<?php

namespace App\Http\Controllers;

use App\AduanKorporat;
use App\AduanKorporatStatus;
use App\AduanKorporatCategory;
use App\AduanKorporatUser;
use App\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AduanKorporatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userCategory = AduanKorporatUser::all();
        $category = AduanKorporatCategory::all();

        return view('aduan-korporat.form', compact('userCategory','category'));
    }

    public function main()
    {
        return view('aduan-korporat.main');
    }

    public function search(Request $request)
    {
        $data = User::select('id', 'name', 'email')->where('id',$request->id)->first();

        if ($data == '')
        {
            $data = '';
            return response()->json($data);

        }

        else
        {
            return response()->json($data);
        }

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
        if($request->userCategory == "STF")
        {
            // $validated = $request->validate([
            //     'user_phone'  => 'required|min:10|max:11|numeric',
            // ]);

            $data                = new AduanKorporat();
            $data->staff_id      = $request->user_id;
            $data->name          = $request->user_name;
            $data->phone_no      = $request->user_phone;
            $data->address       = $request->address;
            $data->email         = $request->user_email;
            $data->user_category = $request->userCategory;
            $data->category      = $request->category;
            $data->status        = '1';
            $data->title         = $request->title;
            $data->description   = $request->description;
            $data->created_by    = $request->user_id;
            $data->updated_by    = $request->user_id;
            $data->save();

            $cat = AduanKorporatCategory::where('id',$request->category)->first();
            $ticket = date('dmY').$cat->code.$data->id;

            AduanKorporat::where('id', $data->id)->update(['ticket_no' => $ticket]);

            $file = $request->attachment;
            $paths = storage_path()."/eaduankorporat/";

            if (isset($file)) 
            { 
                for($y = 0; $y < count($file); $y++)
                {
                    $originalName = $file[$y]->getClientOriginalName();
                    $newFileName = $data->id."-".date('d-m-Y_hia')."(".$y.")";

                    $fileSizes = $file[$y]->getSize();
                    $fileName = $originalName;
                    $file[$y]->storeAs('/eaduankorporat', $fileName);
                    AduanKorporatFile::create([
                        'complaint_id'  => $data->id,
                        'original_name' => $originalName,
                        'upload'        => $newFileName,
                        'web_path'      => "app/eaduankorporat/".$fileName,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }

        }

        if($request->userCategory == "VSR" || $request->userCategory == "SPL" || $request->userCategory == "SPR" || $request->userCategory == "SPS")
        {
            $data                = new AduanKorporat();
            $data->ic            = $request->ic;
            $data->name          = $request->other_name;
            $data->phone_no      = $request->user_phone;
            $data->address       = $request->address;
            $data->email         = $request->other_email;
            $data->user_category = $request->userCategory;
            $data->category      = $request->category;
            $data->status        = '1';
            $data->title         = $request->title;
            $data->description   = $request->description;
            $data->created_by    = $request->ic;
            $data->updated_by    = $request->ic;
            $data->save();

            $cat = AduanKorporatCategory::where('id',$request->category)->first();
            $ticket = date('dmY').$cat->code.$data->id;

            AduanKorporat::where('id', $data->id)->update(['ticket_no' => $ticket]);

            $file = $request->attachment;
            $paths = storage_path()."/eaduankorporat/";

            if (isset($file)) 
            { 
                for($y = 0; $y < count($file); $y++)
                {
                    $originalName = $file[$y]->getClientOriginalName();
                    $newFileName = $data->id."-".date('d-m-Y_hia')."(".$y.")";

                    $fileSizes = $file[$y]->getSize();
                    $fileName = $originalName;
                    $file[$y]->storeAs('/eaduankorporat', $fileName);
                    AduanKorporatFile::create([
                        'complaint_id'  => $data->id,
                        'original_name' => $originalName,
                        'upload'        => $newFileName,
                        'web_path'      => "app/eaduankorporat/".$fileName,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }

        }

        // return redirect()->back()->with('message','Sent!');
        return response() ->json(['success' => 'SENT']);        
    }

    public function end()
    {
        return view('aduan-korporat.end');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\AduanKorporat  $aduanKorporat
     * @return \Illuminate\Http\Response
     */
    public function list($id)
    {
        $status = AduanKorporatStatus::where('id',$id)->first();
        return view('aduan-korporat.lists', compact('id','status'));
    }

    public function show($id)
    {
       if( Auth::user()->hasRole('eAduan (Admin)') )
        {
            $list = AduanKorporat::where('status', $id)->get();
        }

        else if( Auth::user()->hasRole('eAduan (IT)') )
        {
            $list = AduanKorporat::where('assign', 1)->where('status', $id)->get();
        }

        else if( Auth::user()->hasRole('eAduan (Finance)') )
        {
            $list = AduanKorporat::where('assign', 2)->where('status', $id)->get();
        }

        else if( Auth::user()->hasRole('eAduan (Corporate)') )
        {
            $list = AduanKorporat::where('assign', 3)->where('status', $id)->get();
        }

        else if( Auth::user()->hasRole('eAduan (Academic)') )
        {
            $list = AduanKorporat::where('assign', 4)->where('status', $id)->get();
        }

        else if( Auth::user()->hasRole('eAduan (Operation)') )
        {
            $list = AduanKorporat::where('assign', 5)->where('status', $id)->get();
        }

        else if( Auth::user()->hasRole('eAduan (Marketing)') )
        {
            $list = AduanKorporat::where('assign', 6)->where('status', $id)->get();
        }

        return datatables()::of($list)

        ->editColumn('ticket_no', function ($list) {

            return $list->ticket_no;            
        })

        ->editColumn('category', function ($list) {

            return $list->getCategory->description ?? '';            
        })

        ->editColumn('user', function ($list) {

            return $list->getUserCategory->description ?? '';            
        })

        ->editColumn('status', function ($list) {

            return $list->getStatus->description ?? '';            
        })

        ->editColumn('assign', function ($list) {

            return isset($list->getDepartment->name) ? $list->getDepartment->name : 'N/A';            
        })

        ->addColumn('action', function ($list) {
            
            return '<a href="/detail/' .$list->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->addColumn('log', function ($list) {
            return '<a href="/log/' .$list->id.'" class="btn btn-sm btn-primary"><i class="fal fa-list-alt"></i></a>';
        })

        ->addIndexColumn()

        ->rawColumns(['action','log'])
        ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AduanKorporat  $aduanKorporat
     * @return \Illuminate\Http\Response
     */
    public function edit(AduanKorporat $aduanKorporat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AduanKorporat  $aduanKorporat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AduanKorporat $aduanKorporat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AduanKorporat  $aduanKorporat
     * @return \Illuminate\Http\Response
     */
    public function destroy(AduanKorporat $aduanKorporat)
    {
        //
    }
}
