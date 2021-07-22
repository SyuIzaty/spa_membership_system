<?php

namespace App\Http\Controllers\ShortCourseManagement\People\Trainer;
use App\User;
use App\Models\ShortCourseManagement\Trainer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainerController extends Controller
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
        $user=User::where('id', $user_id)->first()->load(['trainer']);
        return $user;
    }


}
