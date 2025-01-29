<?php

namespace App\Http\Controllers;

use Session;
use App\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        return view('admin-display.discount');
    }

    public function dataDiscount()
    {
        $dsc = Discount::all();

        return datatables()::of($dsc)

        ->addColumn('action', function ($dsc) {

            return '<a href="" data-target="#crud-modals" data-toggle="modal" data-discount="'.$dsc->id.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-discount/' . $dsc->id . '"><i class="fal fa-trash"></i></button>';
        })

        ->editColumn('discount_type', function ($dsc) {

            return ucfirst($dsc->discount_type);
        })

        ->editColumn('discount_value', function ($dsc) {

            if($dsc->discount_type == 'percentage'){

                $value = $dsc->discount_value.'%';

            } elseif($dsc->discount_type == 'fixed'){

                $value = 'RM'.$dsc->discount_value;
            }

            return $value;
        })

        ->addIndexColumn()
        ->rawColumns(['action','discount_type','discount_value'])
        ->make(true);
    }

    public function getDiscount($id)
    {
        $discount = Discount::where('id', $id)->first();

        return response()->json($discount);
    }

    public function storeDiscount(Request $request)
    {
        Discount::create([
            'discount_name'         => $request->discount_name,
            'discount_description'  => $request->discount_description,
            'discount_type'         => $request->discount_type,
            'discount_value'        => $request->discount_value,
            'discount_start_date'   => $request->discount_start_date,
            'discount_end_date'     => $request->discount_end_date,
        ]);

        Session::flash('message', 'Discount added successfully.');

        return redirect()->back();
    }

    public function updateDiscount(Request $request)
    {
        $discount = Discount::find($request->discount_id);

        if (!$discount) {
            return redirect()->back()->with('error', 'Discount not found.');
        }

        $discount->discount_name            = $request->name;
        $discount->discount_description     = $request->description;
        $discount->discount_type            = $request->type;
        $discount->discount_value           = $request->value;
        $discount->discount_start_date      = $request->start;
        $discount->discount_end_date        = $request->end;

        $discount->save();

        Session::flash('message', 'Discount updated successfully.');

        return redirect()->back();
    }

    public function deleteDiscount($id)
    {
        $discount = Discount::find($id);

        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $discount->delete();

        return response()->json(['message' => 'Discount deleted successfully']);
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
