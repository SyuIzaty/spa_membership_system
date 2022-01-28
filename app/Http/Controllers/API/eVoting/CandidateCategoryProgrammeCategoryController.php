<?php

namespace App\Http\Controllers\API\eVoting;
use App\Models\eVoting\CandidateCategoryProgrammeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use Auth;

class CandidateCategoryProgrammeCategoryController extends BaseController
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
    public function update(Request $request)
    {
        //


        $candidate_category_programme_category_temp=
        CandidateCategoryProgrammeCategory::where([
            ['programme_category_id', '=',$request->programme_category_id],
            ['candidate_category_id', '=',$request->candidate_category_id]
            ])
        ->first();

        if($candidate_category_programme_category_temp && !is_null($candidate_category_programme_category_temp)){

            return $this->sendError("The programme category is already added to this candidate category!");

        }else{
            $candidate_category_programme_categories=
            CandidateCategoryProgrammeCategory::where('programme_category_id', $request->programme_category_id)
            ->get();
            if(!is_null($candidate_category_programme_categories) && count($candidate_category_programme_categories)>0)
            {
                foreach($candidate_category_programme_categories as $candidate_category_programme_category){
                    $candidate_category_programme_category->updated_by=Auth::user()->id;
                    $candidate_category_programme_category->deleted_by=Auth::user()->id;
                    $candidate_category_programme_category->save();
                    $candidate_category_programme_category->delete();
                }

            }
            $candidate_category_programme_category_query=CandidateCategoryProgrammeCategory::create([
                'candidate_category_id'=>$request->candidate_category_id,
                'programme_category_id'=>$request->programme_category_id,
                'created_by'=>Auth::user()->id
            ])->load(['programme_category.programmes']);
            return $this->sendResponse($candidate_category_programme_category_query->programme_category, 'Programme Category Added!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($candidate_category_id, $programme_category_id)
    {
        //
        $candidate_category_programme_category=CandidateCategoryProgrammeCategory::where([
            ['candidate_category_id',$candidate_category_id],
            ['programme_category_id',$programme_category_id]
        ])->first();

        $candidate_category_programme_category->updated_by=Auth::user()->id;
        $candidate_category_programme_category->deleted_by=Auth::user()->id;
        $candidate_category_programme_category->save();
        $candidate_category_programme_category->delete();

    return $this->sendResponse($candidate_category_programme_category, 'Deletion Succeed!');
    }
}
