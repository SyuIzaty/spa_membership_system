<?php

namespace App\Http\Controllers\API\eVoting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eVoting\Vote;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\eVoting\Candidate;
use App\Models\eVoting\CandidateCategory;
use App\Models\eVoting\VotingSession;
use App\Student;
use Config;

use Carbon\Carbon;
use stdClass;
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

    public function categoricalStatistics(){

        if(Auth::user()->category!=='STF'){

            $student=Student::where('students_id',Auth::user()->id)
            ->first()->load(['programme.programme_category.candidate_category_programme_category_s']);
            $candidate_category_programme_category_s=$student->programme->programme_category->candidate_category_programme_category_s;
            $candidate_category_ids=[];


            foreach($candidate_category_programme_category_s as $candidate_category_programme_category){
                array_push($candidate_category_ids,$candidate_category_programme_category->candidate_category_id);
            }

            $candidate_categories = CandidateCategory::whereIn('id',$candidate_category_ids)->get()->load(
                ['candidate_category_programme_category_s.programme_category.programmes.students.votes',
                'candidate_category_programme_category_s.programme_category.programmes.students.candidates.votes',
                'candidate_category_programme_category_s.programme_category.programmes.students.candidates.student'
            ]);
        }else{
            $candidate_categories = CandidateCategory::all()->load(
                ['candidate_category_programme_category_s.programme_category.programmes.students.votes',
                'candidate_category_programme_category_s.programme_category.programmes.students.candidates.votes',
                'candidate_category_programme_category_s.programme_category.programmes.students.candidates.student'
            ]);
        }

        $categorical_statistics=[];
        foreach($candidate_categories as $candidate_category){
            $statistics['candidate_category']=$candidate_category->name;
            $statistics['total_turnouts']=0;
            $statistics['total_not_turnouts']=0;
            $statistics['programme_categories']=[];
            $statistics['programmes']=[];
            // $statistics['candidates']=[];
            $statistics['candidate_names']=[];
            $statistics['total_voted']=[];
            foreach($candidate_category->candidate_category_programme_category_s as $candidate_category_programme_category){
                array_push($statistics['programme_categories'],$candidate_category_programme_category->programme_category->name);
                foreach($candidate_category_programme_category->programme_category->programmes as $programme){
                    array_push($statistics['programmes'],$programme->name);
                    foreach($programme->students as $student){
                        if(!is_null($student->votes) && count($student->votes)>0){
                            $statistics['total_turnouts']+=1;
                        }else{
                            $statistics['total_not_turnouts']+=1;
                        }
                        foreach($student->candidates as $candidate){
                            // $candidate_temp=$candidate;
                            array_push($statistics['candidate_names'],$candidate->student->students_name);
                            array_push($statistics['total_voted'],count($candidate->votes));
                        }
                    }

                }
            }
            array_push($categorical_statistics, $statistics);
        }
        return $this->sendResponse($categorical_statistics, 'Vote Categories Fetched!');
    }

    public function categoricalReport(){
        $candidate_categories = CandidateCategory::all()->load(
            ['candidate_category_programme_category_s.programme_category.programmes.students.votes',
            'candidate_category_programme_category_s.programme_category.programmes.students.candidates.votes',
            'candidate_category_programme_category_s.programme_category.programmes.students.candidates.student.state'
        ]);
        $categorical_statistics=[];
        foreach($candidate_categories as $candidate_category){
            $statistics['name']=$candidate_category->name;
            $statistics['description']="";
            $statistics['total_turnouts']=0;
            $statistics['total_not_turnouts']=0;
            $statistics['programme_categories_name']=[];
            $statistics['programme_categories_description']=[];
            $statistics['programmes']=[];
            $statistics['candidates']=[];
            // $statistics['candidate_names']=[];
            // $statistics['total_voted']=[];
            foreach($candidate_category->candidate_category_programme_category_s as $candidate_category_programme_category){
                array_push($statistics['programme_categories_name'],$candidate_category_programme_category->programme_category->short_name);
                array_push($statistics['programme_categories_description'],$candidate_category_programme_category->programme_category->description);
                $statistics['description'].=$candidate_category_programme_category->programme_category->description;
                foreach($candidate_category_programme_category->programme_category->programmes as $programme){
                    array_push($statistics['programmes'],$programme->name);
                    foreach($programme->students as $student){
                        if(!is_null($student->votes) && count($student->votes)>0){
                            $statistics['total_turnouts']+=1;
                        }else{
                            $statistics['total_not_turnouts']+=1;
                        }
                        foreach($student->candidates as $candidate){
                            $candidate_temp=new stdClass();
                            $candidate_temp->id=$candidate->id;
                            $candidate_temp->name=$candidate->student->students_name;
                            $candidate_temp->age=null;
                            if(!is_null($candidate->student->state)){
                                $candidate_temp->origin=$candidate->student->state->state_name;
                            }else{
                                $candidate_temp->origin=null;
                            }
                            $candidate_temp->student_id=$candidate->student->students_id;
                            $candidate_temp->gender=$candidate->student->students_gender;
                            $candidate_temp->phone=$candidate->student->students_phone;
                            $candidate_temp->email=$candidate->student->students_email;
                            $candidate_temp->programme=$candidate->student->students_programme;
                            $candidate_temp->current_semester=$candidate->student->current_semester;
                            $candidate_temp->total_semester=null;
                            $candidate_temp->result=null;
                            $candidate_temp->total_vote=count($candidate->votes);
                            array_push($statistics['candidates'],$candidate_temp);
                            // array_push($statistics['candidate_names'],$candidate->student->students_name);
                            // array_push($statistics['total_voted'],count($candidate->votes));
                        }
                    }

                }
            }
            $statistics['total_students']=$statistics['total_turnouts']+$statistics['total_not_turnouts'];
            array_push($categorical_statistics, $statistics);
        }
        return $this->sendResponse($categorical_statistics, 'Vote Categories Fetched!');
    }
    public function overallReport(){

        $candidate_categories = CandidateCategory::all()->load(
            ['candidate_category_programme_category_s.programme_category.programmes.students.votes',
            'candidate_category_programme_category_s.programme_category.programmes.students.candidates.votes',
            'candidate_category_programme_category_s.programme_category.programmes.students.candidates.student.state'
        ]);
        $categorical_statistics=[];
        $overallReport = new stdClass();
        $overallReport->total_students=0;
        $overallReport->total_turnouts=0;
        $overallReport->total_not_turnouts=0;
        foreach($candidate_categories as $candidate_category){
            $statistics['name']=$candidate_category->name;
            $statistics['description']="";
            $statistics['total_turnouts']=0;
            $statistics['total_not_turnouts']=0;
            $statistics['programme_categories_name']=[];
            $statistics['programme_categories_description']=[];
            $statistics['programmes']=[];
            $statistics['candidates']=[];
            // $statistics['candidate_names']=[];
            // $statistics['total_voted']=[];
            foreach($candidate_category->candidate_category_programme_category_s as $candidate_category_programme_category){
                array_push($statistics['programme_categories_name'],$candidate_category_programme_category->programme_category->short_name);
                array_push($statistics['programme_categories_description'],$candidate_category_programme_category->programme_category->description);
                $statistics['description'].=$candidate_category_programme_category->programme_category->description;
                foreach($candidate_category_programme_category->programme_category->programmes as $programme){
                    array_push($statistics['programmes'],$programme->name);
                    foreach($programme->students as $student){

                        $overallReport->total_students+=1;
                        if(!is_null($student->votes) && count($student->votes)>0){

                            $overallReport->total_turnouts+=1;
                            $statistics['total_turnouts']+=1;
                        }else{
                            $overallReport->total_not_turnouts+=1;
                            $statistics['total_not_turnouts']+=1;
                        }
                        foreach($student->candidates as $candidate){
                            $candidate_temp=new stdClass();
                            $candidate_temp->id=$candidate->id;
                            $candidate_temp->name=$candidate->student->students_name;
                            $candidate_temp->age=null;
                            if(!is_null($candidate->student->state)){
                                $candidate_temp->origin=$candidate->student->state->state_name;
                            }else{
                                $candidate_temp->origin=null;
                            }
                            $candidate_temp->student_id=$candidate->student->students_id;
                            $candidate_temp->gender=$candidate->student->students_gender;
                            $candidate_temp->phone=$candidate->student->students_phone;
                            $candidate_temp->email=$candidate->student->students_email;
                            $candidate_temp->programme=$candidate->student->students_programme;
                            $candidate_temp->current_semester=$candidate->student->current_semester;
                            $candidate_temp->total_semester=null;
                            $candidate_temp->result=null;
                            $candidate_temp->total_vote=count($candidate->votes);
                            array_push($statistics['candidates'],$candidate_temp);
                            // array_push($statistics['candidate_names'],$candidate->student->students_name);
                            // array_push($statistics['total_voted'],count($candidate->votes));
                        }
                    }

                }
            }
            $statistics['total_students']=$statistics['total_turnouts']+$statistics['total_not_turnouts'];
            array_push($categorical_statistics, $statistics);
        }
        return $this->sendResponse($overallReport, 'Vote Categories Fetched!');
    }

    public function getVoteIsOpen(){

        $mytime = Carbon::now();
        $exist=VotingSession::where([
            ['is_active','=',1],
        ['vote_datetime_start','<=',$mytime],
        ['vote_datetime_end','>=',$mytime]
        ])
        ->first();

        if(!is_null($exist)){
            $is_open=true;
        }else{
            $is_open=false;
        }
        return $this->sendResponse($is_open, 'Vote Is Open Fetched!');
    }

    public function getVoteSessions(){

        $exist=VotingSession::all();

        return $this->sendResponse($exist, 'Vote sessions fetched!');
    }
    public function getVoteSessionDetails($id){
        $session=VotingSession::find($id);
        $candidate_categories=CandidateCategory::where('voting_session_id', $id)->get()->load([
            'candidate_category_programme_category_s.programme_category.programmes'
        ]);
        $index=0;
        foreach($candidate_categories as $candidate_category){
            $programmes=[];
            $programme_categories=[];
            foreach($candidate_category->candidate_category_programme_category_s
            as  $candidate_category_programme_category){
                array_push($programme_categories,$candidate_category_programme_category->programme_category);
                foreach($candidate_category_programme_category->programme_category->programmes as $programme){
                    array_push($programmes,$programme->code);

                }
            }
            $candidates=Candidate::join(config('global_env.DB_DATABASE_SIMS').'.students',config('global_env.DB_DATABASE_SIMS').'.students.students_id','=','evs_candidate.student_id')->whereHas('student', function ($query) use($programmes){
                $query->whereIn('students_programme',$programmes);
            })->where('voting_session_id', $id)->get();
            $candidate_categories[$index]->programme_categories=$programme_categories;
            $candidate_categories[$index]->candidates=$candidates;
            $index+=1;
        }
        $session->candidate_categories=$candidate_categories;
        return $this->sendResponse($session, 'Vote sessions fetched!');
    }
}
