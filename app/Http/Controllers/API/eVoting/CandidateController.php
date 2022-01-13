<?php

namespace App\Http\Controllers\API\eVoting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eVoting\Candidate;
use App\Models\eVoting\Vote;
use App\Http\Controllers\API\BaseController as BaseController;
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

    public function getCandidateRelevant(){
        $exist=Vote::where('student_id',Auth::user()->id)->first();
        if(is_null($exist)){
            $candidates=Candidate::get()->load(['student.programme.programme_category', 'votes']);
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
