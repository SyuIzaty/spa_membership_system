<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Response;
use Session;
use DateTime;
use App\Staff;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\TrainingCategory;
use App\TrainingClaim;
use App\TrainingStatus;
use App\TrainingType;
use App\ClaimAttachment;
use App\TrainingHourTrail;
use App\TrainingHourYear;
use App\TrainingList;
use App\TrainingEvaluation;
use App\TrainingEvaluationHead;
use App\TrainingEvaluationQuestion;
use App\TrainingEvaluationStatus;
use App\TrainingEvaluationResult;
use App\TrainingEvaluationHeadResult;
use App\Exports\ClaimExport;
use App\Exports\LatestClaimExport;
use App\Exports\LatestRecordExport;
use App\Exports\RecordExport;
use App\Imports\BulkClaimImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class TrainingController extends Controller
{
    // Dashboard Analysis

    public function dashboard()
    {
        $year = Carbon::now()->format('Y'); 
        $years = TrainingHourYear::select('year')->orderBy('year', 'desc')->limit(3)->get();

        // Start Rank
            $trainingRank = TrainingClaim::select('training_id', DB::raw('count(*) as total'))->groupBy('training_id')->whereHas('trainings',function($query) {
                $query->whereIn('type', ['1','2']);
            })->limit(5)->orderBy('total', 'desc')->get();
            

            // $staffRank = TrainingCLaim::select('approved_hour', DB::raw('count(*) as total'))->where( DB::raw('YEAR(start_date)'), '=', $year )->get();
            // ->groupBy('approved_hour')->limit(3)->orderBy('total', 'desc')
            // dd($staffRank);
         // End Rank

        // Start PieChart
            $category = DB::table('trm_category as categories')
            ->select('categories.category_name','claims.category', DB::raw('COUNT(claims.category) as count'))
            ->leftJoin('trm_claim as claims','categories.id','=','claims.category')
            ->where(DB::raw('YEAR(claims.start_date)'), '=', $year)
            ->groupBy('categories.id','claims.category')
            ->get();

            $result[] = ['Category','Total'];
            foreach ($category as $key => $value) {
                $result[++$key] = [$value->category_name, (int)$value->count];
            }
        // End PieCart

        // Start BarChart
            $population = TrainingClaim::select(
                DB::raw("year(start_date) as year"),
                DB::raw("SUM(category) as bears"),
                DB::raw("SUM(training_id) as dolphins")) 
            ->orderBy(DB::raw("YEAR(start_date)"))
            ->groupBy(DB::raw("YEAR(start_date)"))
            ->get();
            // dd($population); 

            $res[] = ['Year', 'bears', 'dolphins'];
            foreach ($population as $key => $val) {
            $res[++$key] = [$val->year, (int)$val->bears, (int)$val->dolphins];
            }

            // return view('line-chart')
            // ->with('population', json_encode($res));
        // End Barchart
        
        

        return view('training.dashboard.analysis',compact('year','years','trainingRank'))->with('category',json_encode($result))->with('no', 1)->with('population', json_encode($res));
    }

     // Training List

     public function trainingList()
     {
         $data_evaluation = TrainingEvaluation::all();
         $data_type = TrainingType::all();
         $data_category = TrainingCategory::all();

         return view('training.parameter.training-list', compact('data_evaluation','data_type','data_category'));
     }
 
     public function data_training()
     {
         $train = TrainingList::all();
        
         return datatables()::of($train)
         ->addColumn('action', function ($train) {
 
             $exist = TrainingClaim::where('training_id', $train->id)->first();
             if(isset($exist)) {
 
                 return '<a href="/training-info/' . $train->id.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>';
 
             } else {
 
                 return '<div class="btn-group"><a href="/training-info/' . $train->id.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                         <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-training/' . $train->id . '"><i class="fal fa-trash"></i></button></div>';
             }
         })

         ->addColumn('open', function ($train) {
 
            $duration = TrainingList::where('id', $train->id)->whereDate('start_date','<=',Carbon::now())->whereDate('end_date','>=',Carbon::now())->first();

            if(isset($duration)) {

                return '<a target="_blank" href="/training-open-attendance/' . $train->id.'" class="btn btn-sm btn-info"><i class="fal fa-cog"></i></a>';

            } else {

                return '<button class="btn btn-sm btn-secondary" disabled><i class="fal fa-cog"></i></button>';
            }
        })
         
        ->editColumn('type', function ($train) {

            $type = $train->types->type_name ?? '--';

            return '<p style="text-transform : uppercase">'.$type.'</p>' ?? '--';
        })

        ->editColumn('category', function ($train) {

            $category = $train->categories->category_name ?? '--';

            return '<p style="text-transform : uppercase">'.$category.'</p>' ?? '--';
        })

        ->editColumn('title', function ($train) {

            return '<p style="text-transform : uppercase; overflow-wrap: break-word">'.$train->title.'</p>' ?? '--';
        })

        ->editColumn('date', function ($train) {

            $start = isset($train->start_date) ? date(' Y-m-d ', strtotime($train->start_date)) : 'Y-m-d';
            $end = isset($train->end_date) ? date(' Y-m-d ', strtotime($train->end_date)) : 'Y-m-d';

            if($train->start_date != null) {
                return $start.' - '.$end;
            } else {
                return '--';
            }  
        })

        ->editColumn('venue', function ($train) {
             
            return $train->venue ?? '--';
        })

        ->editColumn('claim_hour', function ($train) {
             
            return $train->claim_hour ?? '--';
        })

        ->editColumn('participant', function ($train) {
            
            $data = TrainingClaim::where('status', '2')->where('training_id', $train->id)->count();

            if($data == '0') {
                return '<p style="color : red"><b>NO PARTICIPANT</b></p>';
            } else {
                return $data;
            }
        })

        ->rawColumns(['action','evaluation','venue', 'participant', 'title', 'date', 'category', 'type', 'open'])
        ->make(true);
     }
 
     public function storeTraining(Request $request)
     {
        if($request->type == '3' && $request->type == '4') {
            // external
            $request->validate([
                'title'         => 'required',
                'type'          => 'required',
                'category'      => 'required',
                'start_date'    => 'required',
                'end_date'      => 'required',
                'start_time'    => 'required',
                'end_time'      => 'required',
                'venue'         => 'required',
                'claim_hour'    => 'required',
            ]);
        } else {
            // internal
            $request->validate([
                'title'                 => 'required',
                'type'                  => 'required',
                'category'              => 'required',
                'start_date'            => 'required',
                'end_date'              => 'required',
                'start_time'            => 'required',
                'end_time'              => 'required',
                'venue'                 => 'required',
                'claim_hour'            => 'required',
                'evaluation'            => 'required',
                'evaluation_status'     => 'required',
            ]);
        }

        $image = $request->upload_image;
        $paths = storage_path()."/training/";
 
        if (isset($image)) { 

            $originalsName = $image->getClientOriginalName();
            $fileSizes = $image->getSize();
            $fileNames = $originalsName;
            $image->storeAs('/training', $fileNames);

            TrainingList::create([
                'title'            => strtoupper($request->title), 
                'type'             => $request->type, 
                'category'         => $request->category, 
                'start_date'       => $request->start_date, 
                'end_date'         => $request->end_date, 
                'start_time'       => $request->start_time, 
                'end_time'         => $request->end_time, 
                'claim_hour'       => $request->claim_hour, 
                'venue'            => $request->venue, 
                'link'             => $request->link, 
                'evaluation'       => $request->evaluation, 
                'evaluation_status'=> $request->evaluation_status, 
                'upload_image'     => $originalsName,
                'web_path'         => "app/training/".$fileNames,
            ]);
        } else {
            TrainingList::create([
                'title'            => strtoupper($request->title), 
                'type'             => $request->type, 
                'category'         => $request->category, 
                'start_date'       => $request->start_date, 
                'end_date'         => $request->end_date, 
                'start_time'       => $request->start_time, 
                'end_time'         => $request->end_time, 
                'claim_hour'       => $request->claim_hour, 
                'venue'            => $request->venue, 
                'link'             => $request->link, 
                'evaluation'       => $request->evaluation, 
                'evaluation_status'=> $request->evaluation_status, 
            ]);
        }
         
        Session::flash('message', 'Training Info Successfully Added');
        return redirect('training-list');
     }
 
     public function updateTraining(Request $request) 
     {
         $train = TrainingList::where('id', $request->id)->first();
         
         if($request->type == '3' && $request->type == '4') {
            // external
            $request->validate([
                'title'         => 'required',
                'type'          => 'required',
                'category'      => 'required',
                'start_date'    => 'required',
                'end_date'      => 'required',
                'start_time'    => 'required',
                'end_time'      => 'required',
                'venue'         => 'required',
                'claim_hour'    => 'required',
            ]);
        } else {
            // internal
            $request->validate([
                'title'                 => 'required',
                'type'                  => 'required',
                'category'              => 'required',
                'start_date'            => 'required',
                'end_date'              => 'required',
                'start_time'            => 'required',
                'end_time'              => 'required',
                'venue'                 => 'required',
                'claim_hour'            => 'required',
                'evaluation'            => 'required',
                'evaluation_status'     => 'required',
            ]);
        }

        $image = $request->upload_image;
        $paths = storage_path()."/training/";

        if($request->type != $train->type) {
        // different type or not
            if($train->type == '3' || $train->type == '4') {
            // check former type external
                if (isset($image)) { 
                // upload image
                    $originalsName = $image->getClientOriginalName();
                    $fileSizes = $image->getSize();
                    $fileNames = $originalsName;
                    $image->storeAs('/training', $fileNames);
        
                    $train->update([
                        'title'            => strtoupper($request->title), 
                        'type'             => $request->type, 
                        'category'         => $request->category, 
                        'start_date'       => $request->start_date, 
                        'end_date'         => $request->end_date, 
                        'start_time'       => $request->start_time, 
                        'end_time'         => $request->end_time, 
                        'claim_hour'       => $request->claim_hour, 
                        'venue'            => $request->venue, 
                        'link'             => $request->link, 
                        'upload_image'     => $originalsName,
                        'web_path'         => "app/training/".$fileNames,
                        'evaluation'       => $request->evaluation, 
                        'evaluation_status'=> $request->evaluation_status,
                    ]);
                } else {
                    $train->update([
                        'title'            => strtoupper($request->title), 
                        'type'             => $request->type, 
                        'category'         => $request->category, 
                        'start_date'       => $request->start_date, 
                        'end_date'         => $request->end_date, 
                        'start_time'       => $request->start_time, 
                        'end_time'         => $request->end_time, 
                        'claim_hour'       => $request->claim_hour, 
                        'venue'            => $request->venue, 
                        'link'             => $request->link, 
                        'evaluation'       => $request->evaluation, 
                        'evaluation_status'=> $request->evaluation_status,
                    ]);
                }
            } else {
            // check former type internal
                if (isset($image)) { 
                // upload image
                    $originalsName = $image->getClientOriginalName();
                    $fileSizes = $image->getSize();
                    $fileNames = $originalsName;
                    $image->storeAs('/training', $fileNames);
        
                    $train->update([
                        'title'            => strtoupper($request->title), 
                        'type'             => $request->type, 
                        'category'         => $request->category, 
                        'start_date'       => $request->start_date, 
                        'end_date'         => $request->end_date, 
                        'start_time'       => $request->start_time, 
                        'end_time'         => $request->end_time, 
                        'claim_hour'       => $request->claim_hour, 
                        'venue'            => $request->venue, 
                        'link'             => $request->link, 
                        'evaluation'       => null, 
                        'evaluation_status'=> null,
                        'upload_image'     => $originalsName,
                        'web_path'         => "app/training/".$fileNames,
                    ]);
                } else {
                    $train->update([
                        'title'            => strtoupper($request->title), 
                        'type'             => $request->type, 
                        'category'         => $request->category, 
                        'start_date'       => $request->start_date, 
                        'end_date'         => $request->end_date, 
                        'start_time'       => $request->start_time, 
                        'end_time'         => $request->end_time, 
                        'claim_hour'       => $request->claim_hour, 
                        'venue'            => $request->venue, 
                        'link'             => $request->link, 
                        'evaluation'       => null, 
                        'evaluation_status'=> null,
                    ]);
                }
            }
        } else {
        // same type
            if($request->type == '3' || $request->type == '4') {
            // external
                if (isset($image)) { 

                    $originalsName = $image->getClientOriginalName();
                    $fileSizes = $image->getSize();
                    $fileNames = $originalsName;
                    $image->storeAs('/training', $fileNames);
        
                    $train->update([
                        'title'            => strtoupper($request->title), 
                        'type'             => $request->type, 
                        'category'         => $request->category, 
                        'start_date'       => $request->start_date, 
                        'end_date'         => $request->end_date, 
                        'start_time'       => $request->start_time, 
                        'end_time'         => $request->end_time, 
                        'claim_hour'       => $request->claim_hour, 
                        'venue'            => $request->venue, 
                        'link'             => $request->link, 
                        'upload_image'     => $originalsName,
                        'web_path'         => "app/training/".$fileNames,
                    ]);
                } else {
                    $train->update([
                        'title'            => strtoupper($request->title), 
                        'type'             => $request->type, 
                        'category'         => $request->category, 
                        'start_date'       => $request->start_date, 
                        'end_date'         => $request->end_date, 
                        'start_time'       => $request->start_time, 
                        'end_time'         => $request->end_time, 
                        'claim_hour'       => $request->claim_hour, 
                        'venue'            => $request->venue, 
                        'link'             => $request->link, 
                    ]);
                }
            } else {
            // internal
                if (isset($image)) { 

                    $originalsName = $image->getClientOriginalName();
                    $fileSizes = $image->getSize();
                    $fileNames = $originalsName;
                    $image->storeAs('/training', $fileNames);
        
                    $train->update([
                        'title'            => strtoupper($request->title), 
                        'type'             => $request->type, 
                        'category'         => $request->category, 
                        'start_date'       => $request->start_date, 
                        'end_date'         => $request->end_date, 
                        'start_time'       => $request->start_time, 
                        'end_time'         => $request->end_time, 
                        'claim_hour'       => $request->claim_hour, 
                        'venue'            => $request->venue,
                        'link'             => $request->link,  
                        'evaluation'       => $request->evaluation, 
                        'evaluation_status'=> $request->evaluation_status,
                        'upload_image'     => $originalsName,
                        'web_path'         => "app/training/".$fileNames,
                    ]);
                } else {
                    $train->update([
                        'title'            => strtoupper($request->title), 
                        'type'             => $request->type, 
                        'category'         => $request->category, 
                        'start_date'       => $request->start_date, 
                        'end_date'         => $request->end_date, 
                        'start_time'       => $request->start_time, 
                        'end_time'         => $request->end_time, 
                        'claim_hour'       => $request->claim_hour, 
                        'venue'            => $request->venue, 
                        'link'             => $request->link, 
                        'evaluation'       => $request->evaluation, 
                        'evaluation_status'=> $request->evaluation_status,
                    ]);
                }
            }
        }

        Session::flash('notification', 'Training Info Successfully Updated');
        return redirect('training-info/'.$train->id);
     }
 
     public function deleteTraining($id)
     {
         $exist = TrainingList::find($id);
         $exist->delete();
 
         return redirect('training-list');
     }

     public function trainingInfo($id)
     {
        $train = TrainingList::where('id', $id)->first();
        $data_evaluation = TrainingEvaluation::all();
        $data_type = TrainingType::all();
        $data_category = TrainingCategory::all();
        $participant = TrainingClaim::where('training_id', $id)->where('status', '2')->get();

        return view('training.parameter.training-info', compact('train','data_evaluation','data_type','data_category','participant'))->with('no', 1);
     }

     public function trainingPdf($id)
     {
         $train = TrainingList::where('id', $id)->first();
         $participant = TrainingClaim::where('training_id', $id)->where('status', '2')->get();

         return view('training.parameter.training-pdf', compact('train','participant'))->with('no', 1);
     }

     public function getImage($file)
    {
        $path = storage_path().'/'.'app'.'/training/'.$file;

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function trainingEvaluation($id, $staff)
    {
        $staff = Staff::where('staff_id', $staff)->first();
        $training = TrainingList::where('id', $id)->first();
        $trainingHead = TrainingEvaluationHead::orderBy('sequence', 'ASC')->where('evaluation_id', $training->evaluation)->get();
        $trainingResult = TrainingEvaluationResult::where('staff_id', $staff->staff_id)->where('training_id', $id)->get(); 
        
        return view('training.parameter.training-evaluation',compact('training','trainingHead','trainingResult','staff'));
    }

    // Open Attendance

    public function openAttendance($id, Request $request)
    {  
        $data = $data2 = $data3 =  '';

        if($request->ids)
        {
            $result = new Staff();

            if($request->ids != "")
            {
                $result = $result->where('staff_id', $request->ids)->orWhere('staff_ic', $request->ids);
            }
            
            $data = $result->first();
        }

        $training = TrainingList::where('id', $id)->first();
        $duration = TrainingList::where('id', $id)->whereDate('start_date','<=', \Carbon\Carbon::today())->whereDate('end_date','>=', \Carbon\Carbon::today())->first();
             
        return view('training.parameter.training-open', compact('data','request','training','duration'));
    }

    public function confirmAttendance(Request $request)
    {
        $staff = Staff::where('staff_id', $request->staff_id)->first();
        $training = TrainingList::where('id', $request->train_id)->first();

        $exist = TrainingClaim::where('training_id', $request->train_id)->where('staff_id', $request->staff_id)->first();
            
        if(isset($exist)) {
            Session::flash('notification');

        } else {
            TrainingClaim::create([
                'staff_id'          => $staff->staff_id,
                'training_id'       => $training->id,
                'title'             => $training->title,
                'type'              => $training->type,
                'category'          => $training->category,
                'start_date'        => $training->start_date,
                'end_date'          => $training->end_date, 
                'start_time'        => $training->start_time,
                'end_time'          => $training->end_time, 
                'venue'             => $training->venue,
                'claim_hour'        => $training->claim_hour, 
                'approved_hour'     => $training->claim_hour, 
                'status'            => '2',
                'form_type'         => 'AF',
                'assigned_by'       => Auth::user()->id,
            ]);
    
            Session::flash('message');
        }

        return redirect('training-open-attendance/'.$request->train_id);
    }

    // Type

    public function typeList()
    {
        return view('training.parameter.type-list');
    }

    public function data_type()
    {
        $type = TrainingType::all();
       
        return datatables()::of($type)
        ->addColumn('action', function ($type) {

            $exist = TrainingClaim::where('type', $type->id)->first();
            if(isset($exist)) {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-training="'.$type->id.'" data-type="'.$type->type_name.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-training="'.$type->id.'" data-type="'.$type->type_name.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-type/' . $type->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->addIndexColumn()
        ->make(true);
    }

    public function storeType(Request $request)
    {
        $request->validate([
            'type_name'      => 'required|max:255',
        ]);

        TrainingType::create([
                'type_name'        => $request->type_name, 
            ]);
        
        Session::flash('message', 'Training Type Successfully Added');
        return redirect('type-list');
    }

    public function updateType(Request $request) 
    {
        $type = TrainingType::where('id', $request->type_id)->first();
        
        $request->validate([
            'type_names'      => 'required|max:255',
        ]);

        $type->update([
            'type_name'    => $request->type_names, 
        ]);
        
        Session::flash('notification', 'Training Type Successfully Updated');
        return redirect('type-list');
    }

    public function deleteType($id)
    {
        $exist = TrainingType::find($id);
        $exist->delete();

        return redirect('type-list');
    }

    // Category

    public function categoryList()
    {
        return view('training.parameter.category-list');
    }

    public function data_category()
    {
        $cat = TrainingCategory::all();
       
        return datatables()::of($cat)
        ->addColumn('action', function ($cat) {

            $exist = TrainingClaim::where('category', $cat->id)->first();
            if(isset($exist)) {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-training="'.$cat->id.'" data-category="'.$cat->category_name.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-training="'.$cat->id.'" data-category="'.$cat->category_name.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-category/' . $cat->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->addIndexColumn()
        ->make(true);
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name'      => 'required|max:255',
        ]);

        TrainingCategory::create([
                'category_name'        => $request->category_name, 
            ]);
        
        Session::flash('message', 'Training Category Successfully Added');
        return redirect('category-list');
    }

    public function updateCategory(Request $request) 
    {
        $category = TrainingCategory::where('id', $request->category_id)->first();
        
        $request->validate([
            'category_names'      => 'required|max:255',
        ]);

        $category->update([
            'category_name'    => $request->category_names, 
        ]);
        
        Session::flash('notification', 'Training Category Successfully Updated');
        return redirect('category-list');
    }

    public function deleteCategory($id)
    {
        $exist = TrainingCategory::find($id);
        $exist->delete();

        return redirect('category-list');
    }

    // Hour

    public function hourList()
    {
        $trail = new TrainingHourTrail();
        $data_years = TrainingHourYear::all();

        return view('training.parameter.hour-list', compact('data_years','trail'));
    }

    public function data_hour()
    {
        $hour = TrainingHourYear::all();
       
        return datatables()::of($hour)
        ->addColumn('action', function ($hour) {

            $exist = TrainingHourTrail::where('year', $hour->year)->first();

            if(isset($exist)) {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-training="'.$hour->id.'" data-year="'.$hour->year.'" data-hour="'.$hour->training_hour.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-training="'.$hour->id.'" data-year="'.$hour->year.'" data-hour="'.$hour->training_hour.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-hour/' . $hour->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->addColumn('assign', function ($hour) {

            $exist = TrainingHourTrail::where('year', $hour->year)->first();

            if(isset($exist)) {

                return '<button class="btn btn-sm btn-secondary" disabled><i class="fal fa-check-circle"></i></button>'; 

            } else {

                return ' <button class="btn btn-sm btn-success btn-assign" data-remote="/assign-hour/' . $hour->year . '"><i class="fal fa-check-circle"></i></button>'; 
            }
        })

        ->addIndexColumn()
        ->rawColumns(['action', 'assign'])
        ->make(true);
    }

    public function storeHour(Request $request)
    {
        $request->validate([
            'year'              => 'required|min:4|max:4',
            'training_hour'     => 'required',
        ]);

        TrainingHourYear::create([
                'year'                 => $request->year, 
                'training_hour'        => $request->training_hour, 
            ]);
        
        Session::flash('message', 'Training Hour Successfully Added');
        return redirect('hour-list');
    }

    public function updateHour(Request $request) 
    {
        $hour = TrainingHourYear::where('id', $request->hour_id)->first();
        
        $request->validate([
            'years'              => 'required|min:4|max:4',
            'training_hours'     => 'required',
        ]);

        $hour->update([
            'year'                 => $request->years, 
            'training_hour'        => $request->training_hours, 
        ]);
        
        Session::flash('notification', 'Training Hour Successfully Updated');
        return redirect('hour-list');
    }

    public function deleteHour($id)
    {
        $exist = TrainingHourYear::find($id);
        $exist->delete();

        return redirect('hour-list');
    }

    public function assignHour($id)
    {
        $staff = Staff::whereNotNull('staff_id')->pluck('staff_id')->toArray();

        foreach($staff as $key => $value) {
            TrainingHourTrail::create([
                'staff_id'      => $value,
                'year'          => $id,
                'status'        => '5',
            ]);
        }

        return response()->json(['success'=>'Staff Assignation Successfull']);
    }

    public function findStaff(Request $request)
    {
        $trails = TrainingHourTrail::where('year', $request->id )->get();
        $list_staff = array_column($trails->toArray(), 'staff_id');
        $data =  Staff::select('id', 'staff_id', 'staff_name')
                ->whereNotIn('staff_id', $list_staff)
                ->take(100)->get();

        return response()->json($data);
    }

    public function assignHourIndividual(Request $request)
    {
        foreach($request->staff_id as $value){ 
            $fields = [
                'year'          => $request->year,
                'staff_id'      => $value,
                'status'        => '5'
            ];

            TrainingHourTrail::create($fields);      
        }

        Session::flash('success', 'Staff Assignation Successfull');
        return redirect('hour-list');
    }

    // Claim Form

    public function claimForm()
    {
        $training_type = TrainingType::all();
        $training_cat = TrainingCategory::all();
        $training_list = TrainingList::orderBy('title','asc')->get();
        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        return view('training.claim.claim-form', compact('training_type', 'training_cat', 'staff', 'training_list'));
    }

    public function findTraining(Request $request)
    {
        $data = TrainingList::select('id', 'title', 'type','category','start_date','end_date','start_time','end_time','venue','claim_hour','link')
            ->where('id',$request->id)
            ->first();

        return response()->json($data);
    }

    public function claimStore(Request $request)
    {
        if($request->training_id != '0') {

            $exist = TrainingClaim::where('training_id', $request->training_id)->where('staff_id', Auth::user()->id)->first();
            
            if(isset($exist)) {
                Session::flash('notification');

            } else {

                for($x = 0; $x < count($request->file_name) ; $x ++)
                {
                    if ($request->file_name[$x]->getMimeType() == 'image/png' || $request->file_name[$x]->getMimeType() == 'image/jpg' || $request->file_name[$x]->getMimeType() == 'image/jpeg') {
                        $messages = [
                            "file_name.max" => "image cannot be more than 5"
                        ];
        
                        $request->validate([
                            'file_name.*'   => 'required|mimes:png,jpeg,jpg',
                            'file_name'     => 'max:5',
                        ],$messages);

                    } else {
                        $message = [
                            "file_name.max" => "file cannot be more than 1"
                        ];
        
                        $request->validate([
                            'file_name.*'   => 'required|mimes:pdf,doc,docx',
                            'file_name'     => 'max:1',
                        ],$message);
                    }
                }
    
                $request->validate([
                    'training_id'   => 'required',
                    'type'          => 'required',
                    'category'      => 'required',
                    'start_date'    => 'required',
                    'start_time'    => 'required',
                    'end_date'      => 'required',
                    'end_time'      => 'required',
                    'claim_hour'    => 'required',
                ]);
    
                $train = TrainingList::where('id', $request->training_id)->first();
        
                $claim = TrainingClaim::create([
                    'staff_id'          => Auth::user()->id,
                    'training_id'       => $request->training_id,
                    'title'             => $train->title,
                    'type'              => $request->type,
                    'category'          => $request->category,
                    'start_date'        => $request->start_date,
                    'end_date'          => $request->end_date, 
                    'start_time'        => $request->start_time,
                    'end_time'          => $request->end_time, 
                    'venue'             => $request->venue,
                    'link'              => $request->link,
                    'claim_hour'        => $request->claim_hour, 
                    'status'            => '1',
                    'form_type'         => 'SF',
                ]);

                if (isset($request->file_name)) { 
                    $file = $request->file_name;
                    $path=storage_path()."/claim/";

                    for($x = 0; $x < count($file) ; $x ++)
                    {
                        $originalName = $file[$x]->getClientOriginalName();
                        $fileSize = $file[$x]->getSize();
                        $fileName = $originalName;
                        $file[$x]->storeAs('/claim', $fileName);
                        ClaimAttachment::create([
                            'claim_id'      => $claim->id,
                            'file_name'     => $originalName,
                            'file_size'     => $fileSize,
                            'web_path'      => "app/claim/".$fileName,
                        ]);
                    }
                }

                Session::flash('message');
            }
           
        } else { // if others @ 0

            for($x = 0; $x < count($request->file_name) ; $x ++)
            {
                if ($request->file_name[$x]->getMimeType() == 'image/png' || $request->file_name[$x]->getMimeType() == 'image/jpg' || $request->file_name[$x]->getMimeType() == 'image/jpeg') {
                    $messages = [
                        "file_name.max" => "image cannot be more than 5"
                    ];
    
                    $request->validate([
                        'file_name.*'   => 'required|mimes:png,jpeg,jpg',
                        'file_name'     => 'max:5',
                    ],$messages);

                } else {
                    $message = [
                        "file_name.max" => "file cannot be more than 1"
                    ];
    
                    $request->validate([
                        'file_name.*'   => 'required|mimes:pdf,doc,docx',
                        'file_name'     => 'max:1',
                    ],$message);
                }
            }

            $request->validate([
                'training_id'   => 'required',
                'title'         => 'required',
                'type'          => 'required',
                'category'      => 'required',
                'start_date'    => 'required',
                'start_time'    => 'required',
                'end_date'      => 'required',
                'end_time'      => 'required',
                'claim_hour'    => 'required',
            ]);
    
            $claim = TrainingClaim::create([
                'staff_id'          => Auth::user()->id,
                'training_id'       => $request->training_id,
                'title'             => strtoupper($request->title),
                'type'              => $request->type,
                'category'          => $request->category,
                'start_date'        => $request->start_date,
                'end_date'          => $request->end_date, 
                'start_time'        => $request->start_time,
                'end_time'          => $request->end_time, 
                'venue'             => $request->venue,
                'link'              => $request->link,
                'claim_hour'        => $request->claim_hour, 
                'status'            => '1',
                'form_type'         => 'SF',
            ]);

            if (isset($request->file_name)) { 
                $file = $request->file_name;
                $path=storage_path()."/claim/";
                
                for($x = 0; $x < count($file) ; $x ++)
                {
                    $originalName = $file[$x]->getClientOriginalName();
                    $fileSize = $file[$x]->getSize();
                    $fileName = $originalName;
                    $file[$x]->storeAs('/claim', $fileName);
                    ClaimAttachment::create([
                        'claim_id'      => $claim->id,
                        'file_name'     => $originalName,
                        'file_size'     => $fileSize,
                        'web_path'      => "app/claim/".$fileName,
                    ]);
                }
            }

            Session::flash('message');
        }
        
        return redirect('/claim-form');
    }

    // Bulk Claim Form

    public function bulkClaimForm()
    {
        $training_type = TrainingType::all();
        $training_cat = TrainingCategory::all();
        $training_list = TrainingList::all();
        $staff = Staff::whereNotNull('staff_id')->orderBy('staff_dept','asc')->orderBy('staff_name','asc')->get();

        return view('training.claim.bulk-claim-form', compact('training_type', 'training_cat', 'staff', 'training_list'));
    }

    public function bulkClaimTemplate()
    {
        $file = storage_path()."/template/STAFF_CLAIM_LISTS.xlsx";
        $headers = array('Content-Type: application/xlsx',);
        return Response::download($file, 'STAFF_CLAIM_LISTS.xlsx',$headers);
    }

    public function bulkClaimStore(Request $request)
    {
        
        if($request->training_id != '0') {

            $train = TrainingList::where('id', $request->training_id)->first();
            
                if($request->rad_view == '0') {
                // form view

                    $request->validate([
                        'training_id'   => 'required',
                        'type'          => 'required',
                        'category'      => 'required',
                        'start_date'    => 'required',
                        'start_time'    => 'required',
                        'end_date'      => 'required',
                        'end_time'      => 'required',
                        'venue'         => 'required',
                        'claim_hour'    => 'required',
                        'staff_id'      => 'required',
                    ]);

                    foreach($request->input('staff_id') as $key => $value) {

                        $exists = TrainingClaim::where('training_id', $request->training_id)->where('staff_id', $value)->first();

                        if(!isset($exists)) {
                            $claim = TrainingClaim::create([
                                'staff_id'          => $value,
                                'training_id'       => $train->id,
                                'title'             => $train->title,
                                'type'              => $request->type,
                                'category'          => $request->category,
                                'start_date'        => $request->start_date,
                                'end_date'          => $request->end_date, 
                                'start_time'        => $request->start_time,
                                'end_time'          => $request->end_time, 
                                'venue'             => $request->venue,
                                'link'              => $request->link,
                                'claim_hour'        => $request->claim_hour, 
                                'status'            => '2',
                                'form_type'         => 'AF',
                                'approved_hour'     => $request->claim_hour, 
                                'assigned_by'       => Auth::user()->id,
                            ]);

                            $year = date('Y', strtotime($claim->start_date));
                            $totalApprove = TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $year )->where('staff_id', $value)->where('status', '2')->sum('approved_hour');
                            $totalHour = TrainingHourYear::where('year', $year)->first();
                    
                            if($totalApprove >= $totalHour->training_hour) {
                                $exist = TrainingHourTrail::where('staff_id', $value)->where('year', $year)->where('status', '4')->first();
                    
                                if(!isset($exist)) {
                    
                                    TrainingHourTrail::where('staff_id', $value)->where('year', $year)->update([
                                        'status'            => '4',
                                    ]);
                                }
                            }
                        }
                    }

                } else {
                // upload view (rad_view == 1)
                    
                    $this->validate($request, [
                        'import_file'   => 'required',
                        'training_id'   => 'required',
                        'type'          => 'required',
                        'category'      => 'required',
                        'start_date'    => 'required',
                        'start_time'    => 'required',
                        'end_date'      => 'required',
                        'end_time'      => 'required',
                        'venue'         => 'required',
                        'claim_hour'    => 'required',
                    ]);
            
                    Excel::import(new BulkClaimImport($train->id, $train->title, $request->type, $request->category, $request->start_date, $request->end_date, $request->start_time, 
                    $request->end_time, $request->venue, $request->claim_hour), request()->file('import_file'));
                }

            Session::flash('message');
           
        } else { // if others @ 0

            if($request->rad_view == '0') {
                // form view

                    $request->validate([
                        'training_id'   => 'required',
                        'title'         => 'required',
                        'type'          => 'required',
                        'category'      => 'required',
                        'start_date'    => 'required',
                        'start_time'    => 'required',
                        'end_date'      => 'required',
                        'end_time'      => 'required',
                        'venue'         => 'required',
                        'claim_hour'    => 'required',
                        'staff_id'      => 'required',
                    ]);

                    foreach($request->input('staff_id') as $key => $value) {

                        $exists = TrainingClaim::where('training_id', $request->training_id)->where('staff_id', $value)->first();

                        if(!isset($exists)) {

                            $claim = TrainingClaim::create([
                                'staff_id'          => $value,
                                'training_id'       => $train->id,
                                'title'             => strtoupper($request->title),
                                'type'              => $request->type,
                                'category'          => $request->category,
                                'start_date'        => $request->start_date,
                                'end_date'          => $request->end_date, 
                                'start_time'        => $request->start_time,
                                'end_time'          => $request->end_time, 
                                'venue'             => $request->venue,
                                'link'              => $request->link,
                                'claim_hour'        => $request->claim_hour, 
                                'status'            => '2',
                                'form_type'         => 'AF',
                                'approved_hour'     => $request->claim_hour, 
                                'assigned_by'       => Auth::user()->id,
                            ]);

                            $year = date('Y', strtotime($claim->start_date));
                            $totalApprove = TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $year )->where('staff_id', $value)->where('status', '2')->sum('approved_hour');
                            $totalHour = TrainingHourYear::where('year', $year)->first();
                    
                            if($totalApprove >= $totalHour->training_hour) {
                                $exist = TrainingHourTrail::where('staff_id', $value)->where('year', $year)->where('status', '4')->first();
                    
                                if(!isset($exist)) {
                    
                                    TrainingHourTrail::where('staff_id', $value)->where('year', $year)->update([
                                        'status'            => '4',
                                    ]);
                                }
                            }
                        }
                    }

            } else {
                // upload view (rad_view == 1)
                    
                    $this->validate($request, [
                        'import_file'   => 'required',
                        'training_id'   => 'required',
                        'title'         => 'required',
                        'type'          => 'required',
                        'category'      => 'required',
                        'start_date'    => 'required',
                        'start_time'    => 'required',
                        'end_date'      => 'required',
                        'end_time'      => 'required',
                        'venue'         => 'required',
                        'claim_hour'    => 'required',
                    ]);
            
                    Excel::import(new BulkClaimImport($train->id, $request->title, $request->type, $request->category, $request->start_date, $request->end_date, $request->start_time, 
                    $request->end_time, $request->venue, $request->claim_hour), request()->file('import_file'));
            }

            Session::flash('message');
        }
        
        return redirect('/bulk-claim-form');
    }

    // Claim Data

    public function claimList(Request $request)
    {
        if($request->year)
            $selectedYear = $request->year;
        else
            $selectedYear = Carbon::now()->format('Y');

        $data_type = TrainingType::all();
        $data_category = TrainingCategory::all();
        
        $year = TrainingHourYear::select('year')->orderBy('year','desc')->get();

        return view('training.claim.claim-list', compact('data_type','data_category','year','request','selectedYear'));
    }

    public function data_pending_claim(Request $request)
    {
        if($request->year != '') {

            $pendingClaim = TrainingClaim::where('status', '1')->where( DB::raw('YEAR(start_date)'), '=', $request->year )->get();
        } else {

            $pendingClaim = TrainingClaim::where('status', '1')->where( DB::raw('YEAR(start_date)'), '=', Carbon::now()->format('Y') )->get();
        }
        
        return datatables()::of($pendingClaim)

        ->addColumn('stylesheet', function ($pendingClaim) {
            return [
                [
                    'col' => 7,
                    'style' => [
                        'background' => 'rgb(255 116 63)',
                        'color' => '#fff',
                    ],
                ],
            ];
        })

        ->addColumn('action', function ($pendingClaim) {
            
            return '<div class="btn-group"><a href="/claim-info/' . $pendingClaim->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-claim/' . $pendingClaim->id . '"><i class="fal fa-trash"></i></button></div>';   
        })

        ->addColumn('approve', function ($pendingClaim) {

            return '<button class="btn btn-sm btn-success edit_data" data-toggle="modal" data-id="'.$pendingClaim->id.'" id="edit" name="edit"><i class="fal fa-check-circle"></i></button>';
        })

        ->addColumn('reject', function ($pendingClaim) {

            return '<button class="btn btn-sm btn-warning edit_datas" data-toggle="modal" data-id="'.$pendingClaim->id.'" id="edit" name="edit"><i class="fal fa-times-circle"></i></button>';
        })

        ->editColumn('staff_id', function ($pendingClaim) {

            $id = $pendingClaim->staffs->staff_id ?? '--';
            $name = $pendingClaim->staffs->staff_name ?? '';

            return '<h6 class="mb-0 flex-1 text-dark fw-500">'.$id.'<small class="m-0 l-h-n">'.$name.'</small></h6>' ?? '--';
        })

        ->editColumn('type', function ($pendingClaim) {

            $type = $pendingClaim->types->type_name ?? '--';

            return '<p style="text-transform : uppercase">'.$type.'</p>' ?? '--';
        })

        ->editColumn('category', function ($pendingClaim) {

            $category = $pendingClaim->categories->category_name ?? '--';

            return '<p style="text-transform : uppercase">'.$category.'</p>' ?? '--';
        })

        ->editColumn('title', function ($pendingClaim) {

            return '<p style="text-transform : uppercase; overflow-wrap: break-word">'.$pendingClaim->title.'</p>' ?? '--';
        })

        ->editColumn('date', function ($pendingClaim) {

            return strtoupper(date(' Y-m-d ', strtotime($pendingClaim->start_date) )).' - '.strtoupper(date(' Y-m-d ', strtotime($pendingClaim->end_date) ));
        })

        ->editColumn('time', function ($pendingClaim) {

            return strtoupper(date(' h:i A', strtotime($pendingClaim->start_time) )).' - '.strtoupper(date(' h:i A', strtotime($pendingClaim->end_time) )).'<br>( '.$pendingClaim->claim_hour.' HOURS )';
        })

        ->editColumn('duration', function ($pendingClaim) {

            $duration = Carbon::parse($pendingClaim->created_at)->diffInDays(Carbon::now())+1;

            if($duration != 1){
                return $duration . ' DAYS';
            } else {
                return $duration . ' DAY';
            }
        
            return $duration;
        })

        ->rawColumns(['action', 'approve', 'reject', 'staff_id', 'title', 'type', 'category', 'date', 'duration', 'time'])
        ->make(true);
    }

    public function getAttachment(Request $request)
    {
        $claim = TrainingClaim::where('id', $request->id)->with(['staffs','types','categories'])->first();

        echo json_encode($claim);
    }

    public function getClaimAttachment($id)  
    {
        $files = ClaimAttachment::where('claim_id', $id)->get();

        return response()->json(compact('files'));
    }

    public function approveClaim(Request $request)
    {
        $claim = TrainingClaim::where('id', $request->claim_id)->first();

        $request->validate([
            'approved_hour'         => 'required',
        ]);

        $claim->update([
            'approved_hour'     => $request->approved_hour,
            'status'            => '2',
            'assigned_by'       => Auth::user()->id,
        ]);

        // Emel to Staff

        $data = [
            // 'receiver_name' => 'Assalamualaikum wbt & Greetings, Sir/Madam/Mr/Ms ' . $claim->staffs->staff_name,
            // 'details'       => 'Your application has been approved and entered into training hours record on '.date(' j F Y ', strtotime(Carbon::now())).
            //                     'Please check your Claim Record in IDS System. Thank you.',
            'receiver_name' => $claim->staffs->staff_name,
            'details'       => date(' j F Y ', strtotime(Carbon::now())),
        ];

        Mail::send('training.claim.approve-mail', $data, function($message) use ($claim) {
            $message->to($claim->staffs->staff_email)->subject('Training Hour Claim');
            $message->from(Auth::user()->email);
        });

        $year = date('Y', strtotime($claim->start_date));
        $totalApprove = TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $year )->where('staff_id', Auth::user()->id)->where('status', '2')->sum('approved_hour');
        $totalHour = TrainingHourYear::where('year', $year)->first();

        if($totalApprove >= $totalHour->training_hour) {
            $exist = TrainingHourTrail::where('staff_id', Auth::user()->id)->where('year', $year)->where('status', '4')->first();

            if(!isset($exist)) {

                TrainingHourTrail::where('staff_id', Auth::user()->id)->where('year', $year)->update([
                    'status'            => '4',
                ]);
            }
        }

        Session::flash('message', 'Claim request by '.$claim->staffs->staff_name.' has been APPROVED on '.date(' d/m/Y', strtotime(Carbon::now())));
        return redirect('/claim-list');
    }

    public function rejectClaim(Request $request)
    {
        $claim = TrainingClaim::where('id', $request->claim_id)->first();

        $request->validate([
            'reject_reason'         => 'required',
        ]);

        $claim->update([
            'reject_reason'     => $request->reject_reason,
            'status'            => '3',
            'assigned_by'       => Auth::user()->id,
        ]);

        
        // Emel to Staff

        $data = [
            // 'receiver_name' => 'Assalamualaikum wbt & Greetings, Sir/Madam/Mr/Ms ' . $claim->staffs->staff_name,
            // 'details'       => 'Your application has been rejected on '.date(' j F Y ', strtotime(Carbon::now())).' because '.$claim->reject_reason.'.',
            'receiver_name'     => $claim->staffs->staff_name,
            'dates'              => date(' j F Y ', strtotime(Carbon::now())),
            'details'           => strtoupper($claim->reject_reason),
        ];

        Mail::send('training.claim.reject-mail', $data, function($message) use ($claim) {
            $message->to($claim->staffs->staff_email)->subject('Training Hour Claim');
            $message->from(Auth::user()->email);
        });

        Session::flash('notification', 'Claim request by '.$claim->staffs->staff_name.' has been REJECTED on '.date(' d/m/Y', strtotime(Carbon::now())));
        return redirect('/claim-list');
    }

    public function deleteClaim($id)
    {
        $exist = TrainingClaim::find($id);
        $exist->delete();

        return redirect()->back();
    }

    public function claimInfo($id)
    {
        $claim = TrainingClaim::where('id', $id)->first();
        $attachment = ClaimAttachment::where('claim_id', $id)->get();

        return view('training.claim.claim-info', compact('claim','attachment'));
    }

    public function data_approve_claim(Request $request)
    {
        if($request->year != '') {

            $approveClaim = TrainingClaim::where('status', '2')->where( DB::raw('YEAR(start_date)'), '=', $request->year )->get();
        } else {

            $approveClaim = TrainingClaim::where('status', '2')->where( DB::raw('YEAR(start_date)'), '=', Carbon::now()->format('Y') )->get();
        }

        return datatables()::of($approveClaim)

        ->addColumn('stylesheet', function ($approveClaim) {
            return [
                [
                    'col' => 8,
                    'style' => [
                        'background' => 'rgb(2 190 8)',
                        'color' => '#fff',
                    ],
                ],
            ];
        })

        ->addColumn('action', function ($approveClaim) {
            
            return '<div class="btn-group"><a href="/claim-info/' . $approveClaim->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-claim/' . $approveClaim->id . '"><i class="fal fa-trash"></i></button></div>';   
        })

        ->editColumn('staff_id', function ($approveClaim) {

            $id = $approveClaim->staffs->staff_id ?? '--';
            $name = $approveClaim->staffs->staff_name ?? '';

            return '<h6 class="mb-0 flex-1 text-dark fw-500">'.$id.'<small class="m-0 l-h-n">'.$name.'</small></h6>' ?? '--';
        })

        ->editColumn('type', function ($approveClaim) {

            $type = $approveClaim->types->type_name ?? '--';

            return '<p style="text-transform : uppercase">'.$type.'</p>' ?? '--';
        })

        ->editColumn('category', function ($approveClaim) {

            $category = $approveClaim->categories->category_name ?? '--';

            return '<p style="text-transform : uppercase">'.$category.'</p>' ?? '--';
        })

        ->editColumn('title', function ($approveClaim) {

            return '<p style="text-transform : uppercase; overflow-wrap: break-word">'.$approveClaim->title.'</p>' ?? '--';
        })

        ->editColumn('date', function ($approveClaim) {

            return strtoupper(date(' Y-m-d ', strtotime($approveClaim->start_date) )).' - '.strtoupper(date(' Y-m-d ', strtotime($approveClaim->end_date) ));
        })

        ->editColumn('time', function ($approveClaim) {

            return strtoupper(date(' h:i A', strtotime($approveClaim->start_time) )).' - '.strtoupper(date(' h:i A', strtotime($approveClaim->end_time) ));
        })

        ->editColumn('claim_hour', function ($approveClaim) {

            return $approveClaim->claim_hour.' HOURS';
        })

        ->editColumn('approved_hour', function ($approveClaim) {

            return $approveClaim->approved_hour.' HOURS';
        })

        ->editColumn('assigned_by', function ($approveClaim) {

            $staff = $approveClaim->users->name ?? '--';

            return '<p style="text-transform : uppercase; overflow-wrap: break-word">'.$staff.'</p>' ?? '--';
        })

        ->rawColumns(['action', 'claim_hour', 'approved_hour', 'staff_id', 'title', 'type', 'category', 'date', 'assigned_by', 'time'])
        ->make(true);
    }

    public function data_reject_claim(Request $request)
    {
        if($request->year != '') {

            $rejectClaim = TrainingClaim::where('status', '3')->where( DB::raw('YEAR(start_date)'), '=', $request->year )->get();
        } else {

            $rejectClaim = TrainingClaim::where('status', '3')->where( DB::raw('YEAR(start_date)'), '=', Carbon::now()->format('Y') )->get();
        }

        return datatables()::of($rejectClaim)

        ->addColumn('stylesheet', function ($rejectClaim) {
            return [
                [
                    'col' => 8,
                    'style' => [
                        'background' => 'rgb(255 56 56)',
                        'color' => '#fff',
                    ],
                ],
            ];
        })

        ->addColumn('action', function ($rejectClaim) {
            
            return '<div class="btn-group"><a href="/claim-info/' . $rejectClaim->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-claim/' . $rejectClaim->id . '"><i class="fal fa-trash"></i></button></div>';   
        })

        ->editColumn('staff_id', function ($rejectClaim) {

            $id = $rejectClaim->staffs->staff_id ?? '--';
            $name = $rejectClaim->staffs->staff_name ?? '';

            return '<h6 class="mb-0 flex-1 text-dark fw-500">'.$id.'<small class="m-0 l-h-n">'.$name.'</small></h6>' ?? '--';
        })

        ->editColumn('type', function ($rejectClaim) {

            $type = $rejectClaim->types->type_name ?? '--';

            return '<p style="text-transform : uppercase">'.$type.'</p>' ?? '--';
        })

        ->editColumn('category', function ($rejectClaim) {

            $category = $rejectClaim->categories->category_name ?? '--';

            return '<p style="text-transform : uppercase">'.$category.'</p>' ?? '--';
        })

        ->editColumn('title', function ($rejectClaim) {

            return '<p style="text-transform : uppercase; overflow-wrap: break-word">'.$rejectClaim->title.'</p>' ?? '--';
        })

        ->editColumn('date', function ($rejectClaim) {

            return strtoupper(date(' Y-m-d ', strtotime($rejectClaim->start_date) )).' - '.strtoupper(date(' Y-m-d ', strtotime($rejectClaim->end_date) ));
        })

        ->editColumn('time', function ($rejectClaim) {

            return strtoupper(date(' h:i A', strtotime($rejectClaim->start_time) )).' - '.strtoupper(date(' h:i A', strtotime($rejectClaim->end_time) ));
        })

        ->editColumn('claim_hour', function ($rejectClaim) {

            return $rejectClaim->claim_hour.' HOURS';
        })

        ->editColumn('reject_reason', function ($rejectClaim) {

            return '<p style="text-transform : uppercase; overflow-wrap: break-word">'.$rejectClaim->reject_reason.'</p>' ?? '--';
        })

        ->editColumn('assigned_by', function ($rejectClaim) {

            $staff = $rejectClaim->users->name ?? '--';

            return '<p style="text-transform : uppercase; overflow-wrap: break-word">'.$staff.'</p>' ?? '--';
        })

        ->rawColumns(['action', 'claim_hour', 'reject_reason', 'staff_id', 'title', 'type', 'category', 'date', 'assigned_by', 'time'])
        ->make(true);
    }

    public function exportClaim()
    {
        return Excel::download(new ClaimExport,'Claim.xlsx');
    }

    public function exportLatestClaim($year)
    {
        return Excel::download(new LatestClaimExport($year),'LatestClaim.xlsx');
    }

    public function claimAttachment($filename,$type)
    {
        $path = storage_path().'/'.'app'.'/claim/'.$filename;

        if($type == "Download")
        {
            if (file_exists($path)) {
                return Response::file($path);
            }
        }
        else
        {
            $file = File::get($path);
            $filetype = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
    }

    public function fileStore(Request $request)
    {
        $file = $request->file('file');
        $path=storage_path()."/claim/";

        if (isset($file)) { 
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileName = $originalName;
            $file->storeAs('/claim', $fileName);
            ClaimAttachment::create([
                'claim_id'      => $request->ids,
                'file_name'     => $originalName,
                'file_size'     => $fileSize,
                'web_path'      => "app/claim/".$fileName,
            ]);
        }

        return response()->json(['success'=>$originalName]);
    }

    public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');
        ClaimAttachment::where('filename',$filename)->delete();
        $path=storage_path().'"app/claim/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;  
    }

    public function deleteFile($id)
    {
        $attach = ClaimAttachment::find($id);
        $attach->delete();
        return redirect()->back()->with('message', 'Attachment Deleted Successfully');
    }

    // Claim Record

    public function claimRecord(Request $request)
    {
        $req_year = $request->year;
        $req_type = $request->type;

        $year = TrainingClaim::selectRaw("COUNT(*) views, DATE_FORMAT(start_date, '%Y') date")
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get();
        
        $type = TrainingType::select('id','type_name')->groupBy('id')->orderBy('type_name')->get();
  
        $data = $data2 = $data3 =  '';
    
        if($request->year || $request->type)
        {
            $res = new TrainingClaim();

            if($request->type != "")
            {
                $res = $res->where('type', $request->type);
            }

            if($request->year != "")
            {
                $res =  $res->where( DB::raw('YEAR(start_date)'), '=', $request->year );
            }
            
            $data = $res->where('staff_id', Auth::user()->id)->get();

            if($request->type != "" && $request->year != "") {
                $data2 = $res->where( DB::raw('YEAR(start_date)'), '=', $request->year )->where('type', $request->type)->where('staff_id', Auth::user()->id)->where('status', '2')->sum('approved_hour');
            } elseif($request->type == "" && $request->year != "") {
                $data2 = $res->where( DB::raw('YEAR(start_date)'), '=', $request->year )->where('staff_id', Auth::user()->id)->where('status', '2')->sum('approved_hour');
            } else { // if($request->type != "" && $request->year == "")
                $data2 = $res->where('type', $request->type)->where('staff_id', Auth::user()->id)->where('status', '2')->sum('approved_hour');
            }
        }
         
        $staff = Staff::where('staff_id', Auth::user()->id)->first();
        $hours = TrainingHourYear::where('year', $request->year)->first();
        $category = TrainingCategory::all();

        return view('training.claim.claim-record', compact('staff','year','type','req_year','req_type','data','data2','hours', 'category'))->with('no', 1);
    }

    public function claimSlip($id = null, $year = null, $type = null)
    {
        $staff = Staff::where('staff_id', $id)->first();
        $hours = TrainingHourYear::where('year', $year)->first();

        $data = $data2 = $data3 =  '';
    
        if($year || $type)
        {
            $res = new TrainingClaim();

            if($type != "")
            {
                $res = $res->where('type', $type);
            }

            if($year != "")
            {
                $res =  $res->where( DB::raw('YEAR(start_date)'), '=', $year );
            }
            
            $data = $res->where('staff_id', $id)->where('status', '2')->get();

            if($type != "" && $year != "") {
                $data2 = $res->where( DB::raw('YEAR(start_date)'), '=', $year )->where('type', $type)->where('staff_id', $id)->where('status', '2')->sum('approved_hour');
            } elseif($type == "" && $year != "") {
                $data2 = $res->where( DB::raw('YEAR(start_date)'), '=', $year )->where('staff_id', $id)->where('status', '2')->sum('approved_hour');
            } else {  
                $data2 = $res->where('type', $type)->where('staff_id', $id)->where('status', '2')->sum('approved_hour');
            }
        }

        return view('training.claim.claim-slip', compact('staff', 'data', 'data2', 'hours', 'year'))->with('no', 1);
    }

    // Record Data

    public function recordStaff()
    {
        $data_status = TrainingStatus::where('status_type', 'TR')->get();
        return view('training.record.record-staff', compact('data_status'));
    }

    public function data_record_staff()
    {
        $staff = TrainingHourTrail::where('year', Carbon::now()->format('Y'))->get();

        return datatables()::of($staff)

        ->addColumn('action', function ($staff) {
             
            return '<a href="/record-info/' . $staff->staff_id .'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';   
        })

        ->editColumn('staff_id', function ($staff) {

            return $staff->staff_id ?? '--';
        })

        ->editColumn('staff_name', function ($staff) {

            return $staff->staffs->staff_name ?? '--';
        })

        ->editColumn('staff_position', function ($staff) {
            
            return $staff->staffs->staff_position ?? '--';
        })

        ->editColumn('staff_dept', function ($staff) {
           
            return $staff->staffs->staff_dept ?? '--';
        })

        ->editColumn('staff_training_hr', function ($staff) {
            
            $total_hour = TrainingHourYear::where('year', $staff->year)->first();
            return $total_hour->training_hour ?? '--';
        })

        ->editColumn('staff_current_hr', function ($staff) {
            
            $current_hours = TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $staff->year )->where('staff_id', $staff->staff_id)->where('status', '2')->sum('approved_hour');

            return $current_hours;
        })

        ->editColumn('status', function ($staff) {

            if($staff->status == '4') {

                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$staff->record_status->status_name.'</b></div>';
            } else { // 5 

                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$staff->record_status->status_name.'</b></div>';
            }

        })

        ->rawColumns(['action', 'staff_name', 'staff_id', 'staff_position', 'staff_dept', 'staff_training_hr', 'staff_current_hr', 'status'])
        ->make(true);
    }

    public function recordInfo(Request $request, $id)
    {
        if($request->year) {
            $selectedYear = $request->year;
        } else {
            $selectedYear = Carbon::now()->format('Y');
        }

        $staff = Staff::where('staff_id', $id)->first();
        $year = TrainingHourYear::select('year')->orderBy('year','desc')->get();

        $yearly_hour = TrainingHourYear::where('year', $selectedYear)->first();
        $data_training = TrainingClaim::where('staff_id', $id)->where('status', '2')->where( DB::raw('YEAR(start_date)'), '=', $selectedYear )->get();
        $training_history = TrainingClaim::where('staff_id', $id)->where( DB::raw('YEAR(start_date)'), '=', $selectedYear )->get();
        $current_hours = TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $selectedYear )->where('staff_id', $id)->where('status', '2')->sum('approved_hour');
        $data_status = TrainingHourTrail::where('staff_id', $id)->where('year', $selectedYear)->first();

        return view('training.record.record-info', compact('staff', 'year','request','selectedYear','id', 'yearly_hour', 'data_training', 'training_history', 'current_hours', 'data_status'))->with('no', 1);
    }

    public function claimAll($id, $year)
    {
        $staff = Staff::where('staff_id', $id)->first();
        $hours = TrainingHourYear::where('year', $year)->first();
        $training_history = TrainingClaim::where('staff_id', $id)->where( DB::raw('YEAR(start_date)'), '=', $year )->get();

        return view('training.claim.claim-all', compact('staff', 'hours', 'training_history', 'year'))->with('no', 1);
    }

    public function exportLatestRecord()
    {
        return Excel::download(new LatestRecordExport,'LatestRecord.xlsx');
    }

    public function exportRecord()
    {
        return Excel::download(new RecordExport,'Record.xlsx');
    }

    // Evaluation Question

    public function questionList()
    {
        return view('training.evaluation.question-list');
    }

    public function data_evaluation()
    {
        $evaluate = TrainingEvaluation::all();
       
        return datatables()::of($evaluate)
        ->addColumn('action', function ($evaluate) {

            $exist = TrainingList::where('evaluation', $evaluate->id)->first();
            if(isset($exist)) {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$evaluate->id.'" data-evaluation="'.$evaluate->evaluation.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                        <a href="/question-info/' . $evaluate->id.'" class="btn btn-sm btn-primary ml-1"><i class="fal fa-eye"></i></a>';

            } else {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$evaluate->id.'" data-evaluation="'.$evaluate->evaluation.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                        <a href="/question-info/' . $evaluate->id.'" class="btn btn-sm btn-primary ml-1"><i class="fal fa-eye"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-evaluation/' . $evaluate->id . '"><i class="fal fa-trash"></i></button>';
            }
        })

        ->editColumn('created_at', function ($evaluate) {

            return isset($evaluate->created_at) ? strtoupper(date(' Y-m-d ', strtotime($evaluate->created_at) )) : '--';
        })

        ->rawColumns(['action', 'created_at'])
        ->make(true);
    }

    public function storeEvaluation(Request $request)
    {
        $request->validate([
            'evaluation'      => 'required',
        ]);

        TrainingEvaluation::create([
                'evaluation'        => strtoupper($request->evaluation), 
            ]);
        
        Session::flash('message', 'New Evaluation Successfully Added');
        return redirect('evaluation-question');
    }

    public function updateEvaluation(Request $request) 
    {
        $evaluate = TrainingEvaluation::where('id', $request->eval_id)->first();
        
        $request->validate([
            'evaluations'      => 'required',
        ]);

        $evaluate->update([
            'evaluation'        => strtoupper($request->evaluations), 
        ]);
        
        Session::flash('notification', 'Evaluation Successfully Updated');
        return redirect('evaluation-question');
    }

    public function deleteEvaluation($id)
    {
        $exist = TrainingEvaluation::find($id);
        $exist->delete();

        return redirect('evaluation-question');
    }

    public function questionInfo($id) // uncomp. result exist
    {
        $evaluate = TrainingEvaluation::where('id', $id)->first();
        $evaluation = TrainingEvaluationHead::TeId($id)->with(['trainingEvaluationQuestions'=>function($query){
            $query->orderby('sequence','ASC');
        }, 'trainingEvaluation'])->orderby('sequence','ASC')->get();

        // $result = $this->teachingEvaluationResult->checkResult($id);

        return view('training.evaluation.question-info', compact('evaluate','evaluation','id'));
    }

    public function storeHeader(Request $request)
    {
        $request->validate([
            'te_id'     => 'required',
            'color'     => 'required',
        ]);

        foreach($request->input('head') as $key => $value) {
            TrainingEvaluationHead::create([
                'evaluation_id' => $request->te_id,
                'question_head'=>$value,
                'color' => $request->color[$key],
            ]);
        }

        return redirect()->back()->with('message', 'Question Head Successfully Created');
    }

    public function updateHeader(Request $request)
    {
        if($request->ajax()){

            if($request->action == 'edit'){
                $data = array(
                    'question'  => $request->question,
                    'color'     => $request->color
                );
                TrainingEvaluationHead::find($request->id)->update(['question_head' => $data['question'], 'color' => $data['color']]);
            }

            if($request->action == 'delete'){
                TrainingEvaluationHead::find($request->id)->delete();
            }
        }

    }

    public function reorderHeader(Request $request) // Reorder Header
    {
        foreach($request->sequence as $key => $value){

            TrainingEvaluationHead::where('id',$value)->update(['sequence' => $key + 1]);
        }
    }

    public function storeQuestion(Request $request)
    {
        foreach($request->question as $key => $value) {

            TrainingEvaluationQuestion::create([
                'evaluation_id'     => $request->te_id,
                'head_id'           => $request->ques_head,
                'question'          => $value,
                'eval_rate'         => $request->eval_rate[$key]
            ]);
        }

        return redirect()->back()->with('messageQuestion', 'Question Successfully Created');
    }

    public function updateQuestion(Request $request)
    {
        if($request->ajax()){

            if($request->action == 'edit'){
                $data = array(
                    'question' => $request->question,
                    'eval_rate' => $request->eval_rate
                );
                TrainingEvaluationQuestion::find($request->id)->update(['question' => $data['question'], 'eval_rate' => $data['eval_rate']]);
            }

            if($request->action == 'delete'){
                TrainingEvaluationQuestion::find($request->id)->delete();
            }

            return response()->json($request);
        }
    }

    public function reorderQuestion(Request $request) // Reorder Question
    {
        foreach($request->sequence as $key => $value){

            TrainingEvaluationQuestion::where('id',$value)->update(['sequence' => $key + 1]);
        }

    }
    
    public function questionPdf($id)
    {
        $header = TrainingEvaluationHead::orderBy('sequence', 'ASC')->where('evaluation_id', $id)->get();

        return view('training.evaluation.question-pdf', compact('header'));
    }

    // Evaluation Form

    public function evaluationForm($id)
    {
        $staff = Staff::where('staff_id', Auth::user()->id)->first();
        $training = TrainingList::where('id', $id)->first();
        $trainingHead = TrainingEvaluationHead::orderBy('sequence', 'ASC')->where('evaluation_id', $training->evaluation)->get();
        $trainingResult = TrainingEvaluationResult::where('staff_id', Auth::user()->id)->where('training_id', $id)->get(); 
        
        return view('training.evaluation.question-form',compact('training','trainingHead','trainingResult','staff'));
    }

    public function storeEvaluationForm(Request $request)
    {
        $id = Auth::user()->id;
        $complete = true;
        
        for ($i = 0; $i < $request->count; $i++)
        {
            $rating   = "rating".$i;
            $question = "question".$i;

            if(!isset($request->$rating))
                $complete &= false;

            $input = [
                    'question'    => $request->$question,
                    'rating'      => $request->$rating,
                    'staff_id'    => $id,
                    'training_id' => $request->train_id,
                ];
            
            TrainingEvaluationResult::create($input);     
        }
        
        if ($complete) 
            $status_id = 'CP';
        else 
            $status_id = 'IP';

        TrainingEvaluationHeadResult::create([
            'staff_id'          => $id,
            'training_id'       => $request->train_id,
            'evaluation_id'     => $request->evaluate_id, 
            'submission_status' => $status_id,
        ]);
    
        Session::flash('message');
        return redirect('evaluation-form/'.$request->train_id);
    }

    public function updateEvaluationForm(Request $request)
    {
        $id = Auth::user()->id;

        for ($i = 0; $i < $request->count; $i++)
        {
            $teRes   = "id".$i;

            TrainingEvaluationResult::where('id', $request->$teRes)->delete(); 
        }
        
        $complete = true;
        
        for ($i = 0; $i < $request->count; $i++)
        {
            $rating   = "rating".$i;
            $question = "question".$i;

            if(!isset($request->$rating))
                $complete &= false;

            $input = [
                    'question'    => $request->$question,
                    'rating'      => $request->$rating,
                    'staff_id'    => $id,
                    'training_id' => $request->training_id,
                ];
            
            TrainingEvaluationResult::create($input);     
        }
        
        if ($complete) 
            $status_id = 'CP';
        else 
            $status_id = 'IP';

        $thRes = TrainingEvaluationHeadResult::where('staff_id', $id)->where('training_id', $request->training_id)->first();
        
        $thRes->update([
            'staff_id'          => $id,
            'training_id'       => $request->training_id,
            'evaluation_id'     => $request->evaluation_id, 
            'submission_status' => $status_id,
        ]);
    
        Session::flash('notification');
        return redirect('evaluation-form/'.$request->training_id);
    }

    // Evaluation Report

    public function reportList()
    {
        return view('training.evaluation.report-list');
    }

    public function data_evaluation_report()
    {
        $report = TrainingList::whereIn('type', ['1','2'])->get();
       
        return datatables()::of($report)
        ->addColumn('action', function ($report) {

            return '<a href="/report-info/' . $report->id.'" class="btn btn-sm btn-primary ml-1"><i class="fal fa-eye"></i></a>';
        })

        ->editColumn('title', function ($report) {

            return '<p style="text-transform : uppercase; overflow-wrap: break-word">'.$report->title.'</p>' ?? '--';
        })

        // ->editColumn('id', function ($report) {

        //     return '#'.$report->id ?? '--';
        // })

        ->editColumn('start_date', function ($report) {

            $start = isset($report->start_date) ? date(' Y-m-d ', strtotime($report->start_date)) : 'Y-m-d';
            $end = isset($report->end_date) ? date(' Y-m-d ', strtotime($report->end_date)) : 'Y-m-d';

            if($report->start_date != null) {
                return $start.' - '.$end;
            } else {
                return '--';
            }  
        })

        ->editColumn('type', function ($report) {

            $type = $report->types->type_name ?? '--';

            return '<p style="text-transform : uppercase">'.$type.'</p>' ?? '--';
        })

        ->editColumn('participant', function ($report) {

            $data = TrainingClaim::where('status', '2')->where('training_id', $report->id)->count();

            return $data ?? '0';
        })

        ->editColumn('respondant', function ($report) {

            $data = TrainingEvaluationResult::where('training_id',$report->id)->groupBy('question')->count();

            return $data ?? '0';
        })

        ->editColumn('percentage', function ($report) {

            $dataResult = TrainingEvaluationResult::where('training_id',$report->id)->groupBy('question')->count();
            $dataClaim = TrainingClaim::where('status', '2')->where('training_id', $report->id)->count();

            if($dataClaim != 0) {
                $division = ($dataResult / $dataClaim) * 100;
                return ROUND(($division), 2).'%';  
            } else {     
                return '0%';
            }
        })

        ->addIndexColumn()
        ->rawColumns(['action', 'title', 'start_date', 'participant', 'respondant', 'percentage', 'id', 'type'])
        ->make(true);
    }

    public function reportInfo($id)
    {
        $evaluationStatus = TrainingEvaluationStatus::all();
        $training = TrainingList::where('id', $id)->first();
        $trainingHead = TrainingEvaluationHead::orderBy('sequence', 'ASC')->where('evaluation_id', $training->evaluation)->get();
        $trainingResult = TrainingEvaluationResult::select('question')->where('training_id', $id)->whereHas('trainingEvaluationQuestion',function($query) {
            $query->where('eval_rate', 'R');
        })->groupBy('question')->get(); 

        return view('training.evaluation.report-info', compact('evaluationStatus','id','training','trainingHead','trainingResult'));
    }

    public function reportResponse($id, $head, $eval)  
    {
        $ques_response = TrainingEvaluationQuestion::orderby('sequence','ASC')->where('head_id', $head)->where('evaluation_id', $eval)->where('eval_rate','C')->get();

        return view('training.evaluation.report-response',compact('ques_response','id'));
    }

    public function reportResponsePdf($id, $head, $eval)  
    {
        $ques_response = TrainingEvaluationQuestion::orderby('sequence','ASC')->where('head_id', $head)->where('evaluation_id', $eval)->where('eval_rate','C')->get();

        return view('training.evaluation.response-pdf',compact('ques_response','id'));
    }

    public function reportPdf($id)
    {
        $evaluationStatus = TrainingEvaluationStatus::all();
        $training = TrainingList::where('id', $id)->first();
        $trainingHead = TrainingEvaluationHead::orderBy('sequence', 'ASC')->where('evaluation_id', $training->evaluation)->get();
        $trainingResult = TrainingEvaluationResult::select('question')->where('training_id', $id)->whereHas('trainingEvaluationQuestion',function($query) {
            $query->where('eval_rate', 'R');
        })->groupBy('question')->get(); 

        return view('training.evaluation.report-pdf', compact('evaluationStatus','id','training','trainingHead','trainingResult'));
    }

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
