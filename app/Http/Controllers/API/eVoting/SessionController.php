<?php

namespace App\Http\Controllers\API\eVoting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\eVoting\VotingSession;
use Auth;

class SessionController extends BaseController
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
        $create=VotingSession::create([
            'session'=>$request->payload['name'],
            'vote_datetime_start'=>$request->payload['vote_datetime_start'],
            'vote_datetime_end'=>$request->payload['vote_datetime_end'],
            'is_active'=>0,
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id
        ]);
        //
        return $this->sendResponse($create, 'Session stored!');

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
    public function update(Request $request, $session_id)
    {
        //
        if($request->is_active===1){
            $active_sessions=VotingSession::where([['is_active','=',1]])->get();
            foreach($active_sessions as $active_session){
                $active_session->is_active=0;
                $active_session->updated_by=Auth::user()->id;
                $active_session->save();
            }
        }
        $session=VotingSession::find($session_id);
        $session->session=$request->session;
        $session->vote_datetime_start=$request->vote_datetime_start;
        $session->vote_datetime_end=$request->vote_datetime_end;
        $session->is_active=$request->is_active;
        $session->updated_by=Auth::user()->id;
        $session->save();
        return $this->sendResponse($session, 'Session Updated!');

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
