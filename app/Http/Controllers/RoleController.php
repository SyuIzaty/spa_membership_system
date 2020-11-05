<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\ModuleAuth;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('role.index');
    }

    public function data_allrole()
    {
        $role = Role::all();

        return datatables()::of($role)
           ->addColumn('action', function ($role) {
               return '<a href="/role/'.$role->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>
               <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/role/' . $role->id . '"> <i class="fal fa-trash"></i></button>';
           })
           ->rawColumns(['action'])
           ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $module = ModuleAuth::all();
        $permission = Permission::all();
        return view('role.create', compact('permission','module'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->except(['_token']));
        $role->syncPermissions($request->permission_id);

        return redirect()->back()->with('message', 'Role have been added');
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
        $role = Role::find($id);
        $module = ModuleAuth::all();
        $permission = Permission::all();
        $role_permission = $role->getAllPermissions();
        return view('role.edit',compact('role','role_permission','permission','module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::find($id);
        if(isset($request->permission_id)){
            foreach($request->permission_id as $perm){
                $role->givePermissionTo($perm);
            }
        }
        Role::find($id)->update($request->all());

        return redirect()->back()->with('message', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = Role::find($id);
        $exist->delete();
        return response()->json(['success'=>'Role deleted successfully.']);
    }

    public function delete($id, $role_id)
    {
        $role = Role::where('id',$role_id)->first();
        $permission = Permission::find($id);
        $permission->removeRole($role);
        return redirect()->back()->with('message', 'Permission Deleted');
    }
}
