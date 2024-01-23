<?php

namespace App\Http\Controllers\Inventory;

use Auth;
use Session;
use App\User;
use App\Rental;
use App\Staff;
use App\Asset;
use App\SpaceRoom;
use App\AssetType;
use App\AssetCustodian;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class RentalManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('inventory.rental.rental-index');
    }

    public function data_rental_list()
    {
        $department = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id')->toArray();

        $data = Rental::whereHas('asset.type', function($query) use($department){
            $query->whereIn('department_id', $department);
        })->with(['staff','asset','asset.type'])->select('inv_rentals.*');

        return datatables()::of($data)

        ->addColumn('action', function ($data) {

            if($data->status == 0){

                return '<div class="btn-group"><a href="/rental-detail/' . $data->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/rental-list/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';

            } else {
                return '<div class="btn-group"><a href="/rental-detail/' . $data->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a></div>';
            }

        })

        ->editColumn('staff_id', function ($data) {

            return $data->staff->name ?? 'N/A';
        })

        ->editColumn('asset_code', function ($data) {

            return $data->asset->asset_code ?? 'N/A';
        })

        ->editColumn('asset_name', function ($data) {

            return $data->asset->asset_name ?? 'N/A';
        })

        ->editColumn('asset_type', function ($data) {

            return $data->asset->type->asset_type ?? 'N/A';
        })

        ->editColumn('checkout_date', function ($data) {

            return isset($data->checkout_date) ? date(' Y-m-d ', strtotime($data->checkout_date)) : 'N/A';
        })

        ->editColumn('return_date', function ($data) {

            return isset($data->return_date) ? date(' Y-m-d ', strtotime($data->return_date)) : 'N/A';
        })

        ->editColumn('status', function ($data) {

            if($data->status=='0')
            {
                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>CHECKOUT</b></div>';
            }
            else
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>RETURNED</b></div>';
            }
        })

        ->rawColumns(['action', 'staff_id', 'asset_code', 'asset_name', 'asset_type', 'checkout_date', 'return_date', 'status'])
        ->make(true);
    }

    public function rental_form()
    {
        $user = User::where('category', 'STF')->where('active','Y')->get();

        $department = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id')->toArray();

        $assetType = AssetType::whereIn('department_id', $department)->get();

        $space = SpaceRoom::all();

        return view('inventory.rental.rental-form', compact('user', 'assetType','space'));
    }

    public function find_renter_info(Request $request)
    {
        $data = Staff::select('*')
            ->where('staff_id', $request->id)
            ->first();

        return response()->json($data);
    }

    public function find_asset_type(Request $request)
    {
        $data = Asset::select('id', 'asset_name')
            ->where('asset_type', $request->id)
            ->where('availability', '1')
            ->get();

        return response()->json($data);
    }

    public function find_asset_info(Request $request)
    {
        $data = Asset::select('*')
            ->where('id', $request->id)
            ->first();

        return response()->json($data);
    }

    public function store_rental_detail(Request $request)
    {
        $request->validate([
            'staff_name'        => 'required',
            'asset_type'        => 'required',
            'asset_name'        => 'required',
            'checkout_date'     => 'required',
            'space_room_id'  => 'required',
            'reason'            => 'required',
        ]);

        $asset = Asset::where('id', $request->id)->first();

        $rental = Rental::create([
            'asset_id'          => $asset->id,
            'staff_id'          => $request->staff_name,
            'checkout_date'     => $request->checkout_date,
            'return_date'       => $request->return_date,
            'reason'            => $request->reason,
            'checkout_by'       => Auth::user()->id,
            'status'            => '0',
        ]);

        $asset->update([
            'availability'      => '2',
            'space_room_id'  => $request->space_room_id,
        ]);

        Session::flash('message', 'Rental Detail Have Been Successfully Recorded.');

        return redirect('/rental-list');
    }

    public function delete_rental_list($id)
    {
        $exist = Rental::find($id);

        Asset::where('id', $exist->asset_id)->update([
            'availability'      => '1',
            'space_room_id'  => '',
        ]);

        $exist->delete();

        return response()->json(['success'=>'Borrow Deleted Successfully']);
    }

    public function rental_form_detail($id)
    {
        $rental = Rental::where('id', $id)->first();

        $space = SpaceRoom::all();

        return view('inventory.rental.rental-detail', compact('rental','space'));
    }

    public function update_rental_detail(Request $request)
    {
        $request->validate([
            'return_date'        => 'required',
            'space_room_id'   => 'required',
        ]);

        $rental = Rental::where('id', $request->id)->first();

        if($rental->status == '0'){

            $rental->update([
                'return_date'   => $request->return_date,
                'return_to'     => Auth::user()->id,
                'status'        => '1',
                'remark'        => $request->remark,
            ]);

            $asset = Asset::where('id', $rental->asset_id)->first();

            $asset->update([
                'availability'      => '1',
                'space_room_id'  => $request->space_room_id,
            ]);

        } else {

            $rental->update([
                'remark'        => $request->remark,
            ]);
        }

        Session::flash('message', 'Rental Detail Have Been Successfully Updated.');

        return redirect()->back();
    }

    public function rental_reminder(Request $request)
    {
        $rental = Rental::where('id', $request->id)->first();

        $fromStaff = Staff::where('staff_id', Auth::user()->id)->first();

        $toStaff = Staff::where('staff_id',$rental->staff_id)->first();

        $data = [
            'app_description'   => 'Kindly be reminded to promptly return the rented asset, namely : '.$rental->asset->asset_name.',
                                to its respective department. Your cooperation in ensuring a timely return is highly appreciated.',
        ];

        Mail::send('inventory.rental.mail-template', $data, function($message) use ($rental, $fromStaff, $toStaff) {
            $message->to($toStaff->staff_email)->subject('Asset : Return Reminder');
            $message->from($fromStaff->staff_email);
        });

        Session::flash('message', 'The reminder for this rental have been sent to respective renter.');

        return redirect()->back();
    }

    // Renter

    public function renter_list()
    {
        return view('inventory.rental.renter-index');
    }

    public function data_renter_list()
    {
        $data = Rental::where('staff_id', Auth::user()->id)->with(['asset','asset.type'])->select('inv_rentals.*');

        return datatables()::of($data)

        ->addColumn('action', function ($data) {

            return '<div class="btn-group"><a href="/renter-detail/' . $data->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a></div>';
        })

        ->editColumn('asset_code', function ($data) {

            return $data->asset->asset_code ?? 'N/A';
        })

        ->editColumn('asset_name', function ($data) {

            return $data->asset->asset_name ?? 'N/A';
        })

        ->editColumn('asset_type', function ($data) {

            return $data->asset->type->asset_type ?? 'N/A';
        })

        ->editColumn('checkout_date', function ($data) {

            return isset($data->checkout_date) ? date(' Y-m-d ', strtotime($data->checkout_date)) : 'N/A';
        })

        ->editColumn('return_date', function ($data) {

            return isset($data->return_date) ? date(' Y-m-d ', strtotime($data->return_date)) : 'N/A';
        })

        ->editColumn('status', function ($data) {

            if($data->status=='0')
            {
                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>CHECKOUT</b></div>';
            }
            else
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>RETURNED</b></div>';
            }
        })

        ->rawColumns(['action', 'asset_code', 'asset_name', 'asset_type', 'checkout_date', 'return_date', 'status'])
        ->make(true);
    }

    public function renter_form_detail($id)
    {
        $rental = Rental::where('id', $id)->first();

        return view('inventory.rental.renter-detail', compact('rental'));
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
