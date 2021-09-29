<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DateTime;
use App\Staff;
use App\ComputerGrant;
use App\ComputerGrantPurchaseProof;
use App\ComputerGrantStatus;
use App\ComputerGrantType;
use Carbon\Carbon;


class ComputerGrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_details = Staff::where('staff_id',$user->id)->first();

        $dateNow = new DateTime('now');
        $ticket = $dateNow->format('dmY') . str_pad($user->id, STR_PAD_LEFT);

        $deviceType = ComputerGrantType::all();

        return view('computer-grant.grant-form', compact('user','user_details','ticket','deviceType'));
    }

    public function datalist()
    {
        $data = ComputerGrant::with(['getStatus','getType','staff'])->where('staff_id', Auth::user()->id)->select('cgm_permohonan.*');

        return datatables()::of($data)

            ->addColumn('details',function($data)
            {
                return '<div>' .($data->staff->staff_dept). '/' 
                .($data->staff->staff_position).'</div>';
            })

            ->editColumn('status',function($data)
            {
                return $data->getStatus->first()->description ?? '';
            })

            ->editColumn('price',function($data)
            {
                return $data->price ?? 'N/A';
            })

            ->addColumn('amount',function($data)
            {
                return '<div> RM' .$data->grant_amount. '/ 60 months </div>';
            })

            ->addColumn('type',function($data)
            {
                return $data->getType->first()->description ?? 'N/A';
            })

            ->addColumn('purchase',function($data)
            {
                if (($data->brand) && ($data->model) && ($data->serial_no) != NULL)
                {
                    return '<div>' .($data->brand). '/ ' 
                    .($data->model). '/ ' .($data->serial_no). '</div>';
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('expiryDate',function($data)
            {
                if ($data->status == 4)
                {
                    $datetime = new DateTime($data->updated_at);
                    
                    $date = $datetime->format('d-m-Y');

                     return $newDate = date("d-m-Y", strtotime(date("d-m-Y", strtotime($date)) . " + 5 year"));
                }

                else
                {
                    return 'N/A';
                }
            })

            ->addColumn('remainingPeriod',function($data)
            {
                // if ($data->status == 4)
                // {
                //     $datetime = new DateTime($data->updated_at);
                    
                //     $date = $datetime->format('d-m-Y');

                //     $newDate = date("d-m-Y", strtotime(date("d-m-Y", strtotime($date)) . " + 1 year"));

                //     // $diff = $date->diff($newDate)->format('%a');  //find difference
                //     // $days = intval($diff);   //rounding days
                //     // return $days;

                //     $date1 = date("Y-m-d", strtotime($date));  //current date or any date
                //     $date2 = date("Y-m-d", strtotime($newDate));  //Future date
                //     $diff = $date2->diff($date1)->format("%a");  //find difference
                //     $days = intval($diff);   //rounding days
                //     return $days;

                // }

                // else
                // {
                    return 'N/A';
                // }
            })

            ->addColumn('penalty',function($data)
            {
                return 'N/A';
            })

            ->addColumn('action', function ($data) {

                // return '<a href="/application-detail/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>'; 
            })

            ->rawColumns(['details','type','amount','purchase','action'])
            ->make(true);
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
        $validated = $request->validate([
            'hp_no'           => 'required|regex:/(01)[0-8]{8}/',
            'office_no'       => 'required|regex:/(03)[0-8]{8}/'
        ], [
            'hp_no.regex'     => 'The phone number does not match the format',

            'office_no.regex' => 'The phone number does not match the format',

        ]);

        $user = Auth::user();
        $user_details = Staff::where('staff_id',$user->id)->first();

        $dateNow = new DateTime('now');
        $ticket = $dateNow->format('dmY') . str_pad($user->id, STR_PAD_LEFT);

        $newApplication               = new ComputerGrant();
        $newApplication->ticket_no    = $ticket;
        $newApplication->staff_id     = $user->id;
        $newApplication->hp_no        = $request->hp_no;
        $newApplication->office_no    = $request->office_no;
        $newApplication->status       = '1';
        $newApplication->grant_amount = '1500.00';
        $newApplication->created_by = Auth::user()->id;
        $newApplication->updated_by = Auth::user()->id;
        $newApplication->save();

        return redirect('/application-form');
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
