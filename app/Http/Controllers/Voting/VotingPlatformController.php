<?php

namespace App\Http\Controllers\Voting;

use Auth;
use Session;
use Carbon\Carbon;
use App\EvmVote;
use App\Student;
use App\EvmCategory;
use App\EvmProgramme;
use App\EvmCandidate;
use App\Programme;
use App\EvmVoter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VotingPlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::where('students_id', '2021039049')->first();

        $today = now();

        $vote = EvmVote::whereHas('categories.programmes', function($query) use ($student){
            $query->where('programme_code', $student->students_programme);
        })
        ->where('start_date', '<=', $today)
        ->where('end_date', '>=', $today)
        ->get();

        return view('voting.voting-list', compact('vote','student'));
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
        $candidate = EvmCandidate::whereHas('programme', function($query) use($id){
            $query->whereHas('category', function($subQuery) use($id){
                $subQuery->where('id', $id);
            });
        })->get();

        $category = EvmCategory::where('id', $id)->first();

        return view('voting.voting-platform', compact('candidate','category'));
    }

    public function voting_store(Request $request)
    {
        $candidateId = $request->input('candidate_id');

        $candidate = EvmCandidate::find($candidateId);

        if ($candidate) {

            if (is_null($candidate->cast_vote)) {

                $candidate->cast_vote = 1;
            } else {

                $candidate->cast_vote += 1;
            }

            $candidate->save();

            $student = Student::where('students_id', '2021039049')->first();

            EvmVoter::create([
                'candidate_id'      => $candidate->id,
                'voter_id'          => $student->students_id,
                'voter_programme'   => $student->students_programme,
                'voter_session'     => $student->current_session,
                'created_by'        => Auth::user()->id,
                'updated_by'        => Auth::user()->id,
            ]);

            return response()->json(['message' => 'Vote casted successfully.']);

        } else {

            return response()->json(['message' => 'Candidate not found.'], 404);
        }
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
