<?php

namespace App\Http\Controllers\API\eVoting;

// require 'vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

use Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eVoting\Candidate;
use App\Models\eVoting\Vote;
use App\Http\Controllers\API\BaseController as BaseController;
use File;
use Response;
use App\Student;
use Auth;
use Carbon\Carbon;

class CandidateController extends BaseController
{
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
        $exist=Candidate::where([
            ['student_id',$request->id],
            ['voting_session_id',$request->voting_session_id]])
        ->first();
        if(!$exist || is_null($exist)){


            $candidate=Candidate::create([
                'student_id'=> $request->id,
                'tagline'=> $request->tagline,
                'image'=> null,
                'voting_session_id'=> (int)$request->voting_session_id,
                'created_by' => Auth::user()->id]);

            if($request->image && !is_null($request->image) && $request->image!==""){

                $extension = explode('/', mime_content_type($request->image))[1];
                $date = Carbon::today()->toDateString();
                $year = substr($date, 0, 4);
                $path='app/evoting/candidates/'.$year.'/candidate_'.$candidate->id.'.'.$extension;
                Image::make(file_get_contents($request->image))->save(storage_path() . '/'.$path);
                $candidate->image=$path;
                $candidate->image=$path;
                $candidate->save();
            }
        }else{
            return $this->sendError("
            Already registered as candidate!
            You may edit the candidate details from the list.");
        }
        $candidate=Candidate::join(config('global_env.DB_DATABASE_SIMS').'.students',
        config('global_env.DB_DATABASE_SIMS').'.students.students_id','=','evs_candidate.student_id')
        ->where('evs_candidate.id',$candidate->id)
        ->first();

        return $this->sendResponse($candidate, 'Candidate registered!');
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
    public function update(Request $request)
    {
        //
        $candidate=Candidate::where([
            ['voting_session_id','=',$request->payload['voting_session_id']],
            ['student_id','=',$request->payload['student_id']]
            ])
            ->first();
        if(!is_null($request->payload['image'])){
            $extension = explode('/', mime_content_type($request->payload['image']))[1];
            $date = Carbon::today()->toDateString();
            $year = substr($date, 0, 4);
            $path='app/evoting/candidates/'.$year.'/candidate_'.$candidate['id'].'.'.$extension;
            Image::make(file_get_contents($request->payload['image']))->save(storage_path() . '/'.$path);
            $candidate->image=$path;
        }
        $candidate->tagline=$request->payload['tagline'];
        $candidate->save();
        return $this->sendResponse($candidate, 'Candidate updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($student_id,$voting_session_id)
    {
        //

        $candidate=Candidate::where([
            ['voting_session_id','=',$voting_session_id],
            ['student_id','=',$student_id]])
            ->first();
            $candidate->updated_by=Auth::user()->id;
            $candidate->deleted_by=Auth::user()->id;
            $candidate->save();
            $candidate->delete();

        return $this->sendResponse($candidate, 'Deletion Succeed!');
    }


    public function getCandidateImage(Request $request)
    {
        $path = storage_path() . '/' . $request->image_path;
        // return $path;

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function getCandidateRelevant(){
        $exist=Vote::where('student_id',Auth::user()->id)->first();
        if(is_null($exist)){
            $student=Student::where('students_id',Auth::user()->id)
            ->first()->load(['programme.programme_category.candidate_category_programme_category_s']);
            $candidate_category_programme_category_s=$student->programme->programme_category->candidate_category_programme_category_s;
            $candidate_category_ids=[];
            foreach($candidate_category_programme_category_s as $candidate_category_programme_category){
                array_push($candidate_category_ids,$candidate_category_programme_category->candidate_category_id);
            }
            // $candidate_category_id=$candidate_category_programme_category_s[count($candidate_category_programme_category_s)-1]->candidate_category_id;

            $candidates=Candidate::whereHas('voting_session', function ($query){
                $query->where('is_active',1);
            })->
            whereHas('student.programme.programme_category.candidate_category_programme_category_s', function ($query) use($candidate_category_ids) {
                $query->whereIn('candidate_category_id',$candidate_category_ids);
            })
            ->get()->load(['student.programme.programme_category', 'votes']);
            foreach($candidates as $candidate){
                $candidate->is_selected=false;
                foreach ($candidate->votes as $vote) {
                    if($vote->student_id===Auth::user()->id){
                        $candidate->is_selected=true;
                        break;
                    }
                }
            }
        }else{
            return $this->sendError("Already vote");
        }
        return $this->sendResponse($candidates, 'Candidate fetched.');
    }
}
