<?php

namespace App\Http\Controllers\Library\Arkib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\ArkibMain;
use App\ArkibAttachment;
use App\ArkibStatus;
use App\Departments;
use App\Student;

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

    // public function search(Request $request)
    // {
    //     $department = Departments::all();

    //     $data = explode(" ",$request->search_data);

    //     $arkibs = new Collection();;
    //     $departments = $request->department;
    //     foreach($data as $datas){
    //         if(isset($departments)){
    //             $arkib = ArkibMain::where(function($query) use ($datas,$departments){
    //                 $query->where('title', 'LIKE', "%{$datas}%")->orwhere('description', 'LIKE', "%{$datas}%");
    //             })->where('department_code',$departments)->get();
    //         }else{
    //             $arkib = ArkibMain::where(function($query) use ($datas,$department){
    //                 $query->where('title', 'LIKE', "%{$datas}%")->orwhere('description', 'LIKE', "%{$datas}%");
    //             })->get();
    //         }

    //         $arkibs = $arkibs->merge($arkib);

    //     }

    //     $arkibs = $arkibs->pluck('id');

    //     $main = ArkibMain::where('status','P')->whereIn('id',$arkibs)->paginate(10);

    //     $main->appends(array('department'=> $request->department, 'search_data' => $request->search_data));

    //     if(count($main )>0){
    //         return view('library.arkib.index',['main'=>$main, 'department' => $department]);
    //     }
    //     if(count($main )<=0){
    //         return redirect()->back()->with('message','No Record');
    //     }
    // }

    public function search(Request $request)
    {
        $department = Departments::all();

        $data = explode(" ",$request->search_data);

        $arkibs = new Collection();
        $departments = $request->department;

        if((isset($request->search_data)) || (isset($request->department))){
            foreach($data as $datas){
                if(isset($departments)){
                    $arkib = Student::where(function($query) use ($datas,$departments){
                        // $query->where('students_name', 'LIKE', "%{$datas}%")->orwhere('students_id', 'LIKE', "%{$datas}%");
                        $query->where('students_name', 'LIKE', '%'.$datas.'%')->orwhere('students_id', 'LIKE', '%'.$datas.'%');
                    })->where('department_code',$departments)->get();
                }else{
                    $arkib = Student::where(function($query) use ($datas,$department){
                        $query->where('students_name', 'LIKE', '%'.$datas.'%')->orwhere('students_id', 'LIKE', '%'.$datas.'%');
                    })->get();
                }
    
                $arkibs = $arkibs->merge($arkib);
            }

            $arkibs = $arkibs->pluck('id');

            $main = Student::whereIn('id',$arkibs)->paginate(10);
        }else{

            $main = Student::paginate(10);
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
        $data = explode(" ",$request->search_data);

        $department = Departments::all();

        $departments = $request->department;
        if(isset($data)){
            foreach($data as $datas){
                if(isset($request->department)){
                    $arkib = ArkibMain::where(function($query) use ($datas,$departments){
                        $query->where('title', 'LIKE', "%{$datas}%")->orwhere('description', 'LIKE', "%{$datas}%");
                    })->where('department_code',$departments)->get();
                }else{
                    $arkib = ArkibMain::where(function($query) use ($datas,$departments){
                        $query->where('title', 'LIKE', "%{$datas}%")->orwhere('description', 'LIKE', "%{$datas}%");
                    })->get();
                }
    
                $arkibs = $arkib->pluck('id');
            }
        }else{
            if(isset($request->department)){
                $arkib = ArkibMain::where('department_code',$departments)->get();
            }

            $arkibs = $arkib->pluck('id');
        }

        if(isset($arkibs)){
            $main = ArkibMain::where('status','P')->whereIn('id',$arkibs)->paginate(10);
        }else{
            $main = ArkibMain::where('status','P')->paginate(10);
        }

        $request->merge(['main' => $main]);

        return view('library.arkib.index',compact('main','department'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $main = ArkibMain::find($id);

        $attach = ArkibAttachment::where('arkib_main_id',$id)->get();

        return view('library.arkib.show',compact('main','attach'));
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
