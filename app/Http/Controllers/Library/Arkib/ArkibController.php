<?php

namespace App\Http\Controllers\Library\Arkib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\ArkibMain;
use App\ArkibView;
use App\ArkibStudent;
use App\Student;
use App\ArkibAttachment;
use App\ArkibStatus;
use App\DepartmentList;
use App\DocumentStaff;
use Response;
use Auth;
use DB;

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
        // return view('library.arkib.search');
        return view('library.arkib.index');
    }

    public function data_userarkib()
    {
        $staff = DocumentStaff::where('staff_id',Auth::user()->id)->pluck('department_id')->toArray();
        
        $paper = ArkibMain::with('department','arkibStatus')->whereIn('department_code',$staff)
        ->Published()->select('arkib_mains.*');

        return datatables()::of($paper)
        ->addColumn('dept', function($paper){
            return isset($paper->department->name) ? Str::title($paper->department->name) : '';
        })
        ->editColumn('created_at', function ($paper) {
            return isset($paper->created_at) ? $paper->created_at->format('Y-m-d') : '';
        })
        ->addColumn('action', function ($paper) {
            
          return '
            <div class="btn-group">
            <a href="/library/arkib/'.$paper->id.'/edit" class="btn btn-primary btn-sm"><i class="fal fa-pencil"></i></a>
            </div>'
            ;

        })
        ->rawColumns(['action','dept'])
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
        $attach = ArkibAttachment::where('file_name',$id)->first();

        $check = ArkibView::UserId(Auth::user()->id)->AttachmentId($attach->id)->first();

        if(isset($check)){
            $check->increment('total','1');
        }else{
            ArkibView::create([
                'user_id' => Auth::user()->id,
                'arkib_attachment_id' => $attach->id,
                'total' => 1,
            ]);
        }

        return Storage::disk('minio')->response('arkib/'.$id);
        // return Storage::download('arkib/'.$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arkib = ArkibMain::find($id);

        $attach = ArkibAttachment::ArkibMainId($id)->get();
        if($arkib->category_id == 1){
            $arkib_student = ArkibStudent::ArkibId($id)->first();
            $stud = Student::where('students_id',$arkib_student->student_id)->whereNull('deleted_at')->first();
        }else{
            $arkib_student = $stud = [];
        }

        return view('library.arkib.show',compact('arkib','attach','arkib_student','stud'));
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
        $attach = ArkibAttachment::find($id);

        if(Storage::disk('minio')->exists($attach->web_path) == 'true'){
            Storage::disk('minio')->delete($attach->web_path); 
        }

        $attach->delete();

        return redirect()->back()->with('message','Deleted');
    }

    public function search(Request $request)
    {
        $department = DepartmentList::all();

        $data = explode(" ",$request->search_data);

        $arkibs = new Collection();
        $departments = $request->department;

        if((isset($request->search_data)) || (isset($request->department))){
            foreach($data as $datas){
                if(isset($departments)){
                    $arkib = ArkibMain::where(function($query) use ($datas,$departments){
                        $query->where('title', 'LIKE', "%{$datas}%")->orwhere('file_classification_no', 'LIKE', "%{$datas}%");
                    })->where('department_code',$departments)->get();
                }else{
                    $arkib = ArkibMain::where(function($query) use ($datas,$department){
                        $query->where('title', 'LIKE', "%{$datas}%")->orwhere('file_classification_no', 'LIKE', "%{$datas}%");
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
}
