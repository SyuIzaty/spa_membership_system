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
use Illuminate\Support\Facades\Date;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VotingManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('voting.vote-list');
    }

    public function data_vote_list()
    {
        $data = EvmVote::select('evm_votes.*');

        return datatables()::of($data)

        ->addColumn('status', function ($data) {

            $currentDateTime = Carbon::now();

            if ($data->end_date < $currentDateTime) {

                $status = '<div style="color:red;"><b>Outdated</b></div>';

            } elseif ($data->start_date <= $currentDateTime && $data->end_date >= $currentDateTime) {

                $status = '<div style="color:green;"><b>Active</b></div>';

            } else {

                $status = '<div style="color:black;"><b>Upcoming</b></div>';
            }

            return $status ?? '<div style="color:red;" > N/A </div>';
        })

        ->addColumn('action', function ($data) {

            $exist = EvmCategory::where('vote_id', $data->id)->first();

            if(isset($exist)){

                    $verify = EvmCandidate::where('verify_status', 'Y')->whereHas('programme', function($query) use($exist){
                        $query->where('category_id', $exist->id);
                    })->first();

                    if(!isset($verify)){
                        return '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$data->id.'" data-name="'.$data->name.'" data-description="'.$data->description.'"
                                data-start_date="'.$data->start_date.'" data-end_date="'.$data->end_date.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>';
                    }
            }else{
                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$data->id.'" data-name="'.$data->name.'" data-description="'.$data->description.'"
                        data-start_date="'.$data->start_date.'" data-end_date="'.$data->end_date.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/voting-manage/' . $data->id . '"><i class="fal fa-trash"></i></button>';
            }

        })

        ->addColumn('setting', function ($data) {

                return '<a href="/voting-setting/' . $data->id . '" class="btn btn-sm btn-info"><i class="fal fa-cogs"></i></a>';
        })

        ->editColumn('id', function ($data) {

            return '#'.$data->id;
        })

        ->editColumn('start_date', function ($data) {

            return isset($data->start_date) ? date(' Y-m-d ', strtotime($data->start_date)).' | '.date(' h:i A ', strtotime($data->start_date)).'<br>('.date(' l ', strtotime($data->start_date)).')' : '<div style="color:red;" > N/A </div>';
        })

        ->editColumn('end_date', function ($data) {

            return isset($data->end_date) ? date(' Y-m-d ', strtotime($data->end_date)).' | '.date(' h:i A ', strtotime($data->end_date)).'<br>('.date(' l ', strtotime($data->end_date)).')' : '<div style="color:red;" > N/A </div>';
        })

        ->rawColumns(['action', 'status', 'name', 'start_date', 'end_date','setting'])
        ->make(true);
    }

    public function vote_setting($id)
    {
        $vote = EvmVote::where('id', $id)->first();

        $programme = Programme::all();

        $student = Student::where('students_status','AKTIF')->get();

        return view('voting.vote-setting', compact('vote','programme','student'));
    }

    public function vote_setting_store(Request $request)
    {
        $request->validate([
            'category_name'          => 'required',
            'category_description'   => 'nullable',
            'programme_code'         => 'required',
        ]);

        $category = EvmCategory::create([
            'vote_id'                   => $request->voteId,
            'category_name'             => $request->category_name,
            'category_description'      => $request->category_description,
            'created_by'                => Auth::user()->id,
            'updated_by'                => Auth::user()->id,
        ]);

        $programme = EvmProgramme::create([
            'category_id'       => $category->id,
            'programme_code'    => $request->programme_code,
            'created_by'        => Auth::user()->id,
            'updated_by'        => Auth::user()->id,
        ]);

        Session::flash('message',' Category is saved successfully.');

        return redirect()->back();
    }

    public function vote_setting_update(Request $request)
    {
        $request->validate([
            'names'             => 'required',
            'descriptions'      => 'nullable',
            'programme_codes'   => 'required',
        ]);

        $category = EvmCategory::where('id', $request->ids)->update([
            'category_name'             => $request->names,
            'category_description'      => $request->descriptions,
            'updated_by'                => Auth::user()->id,
        ]);

        $programme = EvmProgramme::where('category_id',$request->ids)->first();

        $programme->update([
            'programme_code'    => $request->programme_codes,
            'updated_by'        => Auth::user()->id,
        ]);

        Session::flash('message',' Category is updated successfully.');

        return redirect()->back();
    }

    public function vote_setting_delete($id)
    {
        $category = EvmCategory::findOrFail($id);

        $programmes = EvmProgramme::where('category_id', $category->id)->get();

        foreach ($programmes as $programme) {

            $candidates = EvmCandidate::where('programme_id', $programme->id)->get();

                foreach ($candidates as $candidate) {
                    $candidate->update(['deleted_by' => Auth::user()->id]);
                }

            EvmCandidate::where('programme_id', $programme->id)->delete();

            $programme->update(['deleted_by' => Auth::user()->id]);
            $programme->delete();
        }

        $category->update(['deleted_by' => Auth::user()->id]);
        $category->delete();

        return response()->json(['message' => 'Category is deleted successfully.']);
    }

    public function vote_candidate_store(Request $request)
    {
        $request->validate([
            'student_id'      => 'required',
            'student_tagline' => 'required',
            'img_name'        => 'required',
        ]);

        $student = Student::where('students_id', $request->student_id)->first();

        $candidate = EvmCandidate::create([
            'programme_id'      => $request->id,
            'student_id'        => $request->student_id,
            'student_programme' => $student->students_programme,
            'student_session'   => $student->current_session,
            'student_tagline'   => $request->student_tagline,
            'created_by'        => Auth::user()->id,
            'updated_by'        => Auth::user()->id,
        ]);

        $file = $request->img_name;

        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileName = $originalName;
        $file->storeAs('/voting', date('dmyhi').' - '.$fileName);

        $candidate->update([
            'img_name'         => date('dmyhi').' - '.$originalName,
            'img_size'         => $fileSize,
            'img_path'         => "voting/".date('dmyhi').' - '.$fileName,
        ]);

        Storage::disk('minio')->put($candidate->img_path, file_get_contents($file));

        Session::flash('message',' Candidate is saved successfully for '.$candidate->programme->programme->programme_name.' under '.$candidate->programme->category->category_name.'.');

        return redirect()->back();
    }

    public function vote_candidate_update(Request $request)
    {
        $request->validate([
            'student_taglines'  => 'required',
            'img_names'         => 'nullable',
        ]);

        $candidate = EvmCandidate::where('id', $request->candidateId)->first();

        if (!$candidate) {
            abort(404);
        }

        $file = $request->img_names;

        if (isset($file)) {

            if(isset($candidate->img_name)){
                if(Storage::disk('minio')->exists($candidate->img_path) == 'true'){
                    Storage::disk('minio')->delete($candidate->img_path);
                }
            }

            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileName = date('dmyhi') . ' - ' . $originalName;
            $file->storeAs('/voting', $fileName);

            $candidate->update([
                'student_tagline'   => $request->student_taglines,
                'img_name'          => $fileName,
                'img_size'          => $fileSize,
                'img_path'          => "voting/$fileName",
                'updated_by'        => Auth::user()->id,
            ]);

            Storage::disk('minio')->put($candidate->img_path, file_get_contents($file));

        } else {
            $candidate->update([
                'student_tagline'   => $request->student_taglines,
                'updated_by'        => Auth::user()->id,
            ]);
        }

        Session::flash('message',' Candidate is updated successfully for '.$candidate->programme->programme->programme_name.' under '.$candidate->programme->category->category_name.'.');

        return redirect()->back();
    }

    public function vote_candidate_delete($id)
    {
        $candidate = EvmCandidate::findOrFail($id);

        $candidate->update(['deleted_by' => Auth::user()->id]);

        if(Storage::disk('minio')->exists($candidate->img_path) == 'true'){
            Storage::disk('minio')->delete($candidate->img_path);
        }

        $candidate->delete();

        $message = 'Candidate is deleted successfully for ' . $candidate->programme->programme->programme_name . ' under ' . $candidate->programme->category->category_name . '.';

        return response()->json(['message' => $message]);
    }

    public function get_candidate($programmeId, $id)
    {
        $exist = EvmCandidate::select('student_id')->where('programme_id', $id)->pluck('student_id')->toArray();

        $students = Student::where('students_programme', $programmeId)->where('students_status','AKTIF')->whereNotIn('students_id', $exist)->get();

        return response()->json($students);
    }

    public function data_candidate_list(Request $request)
    {
        $programmeId = $request->input('programme_id');

        $data = EvmCandidate::where('programme_id', $programmeId)->with(['student'])->get();

        return datatables()::of($data)

        ->addColumn('img_name', function ($data) {

            $imgSrc = isset($data->img_name) ? "<a data-fancybox='gallery' href='/get-candidate-image/{$data->img_name}'>
            <img src='/get-candidate-image/{$data->img_name}' style='width:100px; height:100px' class='img-fluid'></a>" :
            "<img style='width:100px; height:100px' src='" . asset('img/default.png') . "'>";
            return $imgSrc;
        })

        ->addColumn('student_name', function ($data) {
            return $data->student->students_name ?? 'N/A';
        })

        ->addColumn('student_tagline', function ($data) {
            return $data->student_tagline ?? 'N/A';
        })

        ->addColumn('cast_vote', function ($data) {

            $records = EvmCandidate::where('programme_id', $data->programme_id)->get();

            $highest_cast_vote = 0;
            $highest_cast_vote_index = 0;

            foreach ($records as $index => $record) {
                if ($record->cast_vote > $highest_cast_vote) {
                    $highest_cast_vote = $record->cast_vote;
                    $highest_cast_vote_index = $index;
                }
            }

            $formatted_cast_vote = $data->cast_vote ?? 0;

            if ($highest_cast_vote === null || $highest_cast_vote === 0) {

                $formatted_cast_vote = '<span style="color: green; font-weight: bold;">' . $formatted_cast_vote . '</span>';
            } elseif ($data->cast_vote === $highest_cast_vote) {

                $formatted_cast_vote = '<span style="color: green; font-weight: bold;">' . $formatted_cast_vote . '</span>';
            }

            return $formatted_cast_vote;
        })

        ->addColumn('voter', function ($data) {

            return "<a href='/voter-list/{$data->id}' class='btn btn-xs btn-info'><i class='fal fa-users'></i></a>";
        })

        // ->addColumn('verify', function ($data) {
        //     if ($data->verify_status === 'Y') {
        //         return '<div style="text-align: left;">
        //                     <p>VERIFIED BY:<br><b>' . $data->staff->staff_name . '</b></p>
        //                     <p>VERIFIED ON:<br><b>' . date('d-m-Y', strtotime($data->verify_date)) . '</b></p>
        //                     REMARK:<br><b>' . $data->verify_remark . '</b>
        //                 </div>';
        //     }

        //     $endTimestamp = strtotime($data->programme->category->vote->end_date);
        //     $threeDaysAfterEndTimestamp = $endTimestamp + (3 * 24 * 60 * 60); // 3 days * 24 hours * 60 minutes * 60 seconds
        //     $currentTimestamp = now()->timestamp;

        //     if (!($currentTimestamp > $endTimestamp && $currentTimestamp <= $threeDaysAfterEndTimestamp)) {
        //         return 'N/A';
        //     }

        //     $exist = EvmCandidate::where('programme_id', $data->programme_id)->where('verify_status', 'Y')->first();

        //     if (isset($exist)) {
        //         return 'N/A';
        //     }

        //     $records = EvmCandidate::where('programme_id', $data->programme_id)->get();
        //     $highest_cast_vote = 0;
        //     $highest_cast_vote_index = 0;

        //     foreach ($records as $index => $record) {
        //         if ($record->cast_vote > $highest_cast_vote) {
        //             $highest_cast_vote = $record->cast_vote;
        //             $highest_cast_vote_index = $index;
        //         }
        //     }

        //     $formatted_cast_vote = $data->cast_vote ?? 0;

        //     if ($highest_cast_vote === null || $highest_cast_vote === 0) {

        //         $formatted_cast_vote = '<input type="checkbox" class="verification-checkbox" data-id="' . $data->id . '">';
        //     } elseif ($data->cast_vote === $highest_cast_vote) {

        //         $formatted_cast_vote = '<input type="checkbox" class="verification-checkbox" data-id="' . $data->id . '">';
        //     } else {
        //         $formatted_cast_vote = 'N/A';
        //     }

        //     return $formatted_cast_vote;
        // })

        ->addColumn('verify', function ($data) {
            if ($data->verify_status === 'Y') {
                return '<div style="text-align: left;">
                            <p>VERIFIED BY:<br><b>' . $data->staff->staff_name . '</b></p>
                            <p>VERIFIED ON:<br><b>' . date('d-m-Y', strtotime($data->verify_date)) . '</b></p>
                            REMARK:<br><b>' . $data->verify_remark . '</b>
                        </div>';
            }

            $endTimestamp = strtotime($data->programme->category->vote->end_date);
            $threeDaysAfterEndTimestamp = $endTimestamp + (3 * 24 * 60 * 60); // 3 days * 24 hours * 60 minutes * 60 seconds
            $currentTimestamp = now()->timestamp;

            if (!($currentTimestamp > $endTimestamp && $currentTimestamp <= $threeDaysAfterEndTimestamp)) {
                return 'N/A';
            }

            $exist = EvmCandidate::where('programme_id', $data->programme_id)->where('verify_status', 'Y')->first();

            if (isset($exist)) {
                return 'N/A';
            } else {
                return '<input type="checkbox" class="verification-checkbox" data-id="' . $data->id . '">';
            }
        })

        ->addColumn('action', function ($data) {

            $existInVoter = EvmVoter::where('candidate_id', $data->id)->first();

            if(isset($existInVoter)){
                return '<div class="btn-group"><a href="" data-target="#crud-modal-candidates" data-toggle="modal" data-id="'.$data->id.'" data-student="'.$data->student_id.'"
                        data-tagline="'.$data->student_tagline.'" data-image="'.$data->img_name.'" class="btn btn-xs btn-warning mr-2"><i class="fal fa-pencil"></i></a>';
            } else {
                return '<div class="btn-group"><a href="" data-target="#crud-modal-candidates" data-toggle="modal" data-id="'.$data->id.'" data-student="'.$data->student_id.'"
                        data-tagline="'.$data->student_tagline.'" data-image="'.$data->img_name.'" class="btn btn-xs btn-warning mr-2"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-xs btn-danger btn-delete" data-remote="/voting-candidate-delete/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->addIndexColumn()
        ->rawColumns(['img_name', 'student_id', 'student_name', 'student_tagline', 'cast_vote', 'voter', 'verify', 'action'])
        ->make(true);
    }

    public function get_candidate_image($filename)
    {
        return Storage::disk('minio')->response('voting/'.$filename);
    }

    public function verify_candidate($id, Request $request)
    {
        $record = EvmCandidate::find($id);

        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $record->update([
            'verify_status'     => 'Y',
            'verify_date'       => now(),
            'verify_remark'     => $request->input('verificationReason'),
            'verify_by'         => Auth::user()->id,
        ]);

        return response()->json(['message' => 'Candidate verified successfully.']);
    }

    public function voter_list($id)
    {
        $candidate = EvmCandidate::where('id', $id)->first();

        return view('voting.voter-list', compact('candidate'));
    }

    public function data_voter_list($id)
    {
        $data = EvmVoter::where('candidate_id', $id)->with(['student','programme'])->get();

        return datatables()::of($data)

        ->editColumn('id', function ($data) {

            return '#'.$data->id;
        })

        ->editColumn('voter_name', function ($data) {

            return $data->student->students_name ?? 'N/A';
        })

        ->editColumn('voter_programme', function ($data) {

            return $data->programme->programme_name ?? 'N/A';
        })

        ->editColumn('created_at', function ($data) {

            return isset($data->created_at) ? date(' Y-m-d ', strtotime($data->created_at)).' | '.date(' h:i A ', strtotime($data->created_at)) : '<div style="color:red;" > N/A </div>';
        })

        ->rawColumns(['id', 'voter_name', 'voter_id', 'created_at','voter_programme'])
        ->make(true);
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
        $request->validate([
            'name'          => 'required',
            'description'   => 'nullable',
            'start_date'    => [
                'required',
                'date',
                'after_or_equal:' . Date::today()->toDateString(),
            ],
            'end_date'      => [
                'required',
                'date',
                'after:start_date',
            ],
        ]);

        EvmVote::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'created_by'      => Auth::user()->id,
            'updated_by'      => Auth::user()->id,
        ]);

        Session::flash('message',' Data is saved successfully.');
        return redirect()->back();
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
        $request->validate([
            'names' => 'required',
            'descriptions' => 'nullable',
            'start_dates' => [
                'required',
                'date',
                'after_or_equal:' . Date::today()->toDateString(),
            ],
            'end_dates' => [
                'required',
                'date',
                'after:start_dates',
            ],
        ]);

        EvmVote::where('id', $request->ids)->update([
            'name'            => $request->names,
            'description'     => $request->descriptions,
            'start_date'      => $request->start_dates,
            'end_date'        => $request->end_dates,
            'updated_by'      => Auth::user()->id,
        ]);

        Session::flash('message',' Data is updated successfully.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $vote = EvmVote::findOrFail($id);

        $categories = EvmCategory::where('vote_id', $vote->id)->get();
        foreach ($categories as $category) {
            $programmes = EvmProgramme::where('category_id', $category->id)->get();
            foreach ($programmes as $programme) {
                $candidates = EvmCandidate::where('programme_id', $programme->id)->get();
                foreach ($candidates as $candidate) {
                    $candidate->update(['deleted_by' => Auth::user()->id]);
                }
                EvmCandidate::where('programme_id', $programme->id)->delete();
                $programme->update(['deleted_by' => Auth::user()->id]);
                $programme->delete();
            }
            $category->update(['deleted_by' => Auth::user()->id]);
            $category->delete();
        }

        $vote->update(['deleted_by' => Auth::user()->id]);
        $vote->delete();

        return response()->json(['success' => 'Data is deleted successfully.']);
    }

}
