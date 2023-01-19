<?php

namespace App\Http\Controllers\Library\Arkib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\ArkibMain;
use App\ArkibAttachment;
use App\ArkibStatus;
use App\Departments;
use Response;

class ArkibController extends Controller
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

    public function search(Request $request)
    {
        $department = Departments::all();

        $data = explode(" ",$request->search_data);

        $arkibs = new Collection();
        $departments = $request->department;

        if((isset($request->search_data)) || (isset($request->department))){
            foreach($data as $datas){
                if(isset($departments)){
                    $arkib = ArkibMain::where(function($query) use ($datas,$departments){
                        $query->where('title', 'LIKE', "%{$datas}%")->orwhere('description', 'LIKE', "%{$datas}%");
                    })->where('department_code',$departments)->get();
                }else{
                    $arkib = ArkibMain::where(function($query) use ($datas,$department){
                        $query->where('title', 'LIKE', "%{$datas}%")->orwhere('description', 'LIKE', "%{$datas}%");
                    })->get();
                }
    
                $arkibs = $arkibs->merge($arkib);
            }

            $arkibs = $arkibs->pluck('id');

            $main = ArkibMain::where('status','P')->whereIn('id',$arkibs)->paginate(10);
        }else{

            $main = ArkibMain::where('status','P')->paginate(10);
        }

        $main->appends(array('department'=> $request->department, 'search_data' => $request->search_data));

        if(count($main )>0){
            return view('library.arkib.index',['main'=>$main, 'department' => $department]);
        }
        if(count($main )<=0){
            return redirect()->back()->with('message','No Record');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Departments::all();

        $status = ArkibStatus::all();

        return view('library.arkib.create',compact('department','status'));
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
        return Storage::response('arkib/'.$id);
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

    public function getArkib(Request $request)
    {
        $arkib = ArkibMain::where('id',$request->id)
        ->with('department','arkibStatus','arkibAttachments')->first();

        echo json_encode($arkib);
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
