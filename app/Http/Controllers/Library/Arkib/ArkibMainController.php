<?php

namespace App\Http\Controllers\Library\Arkib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Imagick;
use App\Departments;
use App\ArkibMain;
use App\ArkibAttachment;

class ArkibMainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $this->validate($request, [
            'department_code' => 'required',
            'title' => 'required|max:100',
            'description' => 'required|max:100',
            'status' => 'required',
        ]);

        $group_id = ArkibMain::insertGetId([
            'department_code' => $request->department_code,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if(isset($request->arkib_attachment)){
            foreach($request->arkib_attachment as $attach){
                $file_save = date('dmyhis').$attach->getClientOriginalName();
                $file_size = $attach->getSize();
                $attach->storeAs('/arkib',$file_save);
                ArkibAttachment::create([
                    'arkib_main_id' => $group_id,
                    'file_name' => $file_save,
                    'file_size' => $file_size,
                    'web_path' => "arkib/".$file_save,
                ]);
            }
        }

        return redirect()->back()->with('message','Data Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
