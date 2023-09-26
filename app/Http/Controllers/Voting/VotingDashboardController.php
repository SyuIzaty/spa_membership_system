<?php

namespace App\Http\Controllers\Voting;

use App\EvmVote;
use App\EvmVoter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VotingDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vote = EvmVote::all();

        $voteData = null;

        $selectedVote = $request->vote;

        if ($selectedVote) {
            $voteData = EvmVote::where('id', $selectedVote)->first();
        }

        if ($request->ajax()) {
            return view('voting.voting-dashboard-section', compact('voteData'));
        }

        return view('voting.voting-dashboard', compact('vote', 'voteData', 'selectedVote'));
    }

    public function getVotingDate(Request $request, $selectedVote)
    {
        $voteData = EvmVote::find($selectedVote);

        if ($voteData) {
            return response()->json([
                'success' => true,
                'start_date' => $voteData->start_date,
                'end_date' => $voteData->end_date,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Vote data not found',
            ]);
        }
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
