<?php

namespace App\Http\Controllers\ShortCourseManagement\People\Participant;

use App\Models\ShortCourseManagement\Participant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function searchByIc($ic)
    {
        //
        $participant=Participant::where('ic',$ic)->first()->load(['organisations_participants.organisation']);
        return $participant;
    }
    public function searchByRepresentativeIc($ic)
    {
        //
        $participant=Participant::where('ic',$ic)->first()->load(['organisations_participants.organisation']);
        return $participant;
    }
}
