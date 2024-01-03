<?php

namespace App\Http\Controllers\Library\Arkib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\DepartmentList;
use App\ArkibMain;
use App\ArkibStatus;
use App\ArkibStudent;
use App\ArkibAttachment;
use App\Student;
use Response;

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
        $draft = ArkibMain::Unpublished()->count();
        
        $publish = ArkibMain::Published()->count();

        $total = ArkibMain::count();

        $department = DepartmentList::all();

        $status = ArkibStatus::all();

        return view('library.arkib-main.index',compact('total','publish','draft','department','status'));
    }

    public function data_publishedarkib()
    {
        $paper = ArkibMain::with('department','arkibStatus')->Published()->select('arkib_mains.*');

        return datatables()::of($paper)
        ->addColumn('dept', function($paper){
            return isset($paper->department->name) ? Str::title($paper->department->name) : '';
        })
        ->addColumn('stat', function($paper){
            return isset($paper->arkibStatus->arkib_description) ? Str::title($paper->arkibStatus->arkib_description) : '';
        })
        ->editColumn('created_at', function ($paper) {
            return isset($paper->created_at) ? $paper->created_at->format('Y-m-d') : '';
        })
        ->addColumn('action', function ($paper) {
            
            return '
            <div class="btn-group">
            <a href="/library/arkib-main/'.$paper->id.'/edit" class="btn btn-primary btn-sm"><i class="fal fa-pencil"></i></a>
            <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/library/arkib-main/' . $paper->id . '"> <i class="fal fa-trash"></i></button>
            </div>'
            ;

        })
        ->rawColumns(['action','dept'])
        ->make(true);
    }

    public function data_draftarkib()
    {
        $paper = ArkibMain::with('department','arkibStatus')->Unpublished()->select('arkib_mains.*');

        return datatables()::of($paper)
        ->addColumn('dept', function($paper){
            return isset($paper->department->name) ? Str::title($paper->department->name) : '';
        })
        ->addColumn('stat', function($paper){
            return isset($paper->arkibStatus->arkib_description) ? Str::title($paper->arkibStatus->arkib_description) : '';
        })
        ->editColumn('created_at', function ($paper) {
            return isset($paper->created_at) ? $paper->created_at->format('Y-m-d') : '';
        })
        ->addColumn('action', function ($paper) {
            
            return '
            <div class="btn-group">
            <a href="/library/arkib-main/'.$paper->id.'/edit" class="btn btn-primary btn-sm"><i class="fal fa-pencil"></i></a>
            <button class="btn btn-sm btn-danger btn-delete2 delete" data-remote="/library/arkib-main/' . $paper->id . '"> <i class="fal fa-trash"></i></button>
            </div>'
            ;

        })
        ->rawColumns(['action','dept'])
        ->make(true);
    }

    public function reportArkib(Request $request)
    {
        $department = DepartmentList::all();

        $status = ArkibStatus::all();

        return view('library.arkib.report',compact('department','status','request'));
    }

    public function data_exportarkib(Request $request)
    {
        $cond = "1";

        if($request->from && $request->from != "All")
        {
            $cond .= " AND (arkib_mains.created_at >= '".$request->from."')";
        }

        if($request->to && $request->to != "All")
        {
            $cond .= " AND (arkib_mains.created_at <= '".$request->to."')";
        }
        
        if($request->status && $request->status != "All")
        {
            $cond .= " AND (status = '".$request->status."')";
        }

        if($request->department && $request->department != "All")
        {
            $cond .= " AND (department_code = '".$request->department."')";
        }

        $paper = ArkibMain::whereRaw($cond)->with('department','arkibStatus')->select('arkib_mains.*');

        return datatables()::of($paper)
            ->addColumn('title',function($paper)
            {
                return isset($paper->title) ? Str::title($paper->title) : '';
            })
            ->addColumn('description',function($paper)
            {
                return isset($paper->description) ? Str::title($paper->description) : '';
            })
            ->addColumn('dept',function($paper)
            {
                return isset($paper->department->department_name) ? Str::title($paper->department->department_name) : '';
            })
            ->addColumn('stat',function($paper)
            {
                return isset($paper->arkibStatus->arkib_description) ? Str::title($paper->arkibStatus->arkib_description) : '';
            })
            ->editColumn('created_at', function ($announcement) {
                return $announcement->created_at;
            })
           ->rawColumns(['dept','stat'])
           ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = DepartmentList::all();
        $status = ArkibStatus::all();

        return view('library.arkib-main.create',compact('department','status'));
    }

    public function selectSearch(Request $request)
    {
        $formatted_tags = [];

        if(isset($request->student)){
            $student = Student::where(function($query) use ($request){
                $query->where('students_name', 'LIKE', "%{$request->student}%")->orwhere('students_id', 'LIKE', "%{$request->student}%")->orwhere('students_ic', 'LIKE', "%{$request->student}%");
            })->get();
    
            foreach ($student as $students) {
                $formatted_tags[] = ['id' => $students->students_id, 'text' => $students->students_name.' ('.$students->students_id.')'];
            }
        }

        return Response::json($formatted_tags);
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
            'file_classification_no' => 'required',
            'title' => 'required|max:100',
            'description' => 'required',
            'status' => 'required',
            'arkib_attachment.*' => 'mimes:pdf'
        ]);

        $group_id = ArkibMain::insertGetId([
            'category_id' => $request->category_id,
            'department_code' => $request->department_code,
            'file_classification_no' => $request->file_classification_no,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);

        if(isset($request->student)){
            $this->arkibStudent($request, $group_id);
        }

        if(isset($request->arkib_attachment)){
            $arkib_attach = $request->arkib_attachment;

            $this->uploadAttachment($arkib_attach, $group_id);
        }
        
        return redirect()->back()->with('message','Data Added');
    }

    public function arkibStudent(Request $request, $group_id)
    {
        ArkibStudent::create([
            'arkib_id' => $group_id,
            'student_id' => $request->student,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $all = Student::where('students_id',$id)->with('programmes')->first();
        return response()->json($all);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = DepartmentList::all();

        $status = ArkibStatus::all();

        $arkib = ArkibMain::find($id);

        $attach = ArkibAttachment::ArkibMainId($id)->get();
        if($arkib->category_id == 1){
            $arkib_student = ArkibStudent::ArkibId($id)->first();
            $student = Student::where('students_id',$arkib_student->student_id)->first();
        }else{
            $arkib_student = $student = [];
        }

        return view('library.arkib.edit',compact('department','status','arkib','attach','arkib_student','student'));
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
        $this->validate($request, [
            'department_code' => 'required',
            'file_classification_no' => 'required',
            'title' => 'required|max:100',
            'description' => 'required',
            'status' => 'required',
            'arkib_attachment.*' => 'mimes:pdf'
        ]);

        ArkibMain::where('id',$id)->update([
            'department_code' => $request->department_code,
            'file_classification_no' => $request->file_classification_no,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if(isset($request->arkib_attachment)){
            $arkib_attach = $request->arkib_attachment;

            $this->uploadAttachment($arkib_attach, $id);
        }

        return redirect()->back()->with('message','Updated');
    }

    public function uploadAttachment($arkib_attach, $group_id)
    {
        foreach($arkib_attach as $attach){
            $file_save = date('dmyhis').$attach->getClientOriginalName();
            $file_size = $attach->getSize();
            // $attach->storeAs('/arkib',$file_save);
            Storage::disk('minio')->put("/arkib/".$file_save, file_get_contents($attach));
            ArkibAttachment::create([
                'arkib_main_id' => $group_id,
                'file_name' => $file_save,
                'file_size' => $file_size,
                'web_path' => "arkib/".$file_save,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paper = ArkibMain::find($id);

        $attach = ArkibAttachment::ArkibMainId($id)->get();

        foreach($attach as $attaches){
            if(Storage::disk('minio')->exists($attaches->web_path) == 'true'){
                Storage::disk('minio')->delete($attaches->web_path); 
            }

            $attaches->delete();
        }

        ArkibStudent::ArkibId($id)->delete();

        $paper->delete();
    }
}
