<?php

namespace App\Http\Controllers\API\eVoting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\eVoting\CandidateCategory;
use Auth;

class CandidateCategoryController extends BaseController
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
        $candidate_category=CandidateCategory::create([
            'name'=>$request->name,
            'voting_session_id' =>$request->voting_session_id,
            'created_by'=>Auth::user()->id
        ]);


        return $this->sendResponse($candidate_category, 'new candidate category created!');
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
        $candidate_category=CandidateCategory::find($id);
        $candidate_category->name=$request->name;
        $candidate_category->updated_by=Auth::user()->id;
        $candidate_category->save();

        return $this->sendResponse($candidate_category, 'Candidate category updated!');
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
        $candidate_category=CandidateCategory::find($id);
        $candidate_category->updated_by=Auth::user()->id;
        $candidate_category->deleted_by=Auth::user()->id;
        $candidate_category->save();
        $candidate_category->delete();
        return $this->sendResponse($candidate_category, 'Candidate category deleted successfully!');


    }
}
