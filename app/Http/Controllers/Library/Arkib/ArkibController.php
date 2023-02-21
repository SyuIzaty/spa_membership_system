<?php

namespace App\Http\Controllers\Library\Arkib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\ArkibMain;
use App\ArkibView;
use App\ArkibAttachment;
use App\ArkibStatus;
use App\Departments;
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
        return view('library.arkib.search');
    }

    public function data_userarkib()
    {
        $paper = ArkibMain::with('department','arkibStatus')->Published()->select('arkib_mains.*');

        return datatables()::of($paper)
        ->addColumn('dept', function($paper){
            return isset($paper->department->department_name) ? Str::title($paper->department->department_name) : '';
        })
        ->editColumn('created_at', function ($paper) {
            return isset($paper->created_at) ? $paper->created_at->format('Y-m-d') : '';
        })
        ->addColumn('action', function ($paper) {
            
            return '<button class="btn btn-primary btn-sm edit_data float-right mb-2" data-toggle="modal" data-id='.$paper->id.' id="edit" name="edit">
            <i class="fal fa-file-pdf"></i> View
          </button>';

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
        $attach = ArkibAttachment::find($id);

        if(Storage::disk('minio')->exists($attach->web_path) == 'true'){
            Storage::disk('minio')->delete($attach->web_path); 
        }

        $attach->delete();

        return redirect()->back()->with('message','Deleted');
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
