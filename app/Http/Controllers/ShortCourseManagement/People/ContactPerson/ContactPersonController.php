<?php

namespace App\Http\Controllers\ShortCourseManagement\People\ContactPerson;
use App\User;
use App\Models\ShortCourseManagement\ContactPerson;
use App\Models\ShortCourseManagement\Trainer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactPersonController extends Controller
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

    public function searchByUserId($user_id)
    {
        //
        $user=User::where('id', $user_id)->first()->load(['contact_person']);
        return $user;
    }

    public function searchByContactPersonIc($contact_person_ic)
    {
        //
        $contact_person=ContactPerson::where('ic', $contact_person_ic)->first();
        if($contact_person){
            $user=User::where('id', $contact_person->user_id)->first()->load(['contact_person']);
        }else{
            $trainer=Trainer::where('ic', $contact_person_ic)->first();
            $user=User::where('id', $trainer->user_id)->first()->load(['trainer']);
        }
        return $user;
    }


}
