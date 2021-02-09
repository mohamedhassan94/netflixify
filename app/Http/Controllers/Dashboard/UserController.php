<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public function __construct()
{
    $this->middleware('permission:read_users')->only([ 'index' ]);
    $this->middleware('permission:create_users')->only([ 'create' , 'store' ]);
    $this->middleware('permission:update_users')->only([ 'edit' , 'update']);
    $this->middleware('permission:delete_users')->only(['destroy']);
}

    public function index(Request $request)
    {
        $searchTerm = $request->search;

        $users = User::search( $searchTerm )->whereHas( 'roles', function($q){
            return $q->where('name', '!=', 'super_admin');
        } )->paginate(20);

        $arr['users'] = $users;

        return view('layouts.dashboard.users.index', $arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::whereNotIn('name', ['super_admin', 'admin', 'user'])->get();
        $arr['roles'] = $roles;
        return view('layouts.dashboard.users.create', $arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request->merge([
            'password' => bcrypt( $request->password )
        ]);

        $user = User::create( $request->all() );

        $user->attachRoles(['admin', $request->role_id]);

        return redirect( route('users.index') )->with('message', 'User created successfully');
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
        $user = User::findOrFail($id);
        $roles = Role::whereNotIn('name', ['super_admin', 'admin'])->get();
        $arr['user'] = $user;
        $arr['roles'] = $roles;

        return view('layouts.dashboard.users.edit', $arr);
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
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$user->id",
            'role_id' => 'required'
            ]);
        $user->update( $request->all() );

        if($request->role_id == 3){
            $user->syncRoles( [$request->role_id] );
        }else{
            $user->syncRoles( ['admin', $request->role_id] );
        }


        return redirect( route('users.index') )->with('message', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect( route('users.index') )->with('message','User deleted successfully');
    }
}
