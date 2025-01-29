<?php

namespace App\Http\Controllers;

use Session;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-display.service');
    }

    public function dataService()
    {
        $srv = Service::all();

        return datatables()::of($srv)

        ->addColumn('action', function ($srv) {

            return '<a href="" data-target="#crud-modals" data-toggle="modal" data-service="'.$srv->id.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-service/' . $srv->id . '"><i class="fal fa-trash"></i></button>';
        })

        ->editColumn('service_img_name', function ($srv) {
            return ' <a data-fancybox="gallery" href="' . asset('storage/service/' . $srv->service_img_name) . '">
                        <img src="' . asset('storage/service/' . $srv->service_img_name) . '" style="width:150px; height:130px;" class="img-fluid mr-2">
                    </a>';
        })

        ->addIndexColumn()
        ->rawColumns(['action', 'service_img_name'])
        ->make(true);
    }

    public function getService($id)
    {
        $service = Service::where('id', $id)->first();

        return response()->json($service);
    }

    public function storeService(Request $request)
    {
        $file = $request->file('service_img_name');

        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $storedFileName = date('dmyhi') . '-' . $originalName;

        $filePath = $file->storeAs('public/service', $storedFileName);

        Service::create([
            'service_name'        => $request->service_name,
            'service_description' => $request->service_description,
            'service_category'    => $request->service_category,
            'service_duration'    => $request->service_duration,
            'service_price'       => $request->service_price,
            'service_img_name'    => $storedFileName,
            'service_img_size'    => $fileSize,
            'service_img_path'    => $filePath,
        ]);

        Session::flash('message', 'Service added successfully.');

        return redirect()->back();
    }

    public function updateService(Request $request)
    {
        $service = Service::find($request->service_id);

        if (!$service) {
            return redirect()->back()->with('error', 'Service not found.');
        }

        $service->service_name        = $request->name;
        $service->service_description = $request->description;
        $service->service_category    = $request->category;
        $service->service_duration    = $request->duration;
        $service->service_price       = $request->price;

        if ($request->hasFile('img_name')) {
            $file = $request->file('img_name');

            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            $storedFileName = date('dmyhi') . '-' . $originalName;

            $filePath = $file->storeAs('public/service', $storedFileName);

            $service->service_img_name = $storedFileName;
            $service->service_img_size = $fileSize;
            $service->service_img_path = $filePath;
        }

        $service->save();

        Session::flash('message', 'Service updated successfully.');

        return redirect()->back();
    }

    public function deleteService($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        if (Storage::disk('public')->exists('service/' . $service->service_img_name)) {
            Storage::disk('public')->delete('service/' . $service->service_img_name);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully']);
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
