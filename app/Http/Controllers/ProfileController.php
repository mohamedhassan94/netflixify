<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(){
        $user = Auth::user();
        $arr['user'] = $user;
        return view('edit_profile',$arr);
    }

    protected function check($password){
        if( Hash::check( $password , Auth::user()->password ) ){
            return true;
        }else{
            return false;
        }
    }


    public function update(Request $request){

        $user = Auth::user();

        $request->validate([
            'name' => "required",
            'email' => "required|email|unique:users,email,$user->id",
            'current_password' => 'required',
            'password' => 'confirmed|min:8|string|nullable',

        ]);

        $current_password = $request->current_password;

        if( $this->check($current_password) ){

            $user->update( [
                'name'=>$request->name,
                'email'=>$request->email,
            ] );

            if( $request->password != null && $request->password === $request->password_confirmation ){
                $user->password = Hash::make($request->password);
                $user->update();
            }

            return back()->with('success', 'Profile updated successfully!');

        }else{
            return back()->with('failure', 'The password you have entered is incorrect!');
        }
        
        
    }
}
