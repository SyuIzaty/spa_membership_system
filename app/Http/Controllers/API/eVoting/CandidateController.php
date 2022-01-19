<?php

namespace App\Http\Controllers\API\eVoting;

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

            $candidates=Candidate::
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
