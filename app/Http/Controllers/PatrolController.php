<?php

namespace App\Http\Controllers;

use App\Patrol;
use Illuminate\Http\Request;

class PatrolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo 'hahah';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('log_input');
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
     * @param  \App\Patrol  $patrol
     * @return \Illuminate\Http\Response
     */
    public function show(Patrol $patrol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patrol  $patrol
     * @return \Illuminate\Http\Response
     */
    public function edit(Patrol $patrol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patrol  $patrol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patrol $patrol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patrol  $patrol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patrol $patrol)
    {
        //
    }
}
