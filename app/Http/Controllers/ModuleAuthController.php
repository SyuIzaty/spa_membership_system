<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModuleAuth;
use App\Http\Requests\ModuleAuthRequest;

class ModuleAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('module-auth.index');
    }

    public function data_moduleauth()
    {
        $module_auth = ModuleAuth::all();

        return datatables()::of($module_auth)
           ->addColumn('action', function ($module_auth) {
               return '<a href="/module-auth/'.$module_auth->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>
               <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/module-auth/' . $module_auth->id . '"> <i class="fal fa-trash"></i></button>';
           })
           ->rawColumns(['action'])
           ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module-auth.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleAuthRequest $request)
    {
        ModuleAuth::create($request->except(['_token']));
        return redirect()->back()->with('message', 'Module have been added');
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
        $module = ModuleAuth::find($id);
        return view('module-auth.edit',compact('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleAuthRequest $request, $id)
    {
        ModuleAuth::find($id)->update($request->all());

        return redirect()->back()->with('message', 'Module updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = ModuleAuth::find($id);
        $exist->delete();
    }
}
