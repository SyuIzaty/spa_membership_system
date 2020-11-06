<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function data_alluser()
    {
        $user = User::all();

        return datatables()::of($user)
           ->addColumn('action', function ($user) {
               return '<a href="/user/'.$user->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>
               <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/user/' . $user->id . '"> <i class="fal fa-trash"></i></button>';
           })
           ->rawColumns(['action'])
           ->make(true);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(StoreUserRequest $request)
    {
        User::create([
            'id' => $request->id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('message', 'User have been added');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        User::find($id)->update([
            'id' => $request->id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('message', 'User updated successfully');
    }

    public function destroy($id)
    {
        $exist = User::find($id);
        $exist->delete();
    }
}
