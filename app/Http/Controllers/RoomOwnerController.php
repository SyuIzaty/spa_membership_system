<?php

namespace App\Http\Controllers;

use Redirect;
use App\Roomowner;
use Illuminate\Http\Request;

class RoomOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['roomowner'] = Roomowner::all();
        return view('space.roomowner.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('space.roomowner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Roomowner $roomowner)
    {

        $request->validate([
            'name'                => 'required|min:3|max:255',                        
            'phone_number'        => 'required|regex:/(\+?0)[0-46-9]-*[0-9]{7,8}/|unique:roomowners,phone_number',  
            'email'               => 'required|unique:roomowners,email',    
            'dateofbirth'         => 'required|date', 
            'gender'              => 'required|in:male,female',    
            'active'              => 'required', 
            'image'               => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', //2048kb = 2.04mb
        ]);

        if($request->image->getClientOriginalExtension())
        {
            $ext = $request->image->getClientOriginalExtension();
            $file = date('YmdHis').rand(1,99999).'.'.$ext;
            $request->image->storeAs('public/space',$file);
        }
        else
        {
            $file = '';
        }
       
        $roomowner->name = $request->name;
        $roomowner->phone_number = $request->phone_number;
        $roomowner->email = $request->email;
        $roomowner->dateofbirth = $request->dateofbirth;
        $roomowner->gender = $request->gender;
        $roomowner->active = $request->active;
        $roomowner->image = $file;
        $roomowner->save();
        return redirect()->route('roomowner.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Roomowner $roomowner)
    {
        $arr['roomowner'] = $roomowner;
        return view('space.roomowner.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Roomowner $roomowner)
    {
        return view('space.roomowner.edit',compact('roomowner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roomowner $roomowner)
    {

        if(!empty($request->image))
            $fields['image'] = $request->image;
        
        $fields['name'] = $request->name;                      
        $fields['phone_number'] = $request->phone_number;  
        $fields['email'] = $request->email;
        $fields['dateofbirth'] = $request->dateofbirth;
        $fields['gender'] = $request->gender;
        $fields['active'] =  $request->active;

        $this->validateRequest(array_keys($fields));

        if(isset($request->image) && $request->image->getClientOriginalName())
        {
            $ext = $request->image->getClientOriginalExtension();
            $file = date('YmdHis').rand(1,99999).'.'.$ext;
            $request->image->storeAs('public/space',$file);
        }
        else
        {    
            if(!$roomowner->image)
                $file = '';
            else
                $file = $roomowner->image;
        }

        $roomowner->name = $request->name;
        $roomowner->phone_number = $request->phone_number;
        $roomowner->email = $request->email;
        $roomowner->dateofbirth = $request->dateofbirth;
        $roomowner->gender = $request->gender;
        $roomowner->active = $request->active;
        $roomowner->image = $file;
        $roomowner->update();
        return redirect()->route('roomowner.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roomowner $roomowner)
    {
        $roomowner->delete();
        return redirect()->route('space.roomowner.index');
    }

 public function data_roomowner_list()
    {
        $roomowner = Roomowner::select('*');

        return datatables()::of($roomowner)
        ->addColumn('action', function ($roomowner) {

            return '<a href="/space/roomowner/'.$roomowner->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <a href="/space/roomowner/'.$roomowner->id.'" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/space/roomowner/' . $roomowner->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })
            
        ->make(true);
    }

    public function validateRequest($input=[])
    {
        $request = [
            'name'                => 'required|min:3|max:255',                        
            'phone_number'        => 'required|regex:/(\+?0)[0-46-9]-*[0-9]{7,8}/|unique:roomowners,phone_number',  
            'email'               => 'required|unique:roomowners,email',    
            'dateofbirth'         => 'required|date', 
            'gender'              => 'required|in:male,female',    
            'active'              => 'required', 
            'image'               => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', //2048kb = 2.04mb
        ];

        if(!empty($input))
            $request = array_filter(
                $request, 
                function ($var) use ($input) {
                    return in_array($var, $input);
                },
                ARRAY_FILTER_USE_KEY
                //ARRAY_FILTER_USE_KEY is used with array_filter() to pass each key as the first argument to the given callback function
                //ARRAY_FILTER_USE_BOTH is used with array_filter() to pass both value and key to the given callback function
            );

        return request()->validate($request);
    }

}

