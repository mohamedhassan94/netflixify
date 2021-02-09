<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:read_roles')->only([ 'index' ]);
        $this->middleware('permission:create_roles')->only([ 'create' , 'store' ]);
        $this->middleware('permission:update_roles')->only([ 'edit' , 'update']);
        $this->middleware('permission:delete_roles')->only(['destroy']);
    }


    public function index(Request $request)
    {
        $searchTerm = $request->search;
        $roles = Role::search($searchTerm)->with('permissions')->with('users')->paginate(20);
        $arr['roles'] = $roles;
        return view('layouts.dashboard.roles.index', $arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = ['users', 'categories', 'movies', 'roles', 'settings'];
        $permissions = ['create', 'read', 'update', 'delete'];
        $arr['models'] = $models;
        $arr['permissions'] = $permissions;

        return view('layouts.dashboard.roles.create', $arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(RoleRequest $request)
    {

            $role = Role::create(
                $request->all()
            );

            $role->attachPermissions($request->permissions);
            return redirect( route('roles.index') )->with('message', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $models = ['users', 'categories', 'movies', 'roles', 'settings'];
        $permissions = ['create', 'read', 'update', 'delete'];
        $arr['role'] = $role;
        $arr['models'] = $models;
        $arr['permissions'] = $permissions;
        return view('layouts.dashboard.roles.edit', $arr);
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
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => "required|unique:roles,name,$role->id",
            'display_name' => 'required',
            'permissions' => 'required'
        ]);

        $role->update(
            $request->all()
        );

        $role->syncPermissions($request->permissions);

        return redirect( route('roles.index') )->with('message', 'Role updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return redirect( route('roles.index') )->with('message','Role deleted successfully');
    }
}
