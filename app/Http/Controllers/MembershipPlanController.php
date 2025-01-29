<?php

namespace App\Http\Controllers;

use Session;
use App\Service;
use App\PlanService;
use App\MembershipPlan;
use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    public function index()
    {
        $services = Service::all();

        return view('admin-display.membership-plan', compact('services'));
    }

    public function dataMembership()
    {
        $mbr = MembershipPlan::all();

        return datatables()::of($mbr)

        ->addColumn('action', function ($mbr) {

            return '<a href="" data-target="#crud-modals" data-toggle="modal" data-membership="'.$mbr->id.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-membership/' . $mbr->id . '"><i class="fal fa-trash"></i></button>';
        })

        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getMembership($id)
    {
        $membership = MembershipPlan::with('planServices.service')->find($id);

        $allServices = Service::all();

        $associatedServiceIds = $membership->planServices->pluck('service_id');

        return response()->json([
            'id'                    => $membership->id,
            'plan_name'             => $membership->plan_name,
            'plan_description'      => $membership->plan_description,
            'plan_price'            => $membership->plan_price,
            'plan_duration_month'   => $membership->plan_duration_month,
            'services'              => $allServices,
            'associated_service_ids' => $associatedServiceIds,
        ]);
    }

    public function storeMembership(Request $request)
    {
        MembershipPlan::create([
            'plan_name'             => $request->plan_name,
            'plan_description'      => $request->plan_description,
            'plan_price'            => $request->plan_price,
            'plan_duration_month'   => $request->plan_duration_month,
        ]);

        Session::flash('message', 'Membership added successfully.');

        return redirect()->back();
    }

    public function updateMembership(Request $request)
    {
        $membership = MembershipPlan::find($request->membership_id);

        if (!$membership) {
            return redirect()->back()->with('error', 'Membership not found.');
        }

        $membership->plan_name             = $request->name;
        $membership->plan_description      = $request->description;
        $membership->plan_price            = $request->price;
        $membership->plan_duration_month   = $request->duration;

        $membership->save();

        PlanService::where('plan_id', $membership->id)->delete();

        foreach ($request->service_id as $serviceId) {
            PlanService::create([
                'plan_id'       => $membership->id,
                'service_id'    => $serviceId,
            ]);
        }

        Session::flash('message', 'Membership updated successfully.');

        return redirect()->back();
    }

    public function deleteMembership($id)
    {
        $membership = MembershipPlan::find($id);

        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }

        $membership->delete();

        return response()->json(['message' => 'Membership deleted successfully']);
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
