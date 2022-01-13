<?php

namespace App\Http\Controllers\API\eVoting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eVoting\Vote;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;

class VoteController extends BaseController
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
        $candidates= $request->payload;
        foreach ($candidates as $candidate){
            if($candidate['is_selected']===true){

                $vote=Vote::where([
                    ['candidate_id', '=',$candidate['id']],
                    ['student_id', '=','student_id'=>Auth::user()->id]
                ])->first();
                if(is_null($vote)){
                    $name='vote_'.(Auth::user()->id).'_candidate_'.($candidate['id']);
                    Vote::create([
                        'name'=>$name,
                        'candidate_id'=>$candidate['id'],
                        'student_id'=>Auth::user()->id,
                        'created_by'=>Auth::user()->id,
                        'updated_by'=>Auth::user()->id,
                    ]);
                }
            }else{
                $vote=Vote::where([
                    ['candidate_id', '=',$candidate['id']],
                    ['student_id', '=','student_id'=>Auth::user()->id]
                ])->first();
                if(!is_null($vote)){
                    $vote->deleted_by=Auth::user()->id;
                    $vote->save();
                    $vote->delete();
                }
            }
        }

        return $this->sendResponse($candidates, 'Donor types fetched.');
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

    public function voteStatus(){

        $exist=Vote::where('student_id',Auth::user()->id)->first();
        $status=true;
        if(is_null($exist)){
            $status=false;
        }

        return $this->sendResponse($status, 'Status identified!');
    }
}
